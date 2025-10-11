<?php
if (!isset($conn) || !$conn instanceof mysqli) {
    $host     = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'arttrack_db';

    // First, try to connect without selecting database to check if it exists
    $temp_conn = new mysqli($host, $username, $password);
    
    if ($temp_conn->connect_error) {
        die("MySQL connection failed: " . $temp_conn->connect_error);
    }

    // Check if database exists
    $result = $temp_conn->query("SHOW DATABASES LIKE '$database'");
    
    if ($result->num_rows == 0) {
        // Database doesn't exist, create it
        if ($temp_conn->query("CREATE DATABASE $database") === TRUE) {
            echo "Database created successfully. ";
            
            // Now create the users table
            $temp_conn->select_db($database);
            $create_table = "CREATE TABLE users (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'artist', 'buyer') DEFAULT 'buyer',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            if ($temp_conn->query($create_table) === TRUE) {
                echo "Users table created successfully.";
            } else {
                die("Error creating table: " . $temp_conn->error);
            }
        } else {
            die("Error creating database: " . $temp_conn->error);
        }
    }
    
    $temp_conn->close();

    // Now create the main connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Set charset to avoid encoding issues
    $conn->set_charset("utf8mb4");
}
?>