function validarDNI(dni) {
    // Eliminar espacios en blanco al principio y al final del DNI
    dni = dni.trim();

    // Verificar que el DNI tiene la longitud adecuada
    if (dni.length !== 8 && dni.length !== 9) {
        return false;
    }

    // Verificar que todos los caracteres son dígitos
    if (!/^\d+$/.test(dni.slice(0, -1))) {
        return false;
    }

    // Verificar que la letra sea válida (solo si el DNI tiene 9 caracteres)
    if (dni.length === 9) {
        var letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        var letraCalculada = letrasValidas.charAt(parseInt(dni.slice(0, -1)) % 23);
        if (letraCalculada !== dni.charAt(8).toUpperCase()) {
            return false;
        }
    }

    // Si pasa todas las validaciones, el DNI es válido
    return true;
}

function validarCIF(cif) {
    // Obtener el valor del CIF desde el input
    var cif = document.getElementById("cifInput").value;

    // Patrón de CIF (solo para este ejemplo)
    var cifPattern = /^[ABCDEFGHJKLMNPQRSUVWabcdefghjklmnpqrsuvw]\d{7}([0-9A-J]|[0-9])$/;

    // Validar el CIF
    if (cifPattern.test(cif)) {
        alert("El CIF es válido");
    } else {
        alert("El CIF no es válido");
    }
}

function validarContrasena(contrasena) {
    // Verificar que la contraseña tenga al menos una mayúscula
    if (!/[A-Z]/.test(contraseña)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos una minúscula
    if (!/[a-z]/.test(contraseña)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos un número
    if (!/\d/.test(contraseña)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos un carácter especial
    if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(contraseña)) {
        return false;
    }

    // Si pasa todas las validaciones, la contraseña es válida
    return true;
}

function validarFormatoFecha(fecha) {
    // Verificar que la fecha tenga el formato adecuado (YYYY-MM-DD)
    if (!/^(\d{4})-(\d{2})-(\d{2})$/.test(fecha)) {
        return false;
    }

    // Si pasa la validación, la fecha  es válida
    return true;
}