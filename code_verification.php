<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Code Verification</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h3>Code Verification</h3>
    <p>We’ve sent a password reset code to your email.</p>

    <input type="text" id="otpcode" placeholder="Enter code" maxlength="6" required />
    <input type="password" id="newPassword" placeholder="Enter new password" required />
    <button id="submitBtn">Submit</button>

    <p id="message"></p>
  </div>

  <script src="javascript/code_verification.js"></script>
</body>
</html>
