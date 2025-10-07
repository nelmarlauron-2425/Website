<?php
session_start();
require_once __DIR__ . '/dbconfig.php';
//It get the needed requirements from the users or admin.
if (isset($_POST['signup'])) {//it checks if the users or admin is clicking the sign up button.
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT);// it encrypts the password so hindi kapag makikita naten sa database yung password is rumbled number or letters.
    $role       = trim($_POST['role']);

    // ito dito chinecheck if yung email is nag eexist na sa database.
    $checkEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['RegistrationError'] = "Email already exists.";
        $_SESSION['activeForm'] = 'signup-form';
    } else {
        // 
        $insert = "INSERT INTO users (first_name, last_name, email, password, role) 
                   VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

        if ($stmt->execute()) {
            $_SESSION['RegistrationSuccess'] = "Account created successfully! You can now log in.";
        } else {
            $_SESSION['RegistrationError'] = "Error: Could not register user. Please try again.";
        }
    }

    header("Location: ../index/login.php");
    exit();
}

// ✅ LOGIN PROCESS
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['name']  = $user['first_name'];
            $_SESSION['email'] = $user['email'];

            // ✅ Redirect based on role
            switch (strtolower($user['role'])) {
                case 'admin':
                    header("Location: ../index/admin_page.php");
                    break;
                case 'artist':
                    header("Location: ../index/artist_page.php");
                    break;
                default:
                    header("Location: ../index/buyer_page.php");
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

    header("Location: ../index/login.php");
    exit();
}

// ✅ Close the database connection
$conn->close();
?>
<?php   