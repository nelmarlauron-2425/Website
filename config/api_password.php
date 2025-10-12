<?php
/* config/api_password.php */
declare(strict_types=1);
session_start();

require_once __DIR__ . '/dbconfig.php';
require_once __DIR__ . '/sendgrid_mailer.php';
require_once __DIR__ . '/secrets.php';

/* ---------- CORS & Content ---------- */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

function json_out(array $data, int $code=200): void {
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode($data, JSON_UNESCAPED_SLASHES);
  exit;
}
function columnExists(mysqli $db, string $col): bool {
  $sql = "SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'users' AND COLUMN_NAME = ?";
  $stmt = $db->prepare($sql);
  $dbName = DB_NAME;
  $stmt->bind_param('ss', $dbName, $col);
  $stmt->execute(); $stmt->store_result();
  $exists = $stmt->num_rows > 0;
  $stmt->close();
  return $exists;
}
function getJsonOrForm(): array {
  $ctype = $_SERVER['CONTENT_TYPE'] ?? '';
  if (stripos((string)$ctype, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $arr = json_decode($raw ?: '[]', true);
    return is_array($arr) ? $arr : [];
  }
  return $_POST;
}
function generateOtp(int $len=6): string {
  $min = (int) pow(10, $len-1);
  $max = (int) str_repeat('9', $len);
  return (string) random_int($min, $max);
}
function findUserByEmail(mysqli $db, string $email): ?array {
  $stmt = $db->prepare('SELECT id, first_name, last_name, email FROM users WHERE email = ? LIMIT 1');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $res  = $stmt->get_result();
  $row  = $res->fetch_assoc();
  $stmt->close();
  return $row ?: null;
}
function getActiveReset(mysqli $db, int $userId): ?array {
  $now = date('Y-m-d H:i:s');
  $stmt = $db->prepare("SELECT * FROM password_resets WHERE user_id=? AND status='pending' AND expires_at > ? ORDER BY id DESC LIMIT 1");
  $stmt->bind_param('is', $userId, $now);
  $stmt->execute();
  $res  = $stmt->get_result();
  $row  = $res->fetch_assoc();
  $stmt->close();
  return $row ?: null;
}

$hasPasswordHash = columnExists($mysqli, 'password_hash');
$hasPassword     = columnExists($mysqli, 'password');

$body   = getJsonOrForm();
$action = $_GET['action'] ?? $body['action'] ?? '';

/* ---------- ACTION: request_reset ---------- */
if ($action === 'request_reset') {
  $email = trim((string)($body['email'] ?? ''));
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(['ok'=>false,'error'=>'Valid email is required.'], 422);
  }

  $user = findUserByEmail($mysqli, $email);
  if (!$user) {
    // Never leak whether email exists
    json_out(['ok'=>true,'message'=>'If that email exists, an OTP has been sent.']);
  }

  // If there’s already a valid pending code, avoid spamming a new one.
  $existing = getActiveReset($mysqli, (int)$user['id']);
  if ($existing) {
    json_out(['ok'=>true,'message'=>'An OTP was recently sent. Please check your inbox or spam.']);
  }

  $otp       = generateOtp(6);
  $otpHash   = password_hash($otp, PASSWORD_DEFAULT);
  $expiresAt = date('Y-m-d H:i:s', time() + 10 * 60); // 10 minutes

  $stmt = $mysqli->prepare("INSERT INTO password_resets (user_id, otp_hash, expires_at) VALUES (?, ?, ?)");
  $stmt->bind_param('iss', $user['id'], $otpHash, $expiresAt);
  if (!$stmt->execute()) {
    $e = $stmt->error;
    $stmt->close();
    $msg = 'Could not start reset.';
    if (APP_DEBUG) $msg .= " DB: $e";
    json_out(['ok'=>false,'error'=>$msg], 500);
  }
  $stmt->close();

  // Build HTML email
  $safeName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
  if ($safeName === '') $safeName = 'there';
  $subject = 'Your ArtTrack OTP Code';
  $html = '
  <div style="font-family:Arial,Helvetica,sans-serif;max-width:520px;margin:auto;padding:24px;border:1px solid #eee;border-radius:10px">
    <h2 style="margin-top:0">Password Reset</h2>
    <p>Hi '.htmlspecialchars($safeName).',</p>
    <p>Use the OTP below to reset your ArtTrack password. This code expires in <strong>10 minutes</strong>.</p>
    <div style="font-size:28px;letter-spacing:6px;font-weight:bold;text-align:center;margin:18px 0">'.htmlspecialchars($otp).'</div>
    <p>If you did not request this, you can ignore this email.</p>
    <p style="color:#888">Thanks,<br/>ArtTrack Team</p>
  </div>';

  $sent = sg_send_mail($user['email'], $safeName, $subject, $html);
  if (!$sent) {
    $msg = 'Failed to send OTP email (SendGrid).';
    if (APP_DEBUG) $msg .= ' Check API key, verified sender, php_curl or allow_url_fopen.';
    json_out(['ok'=>false,'error'=>$msg], 500);
  }

  // Success
  $dbg = APP_DEBUG ? ['dev_note' => 'On local, DEV_MASTER_OTP='.DEV_MASTER_OTP.' works too.'] : [];
  json_out(['ok'=>true,'message'=>'If the email exists, an OTP has been sent.'] + $dbg);
}

/* ---------- ACTION: verify_otp_change ---------- */
if ($action === 'verify_otp_change') {
  $email   = trim((string)($body['email'] ?? ''));
  $otpIn   = trim((string)($body['otp'] ?? ''));
  $newPass = (string)($body['new_password'] ?? '');

  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(['ok'=>false,'error'=>'Valid email is required.'], 422);
  }
  if ($otpIn === '' || strlen($otpIn) !== 6) {
    json_out(['ok'=>false,'error'=>'OTP must be 6 digits.'], 422);
  }
  if (strlen($newPass) < 8) {
    json_out(['ok'=>false,'error'=>'new_password must be at least 8 characters.'], 422);
  }

  $user = findUserByEmail($mysqli, $email);
  if (!$user) { json_out(['ok'=>false,'error'=>'Invalid email or OTP.'], 401); }

  $reset = getActiveReset($mysqli, (int)$user['id']);
  if (!$reset) { json_out(['ok'=>false,'error'=>'No active reset or OTP expired.'], 401); }

  // Too many attempts?
  if ((int)$reset['attempts'] >= 5) {
    $stmt = $mysqli->prepare("UPDATE password_resets SET status='expired' WHERE id=?");
    $stmt->bind_param('i', $reset['id']); $stmt->execute(); $stmt->close();
    json_out(['ok'=>false,'error'=>'Too many attempts. Request a new OTP.'], 429);
  }

  // Accept DEV master OTP locally
  $valid = false;
  if (DEV_MASTER_OTP && $otpIn === DEV_MASTER_OTP) {
    $valid = true;
  } else {
    $valid = password_verify($otpIn, $reset['otp_hash']);
  }

  if (!$valid) {
    $stmt = $mysqli->prepare("UPDATE password_resets SET attempts = attempts + 1 WHERE id=?");
    $stmt->bind_param('i', $reset['id']); $stmt->execute(); $stmt->close();
    json_out(['ok'=>false,'error'=>'Invalid OTP.'], 401);
  }

  // Update password
  $hash = password_hash($newPass, PASSWORD_DEFAULT);
  if ($hasPasswordHash) {
    $stmt = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
  } else {
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
  }
  $stmt->bind_param('si', $hash, $user['id']);
  if (!$stmt->execute()) {
    $e = $stmt->error; $stmt->close();
    $msg = 'Password update failed.';
    if (APP_DEBUG) $msg .= " DB: $e";
    json_out(['ok'=>false,'error'=>$msg], 500);
  }
  $stmt->close();

  // Mark reset as used
  $stmt = $mysqli->prepare("UPDATE password_resets SET status='used' WHERE id=?");
  $stmt->bind_param('i', $reset['id']); $stmt->execute(); $stmt->close();

  json_out(['ok'=>true,'message'=>'Password changed successfully.']);
}

/* ---------- default ---------- */
json_out(['ok'=>false,'error'=>'Unknown action. Use ?action=request_reset or ?action=verify_otp_change'], 400);
