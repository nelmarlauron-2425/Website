<?php
session_start();

$errors = [
  'login'  => $_SESSION['LoginError']        ?? '',
  'signup' => $_SESSION['RegistrationError'] ?? '',
];

$activeForm = $_SESSION['activeForm'] ?? 'signup-form';

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
  <title>Sign Up - ArtTrack</title>
  <link rel="stylesheet" href="../style.css/login_signup.css">
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <span class="logo-text">ArtTrack</span>
    </div>
    <ul class="nav-links">
      <li><a href="../index.php">Home</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="signup.php" class="active">Sign Up</a></li>
    </ul>
  </nav>

  <div class="container">
    <div class="box image-box">
      <img src="../images/Logo.png" alt="logo" class="placeholder-img">
    </div>

    <div class="box form-box <?= isActive('signup-form', $activeForm) ?>" id="signup-form">
      <h1>Sign Up</h1>

      <?= showError($errors['signup']); ?>

      <form action="../config/login_register.php" method="post">
        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <div class="password-container">
          <input type="password" name="password" id="password" required>
          <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
        </div>

        <label>Role</label>
        <select name="role" required>
          <option value="" disabled selected>---Select Role---</option>
          <option value="Buyer">Buyer</option>
          <option value="Artist">Artist</option>
        </select>

        <button type="submit" name="signup">Sign Up</button>

        <p>Already have an account? 
          <a href="login.php">Log In</a>
        </p>
      </form>
    </div>
  </div>
  <script src="/javascript/signup_validation.js"></script>
</body>
</html>
<?php
// Clear session messages after displaying them
unset($_SESSION['LoginError']);
unset($_SESSION['RegistrationError']);
unset($_SESSION['activeForm']);
?>