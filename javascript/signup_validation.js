document.addEventListener('DOMContentLoaded', () => {
  const passwordField = document.getElementById('password');
  const strengthText = document.createElement('small');
  strengthText.id = 'password-strength';
  strengthText.style.display = 'block';
  strengthText.style.marginTop = '4px';
  strengthText.style.fontWeight = '600';
  strengthText.style.fontSize = '13px';

  // --- Wrap password input in a relative container ---
  const wrapper = document.createElement('div');
  wrapper.style.position = 'relative';
  wrapper.style.display = 'inline-block';
  wrapper.style.width = '100%';

  // move password input inside wrapper
  passwordField.parentNode.insertBefore(wrapper, passwordField);
  wrapper.appendChild(passwordField);

  // append strength text after wrapper
  wrapper.parentNode.appendChild(strengthText);

  const signupForm = document.querySelector('form');

  // --- 👁️ Eye Icon Inside Field ---
  const eyeIcon = document.createElement('span');
  eyeIcon.innerHTML = '👁️'; // or use Font Awesome <i class="fa fa-eye"></i>
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
  passwordField.style.paddingRight = '35px'; // space for the icon

  // --- Toggle password visibility ---
  eyeIcon.addEventListener('click', () => {
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.innerHTML = '🙈';
    } else {
      passwordField.type = 'password';
      eyeIcon.innerHTML = '👁️';
    }
  });

  // --- Check password strength live ---
  passwordField.addEventListener('input', () => {
    const password = passwordField.value;
    const strength = checkPasswordStrength(password);

    if (password.length === 0) {
      strengthText.textContent = '';
      strengthText.style.color = '';
    } else if (strength === 'Weak') {
      strengthText.textContent = 'Weak';
      strengthText.style.color = 'red';
    } else if (strength === 'Medium') {
      strengthText.textContent = 'Medium';
      strengthText.style.color = 'orange';
    } else {
      strengthText.textContent = 'Strong';
      strengthText.style.color = 'green';
    }
  });

  // --- Form validation before submit ---
  signupForm.addEventListener('submit', function (e) {
    const firstName = document.querySelector('input[name="first_name"]').value.trim();
    const lastName = document.querySelector('input[name="last_name"]').value.trim();
    const password = passwordField.value.trim();

    if (firstName === '' || lastName === '') {
      alert("First Name and Last Name cannot be blank.");
      e.preventDefault();
      return false;
    }

    if (password.length < 6) {
      alert("Password must be at least 6 characters long.");
      e.preventDefault();
      return false;
    }

    const strongPass = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/;
    if (!strongPass.test(password)) {
      alert("Password must contain letters, numbers, and at least one special character.");
      e.preventDefault();
      return false;
    }

    return true;
  });

  // --- Helper function ---
  function checkPasswordStrength(password) {
    let strengthScore = 0;

    if (password.length >= 6) strengthScore++;
    if (/[A-Z]/.test(password)) strengthScore++;
    if (/[0-9]/.test(password)) strengthScore++;
    if (/[@$!%*#?&]/.test(password)) strengthScore++;
    if (password.length >= 10) strengthScore++; // extra boost for long strong passwords

    if (strengthScore <= 2) return 'Weak';
    else if (strengthScore === 3 || strengthScore === 4) return 'Medium';
    else return 'Strong';
  }
});
