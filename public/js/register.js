const form = document.getElementById('registerForm');
const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('password_confirmation'); // IDをLaravelに合わせました
const passwordError = document.getElementById('passwordError');

function validatePasswords() {
  const pw = passwordInput.value;
  const confirm = confirmInput.value;
  if (confirm && pw !== confirm) {
    confirmInput.classList.add('error');
    passwordError.style.display = 'flex';
    return false;
  } else {
    confirmInput.classList.remove('error');
    passwordError.style.display = 'none';
    return true;
  }
}

confirmInput.addEventListener('input', validatePasswords);
passwordInput.addEventListener('input', validatePasswords);

form.addEventListener('submit', (e) => {
  const isMatch = validatePasswords();
  const pw = passwordInput.value;

  if (pw.length < 8 || !isMatch) {
    e.preventDefault(); // 入力不備がある場合のみ送信を止める
    if (pw.length < 8) passwordInput.classList.add('error');
  }
  // 入力OKなら、そのままLaravelのaction先にPOSTされます
});