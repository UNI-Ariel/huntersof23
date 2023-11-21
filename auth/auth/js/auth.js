const showPassChk = document.getElementById('show-pass');
       
const passwordInput = document.querySelectorAll('input[type="password"]'); // Seleccionar el campo de contraseña

showPassChk.addEventListener('change', () => {
    passwordInput.forEach ( (field) => {
        if(field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    });
});