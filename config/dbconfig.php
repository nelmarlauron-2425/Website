<?php
/* config/dbconfig.php */
declare(strict_types=1);

require_once __DIR__ . '/secrets.php'; // for APP_DEBUG

// XAMPP defaults (adjust if you set a root password)
const DB_HOST = '127.0.0.1';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'arttrack';
const DB_PORT = 3306;

mysqli_report(MYSQLI_REPORT_OFF); // avoid PHP warnings

$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($mysqli->connect_errno) {
  $msg = 'Database connection failed.';
  if (APP_DEBUG) { $msg .= ' Error: ' . $mysqli->connect_error; }
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(['ok'=>false,'error'=>$msg]);
  exit;
}
$mysqli->set_charset('utf8mb4');

/** Auto-create password_resets table if missing (stops 500 on first use) */
$mysqli->query(
  "CREATE TABLE IF NOT EXISTS password_resets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    otp_hash VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    status ENUM('pending','used','expired','cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (expires_at)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
);
