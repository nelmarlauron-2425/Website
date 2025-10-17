document.addEventListener('DOMContentLoaded', () => {
  const passwordField = document.getElementById('password');
  const loginForm = document.querySelector('form');

  // --- Wrap password input in a relative container ---
  const wrapper = document.createElement('div');
  wrapper.style.position = 'relative';
  wrapper.style.display = 'inline-block';
  wrapper.style.width = '100%';

  // Move password field inside wrapper
  passwordField.parentNode.insertBefore(wrapper, passwordField);
  wrapper.appendChild(passwordField);

  // --- 👁️ Eye icon inside field ---
  const eyeIcon = document.createElement('span');
  eyeIcon.innerHTML = '👁️'; // or replace with Font Awesome icon if preferred
  eyeIcon.style.cursor = 'pointer';
  eyeIcon.style.position = 'absolute';
  eyeIcon.style.right = '10px';
  eyeIcon.style.top = '50%';
  eyeIcon.style.transform = 'translateY(-50%)';
  eyeIcon.style.fontSize = '16px';
  eyeIcon.style.userSelect = 'none';
  eyeIcon.style.opacity = '0.7';
  eyeIcon.title = 'Show/Hide Password';

  wrapper.appendChild(eyeIcon);
  passwordField.style.paddingRight = '35px'; // space for icon

  // --- Toggle visibility ---
  eyeIcon.addEventListener('click', () => {
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.innerHTML = '🙈';
    } else {
      passwordField.type = 'password';
      eyeIcon.innerHTML = '👁️';
    }
  });

  // --- Basic validation (if you already have one, keep it) ---
  loginForm.addEventListener('submit', (e) => {
    const email = document.querySelector('input[name="email"]').value.trim();
    const password = passwordField.value.trim();

    if (email === '' || password === '') {
      alert('Email and Password are required.');
      e.preventDefault();
      return false;
    }

    // You can add more validation here if needed
    return true;
  });
});
