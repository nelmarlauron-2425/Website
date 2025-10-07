<?php
session_start();

// ✅ Fix 1: Properly load error messages from session
$errors = [
  'login'  => $_SESSION['LoginError']        ?? '',
  'signup' => $_SESSION['RegistrationError'] ?? '',
];

// ✅ Fix 2: Remember which form was active (login or signup)
$activeForm = $_SESSION['activeForm'] ?? 'signup-form';

// ✅ Optional: Keep errors active until displayed (no session_unset here)
// Use session_unset() only *after* showing messages
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
      <li><a href="index.php">Home</a></li>
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

      <!-- ✅ Display signup error if any -->
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
          <option value="Admin">Admin</option>
        </select>

        <button type="submit" name="signup">Sign Up</button>

        <p>Already have an account? 
          <a href="login.php">Log In</a>
        </p>
      </form>
    </div>
  </div>

  <script src="javascript/login.js"></script>
</body>
</html>
<?php
// ✅ Optional: Clear session errors AFTER displaying
session_unset();
?>
<?php 