<?php
// ✅ Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/style.css/forgotpass.css" />
</head>
<body>
  <div class="container">
    <h3>Forgot Password</h3>
    <p>Enter your email address</p>

    <input type="email" id="email" placeholder="Enter your email address" required />
    <button id="continueBtn">Continue</button>
    <p id="message"></p>

    <a href="login.php" class="link">Back to Login</a>
  </div>

  <script src="/javascript/pass_verification.js"></script>
</body>
</html>
