function validarRecuperarContraseña(event) {
    

    // Obtener los valores de los campos
    var usuario = document.getElementById('usuario').value;
    var correo = document.getElementById('correo').value;
    var newPasword = document.getElementById('NewPasword').value;
    var otraVezNP = document.getElementById('OtraVezNP').value;

    // Validar que los campos no estén vacíos
    if (usuario === '' || correo === '' || newPasword === '' || otraVezNP === '') {
        alert('Todos los campos son obligatorios');
        // Evitar que la página se recargue automáticamente
        event.preventDefault();
        return false;

    }

    // Validar que las contraseñas coincidan
    if (newPasword !== otraVezNP) {
        alert('Las contraseñas no coinciden');
        // Evitar que la página se recargue automáticamente
        event.preventDefault();
        return false;
    }

    // Aquí puedes agregar código adicional, por ejemplo, enviar datos mediante AJAX
    return true;
}