// Seleziona gli elementi delle textbox
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('cpassword');

// Aggiungi l'evento di aggiornamento in tempo reale
confirmPasswordInput.addEventListener('input', function() {
  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  // Verifica la corrispondenza delle password
  if (password !== confirmPassword) {
    confirmPasswordInput.setAttribute = 'error error-text="Username not available"';
  } 
});
