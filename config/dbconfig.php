<?php
if (!isset($conn) || !$conn instanceof mysqli) {
    $host     = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'attrack_db';


    $temp_conn = new mysqli($host, $username, $password);
    
    if ($temp_conn->connect_error) {
        die("MySQL connection failed: " . $temp_conn->connect_error);
    }

    // Check if database exists
    $result = $temp_conn->query("SHOW DATABASES LIKE '$database'");
    
    if ($result->num_rows == 0) {
        if ($temp_conn->query("CREATE DATABASE $database") === TRUE) {
           
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
            
            if ($temp_conn->query($create_table) !== TRUE) {
                error_log("Error creating table: " . $temp_conn->error);
                die("Error creating table. Check server log.");
            }
        } else {
            error_log("Error creating database: " . $temp_conn->error);
            die("Error creating database. Check server log.");
        }
    }
    
    $temp_conn->close();

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Set charset to avoid encoding issues
    $conn->set_charset("utf8mb4");
}


?>