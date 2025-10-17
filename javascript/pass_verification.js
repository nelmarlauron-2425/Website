document.getElementById('continueBtn').addEventListener('click', async () => {
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message');

  if (!email) {
    message.textContent = "Please enter your email.";
    return;
  }

  // Send to backend
  const formData = new FormData();
  formData.append('email', email);

  try {
    const res = await fetch('api/forgot_password.php', {   // no leading slash
      method: 'POST',
      body: formData
    });
    const data = await res.json();
    message.textContent = data.message;
    message.style.color = data.success ? "green" : "red";
  } catch (err) {
    message.textContent = "Something went wrong. Please try again.";
    message.style.color = "red";
  }
});
