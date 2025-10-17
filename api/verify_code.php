<?php
declare(strict_types=1);
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/dbconfig.php'; // your database connection

$otp = trim($_POST['otpcode'] ?? '');
$newPassword = trim($_POST['newPassword'] ?? '');

if (empty($otp) || empty($newPassword)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Optional: hash password securely
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

// Check if code (token/OTP) exists and is not expired
$stmt = $pdo->prepare("SELECT email FROM users WHERE reset_token = ? AND reset_expires > NOW()");
$stmt->execute([$otp]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired code']);
    exit;
}

// Update password and clear the reset token
$update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
$update->execute([$hashed, $user['email']]);

echo json_encode(['success' => true, 'message' => 'Password has been reset successfully!']);
