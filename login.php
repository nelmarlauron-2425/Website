<?php
session_start();

$errors = [
  'login'  => $_SESSION['LoginError'] ?? '',
  'signup' => $_SESSION['RegistrationError'] ?? '',
];

$activeForm = $_SESSION['activeForm'] ?? 'login-form';

// Don't unset session here - we need the errors to display
function showError($error) {
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActive($form, $activeForm) {
  return $form === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ArtTrack</title>
  <link rel="stylesheet" href="../style.css/login_signup.css">
</head>
<body>
  <nav class="navbar">
  <div class="nav-left">
    <span class="logo-text">ArtTrack</span>
  </div>
  <div class="nav-links">
      <li><a href="../index.php">Home</a></li>
      <li><a href="login.php" class="active">Login</a></li>
      <li><a href="signup.php">Sign Up</a></li>
  </div>
</nav>


  <!-- ✅ Login Container -->
  <div class="container">
    <div class="box image-box">
      <img src="../images/Logo.png" 
        alt="ArtTrack logo featuring stylized brush strokes and bold ArtTrack text" 
        class="placeholder-img">
    </div>

    <div class="box form-box <?= isActive('login-form', $activeForm) ?>" id="login-form">
      <h1>Login</h1>
      <?= showError($errors['login']) ?>

      <form action="../config/login_register.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <div class="password-container">
          <input type="password" name="password" id="password" required>
          <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
        </div>

        <div class="options">
          <a href="#">Forgot Password?</a>
        </div>

        <button type="submit" name="login">Log in</button>

        <p>Don't have an account? 
          <a href="signup.php">Sign up now</a>
        </p>
      </form>
    </div>
  </div>

  <script src="../javascript/login.js"></script>
</body>
</html>
<?php
// Clear session messages after displaying them
unset($_SESSION['LoginError']);
unset($_SESSION['RegistrationError']);
unset($_SESSION['activeForm']);
?>