document.getElementById('submitBtn').addEventListener('click', async () => {
  const otpcode = document.getElementById('otpcode').value.trim();
  const newPassword = document.getElementById('newPassword').value.trim();
  const message = document.getElementById('message');

  if (!otpcode || !newPassword) {
    message.textContent = "Please enter all fields.";
    message.style.color = "red";
    return;
  }

  const formData = new FormData();
  formData.append('otpcode', otpcode);
  formData.append('newPassword', newPassword);

  try {
    const res = await fetch('/api/verify_code.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();
    message.textContent = data.message;
    message.style.color = data.success ? "green" : "red";

    if (data.success) {
      // Redirect to login after success
      setTimeout(() => {
        window.location.href = 'login.php';
      }, 2000);
    }
  } catch (err) {
    message.textContent = "Error connecting to server.";
    message.style.color = "red";
  }
});
