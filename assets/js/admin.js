const togglePassword = document.getElementById('toggle-password');
const passwordField = document.getElementById('pass');

togglePassword.addEventListener('click', function () {
  // Toggle the input type between 'password' and 'text'
  const type = passwordField.type === 'password' ? 'text' : 'password';
  passwordField.type = type;

  // Toggle the icon class between "eye" and "eye-slash"
  this.classList.toggle('bi-eye');
  this.classList.toggle('bi-eye-slash');
});