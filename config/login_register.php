<?php
session_start();
require_once __DIR__ . '/dbconfig.php';

// Check if database connection is established
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed: " . (isset($conn) ? $conn->connect_error : "Connection not established"));
}

// =============================
// SIGNUP PROCESS
// =============================
if (isset($_POST['signup'])) {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role       = trim($_POST['role']);

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    
    if ($stmt === false) {
        $_SESSION['RegistrationError'] = "Database error: " . $conn->error;
        $_SESSION['activeForm'] = 'signup-form';
        header("Location: ../login.php");
        exit();
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['RegistrationError'] = "Email already exists.";
        $_SESSION['activeForm'] = 'signup-form';
    } else {
        // Insert new user
        $insert = "INSERT INTO users (first_name, last_name, email, password, role) 
                   VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        
        if ($stmt === false) {
            $_SESSION['RegistrationError'] = "Database error: " . $conn->error;
            $_SESSION['activeForm'] = 'signup-form';
            header("Location: ../login.php");
            exit();
        }
        
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

        if ($stmt->execute()) {
            $_SESSION['RegistrationSuccess'] = "Account created successfully! You can now log in.";
        } else {
            $_SESSION['RegistrationError'] = "Error: Could not register user. Please try again.";
        }
    }

    header("Location: ../login.php");
    exit();
}

// =============================
// LOGIN PROCESS
// =============================
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        $_SESSION['LoginError'] = "Database error: " . $conn->error;
        $_SESSION['activeForm'] = 'login-form';
        header("Location: ../login.php");
        exit();
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['name']  = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role']  = $user['role']; // Store role in session

            // Redirect based on role
            switch (strtolower($user['role'])) {
                case 'admin':
                    header("Location: ../admin_page.php");
                    break;
                case 'artist':
                    header("Location: ../artist_browser.php");
                    break;
                default:
                    header("Location: ../buyer_browser.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['LoginError'] = "Invalid password.";
            $_SESSION['activeForm'] = 'login-form';
        }
    } else {
        $_SESSION['LoginError'] = "No account found with that email.";
        $_SESSION['activeForm'] = 'login-form';
    }

    header("Location: ../login.php");
    exit();
}

// =============================
// Close DB connection
// =============================
if (isset($conn)) {
    $conn->close();
}
?>
