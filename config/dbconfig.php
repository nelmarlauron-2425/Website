<?php
// Database configuration
if (!isset($conn) || !$conn instanceof mysqli) {
    $host     = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'arttrack';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Optional: Set charset to avoid encoding issues
    $conn->set_charset("utf8mb4");
}
?>
