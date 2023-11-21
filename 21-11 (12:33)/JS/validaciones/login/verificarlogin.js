function validarLogin() {
    var usuario = document.getElementById('usuario').value;
    var password = document.getElementById('password').value;

    if (usuario.trim() === '' || password.trim() === '') {
        alert('Por favor, complete todos los campos.');
        return false; // Evita que el formulario se envíe
    }

    return true; // Permite que el formulario se envíe
}