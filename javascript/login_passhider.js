eyeIcon.addEventListener('click', () => {
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.innerHTML = '🙈';
    } else {
      passwordField.type = 'password';
      eyeIcon.innerHTML = '👁️';
    }
  });