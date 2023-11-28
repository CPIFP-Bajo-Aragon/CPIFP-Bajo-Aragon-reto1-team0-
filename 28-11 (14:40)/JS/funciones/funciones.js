function validarDatosAlumnoAdmin(){
    // Obtener los valores de los campos del formulario
        var nombreUsuario = document.getElementById('nombre_usuario').value;
        var contraseña = document.getElementById('contraseña').value;
        var email = document.getElementById('email').value;
        var dni = document.getElementById('dni').value;
        var nombre = document.getElementById('nombre').value;
        var fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    

    // Verificar campos obligatorios
        if (nombreUsuario === '' || contraseña === '' || email === '' || dni === '' || nombre === '' || fechaNacimiento === '') {
            alert("Todos los campos marcados como obligatorios deben estar llenos.");
            return false;
        }

    // Verificar formato de fecha de nacimiento
        if (!validarFormatoFechaNacimiento(fechaNacimiento)) {
            alert("La fecha de nacimiento es válida.");
            return false;
        }

    // Verifica que el dni es valido
        if (!validarDNI(dni)) {
            alert("El DNI no es válido.");
            return false;
        }
    
    // Verifica que la contraseña es valida
        if (!validarContrasena(contraseña)) {
            alert("La contraseña es válida.");
            return false;
        }

    // Si todas las validaciones pasan, retorna true
        return true;

}

function validarDatosEmpresaAdmin(){
    // Obtener los valores de los campos del formulario
        var nombreUsuario = document.getElementById('nombre_usuario').value;
        var contraseña = document.getElementById('contraseña').value;
        var email = document.getElementById('email').value;
        var cif = document.getElementById('cif').value;
        var nombre = document.getElementById('nombre').value;

    // Verificar campos obligatorios
        if (nombreUsuario === '' || contraseña === '' || email === '' || cif === '' || nombre === '') {
            alert("Todos los campos marcados como obligatorios deben estar llenos.");
            return false;
        }

    //verifica que el cif es valido
        if (!validarCIF(cif)) {
            alert("El DNI no es válido.");
            return false;
        }
    //verifica que la contraseña es valida
        if (!validarContrasena(contraseña)) {
            alert("La contraseña es válida.");
            return false;
        }

    // Si todas las validaciones pasan, retorna true
        return true;

}

function validadorTelefono(telefono) {
    // Eliminar cualquier espacio en blanco en el número de teléfono
    const telefonoLimpio = telefono.replace(/\s/g, '');

    // Expresión regular para validar el número de teléfono
    const telefonoPattern = /^[0-9+\-\(\)]+$/;

    // Comprobar si el número de teléfono cumple con la expresión regular
    if (telefonoPattern.test(telefonoLimpio)) {
        alert('Número de teléfono válido:', telefonoLimpio);
        return true;
    } else {
        alert('Número de teléfono no válido:', telefonoLimpio);
        return false;
    }
}


function validarDNI(dni) {
    // Eliminar espacios en blanco al principio y al final del DNI
        dni = dni.trim();

    // Verificar que el DNI tiene la longitud adecuada
        if (dni.length !== 8 && dni.length !== 9) {
            return false;
        }

    // Verifica que los primeros 8 caracteres son numeros
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

    // Patrón de CIF, comprueba que el primer caracteres es una letra, que despues le sigues 7 caracteres que son o bien una letra de la A a la J o un numero
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
    // Verificar que la fecha tenga el formato adecuado (año-mes-dia)
        if (!/^(\d{4})-(\d{2})-(\d{2})$/.test(fecha)) {
            return false;
        }

    // Si pasa la validación, la fecha  es válida
        return true;
}