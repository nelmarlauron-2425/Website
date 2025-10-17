<?php
declare(strict_types=1);
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../config/sendgrid_mailer.php';

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

try {
    // Check if email exists
    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'No account found with that email']);
        exit;
    }

    // Generate a reset token and expiry
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Add new columns if missing (optional auto-fix)
    $conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS reset_token VARCHAR(255)");
    $conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS reset_expires DATETIME");

    // Save token
    $update = $conn->prepare("UPDATE users SET reset_token=?, reset_expires=? WHERE email=?");
    $update->bind_param('sss', $token, $expires, $email);
    $update->execute();

    // Build reset link
    $resetLink = "http://localhost/reset_password.php?token=" . urlencode($token);

    // Prepare email
    $subject = "Password Reset Request - ArtTrack";
    $html = "
        <h2>Password Reset</h2>
        <p>Hello {$user['first_name']} {$user['last_name']},</p>
        <p>Click the link below to reset your password (expires in 1 hour):</p>
        <a href='$resetLink'>Reset Password</a>
        <p>If you didn’t request this, please ignore this email.</p>
    ";

    // Send email
    if (sg_send_mail($email, "{$user['first_name']} {$user['last_name']}", $subject, $html)) {
        echo json_encode(['success' => true, 'message' => 'Password reset email sent! Check your inbox.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email. Try again later.']);
    }

} catch (Throwable $e) {
    if (APP_DEBUG) {
        echo json_encode(['success' => false, 'message' => 'Error: '.$e->getMessage()]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Server error.']);
    }
}
