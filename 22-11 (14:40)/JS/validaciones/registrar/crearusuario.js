function validarregistrodeusuarioscliente(event) {
    
    console.log("Entrando a la función validarregistrodeusuarioscliente");
    // Obtener los valores de los campos comunes
    var nombre_usuario = document.getElementById('nombre_usuario').value;
    var password = document.getElementById('password').value;
    var correo = document.getElementById('correo').value;

    // Verificar si es una empresa o un alumno
    var esEmpresa = document.getElementById('empresabtn').checked;
    var esAlumno = document.getElementById('alumnobtn').checked;

    var fecha_nacimiento; // declárala aquí

    if (esEmpresa) {
        
    console.log("Entrando a empresa");
        var cif = document.getElementById('CIF').value;
        var nombre_empresa = document.getElementById('nombre_empresa').value;
        var direccion = document.getElementById('DIRECCION').value;
        var descripcion = document.getElementById('descripcion').value;
        var telefono = document.getElementById('telefono').value;
        var poblacion = document.getElementById('poblacionempresa').value;
        var sector = document.getElementById('sector').value;

        // Realizar las validaciones correspondientes
        if (!validarCIF(cif)) {
            alert("El CIF no es válido");
            event.preventDefault(); // Evita que el formulario se envíe
            console.log("Entrando a cif");
            return; // Evitar que el formulario se envíe si la validación falla
        }

        // Agregar más validaciones si es necesario
    } else if (esAlumno) {
        var dni = document.getElementById('dni').value;
        var nombre = document.getElementById('nombre').value;
        var apellido = document.getElementById('apellido').value;
        fecha_nacimiento = document.getElementById('Fecha_nacimiento').value;
        var telefono_alumno = document.getElementById('TELEFONO').value;
        var conducir = document.getElementById('conducir').checked;
        var actitudes = document.getElementById('actitudes').value;
        var aptitudes = document.getElementById('aptitudes').value;
        var poblacion_alumno = document.getElementById('poblacionalumno').value;

        // Realizar las validaciones correspondientes
        if (!validarDNI(dni)) {
            alert("El DNI no es válido");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }

        // Validar formato de fecha común a ambos casos
        if (!validarFormatoFecha(fecha_nacimiento)) {
            alert("El formato de la fecha no es válido");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }
    }

    // Validar contraseña común a ambos casos
    if (!validarContrasena(password)) {
        alert("La contraseña no es válida");
        event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
        return false;
    }

    
    return true;
    // Aquí puedes agregar más lógica según tus necesidades
}


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

// function validarCIF(cif) {
//     // Patrón de CIF (corregido)
//     var cifPattern = /^[ABCDEFGHJKLMNPQRSUVWabcdefghjklmnpqrsuvw]\d{7}([0-9A-HJ-NP-Z]|[0-9])$/;

//     // Validar el CIF
//     return cifPattern.test(cif);
// }

function validarCIF(cif) {
    // Patrón de la expresión regular
    var patron = /^[A-Za-z]\d{7}[A-Za-z0-9]$/;

    // Comprobación de la coincidencia
    if (patron.test(cif)) {
        return true;
    } else {
        return false;
    }
}

function validarContrasena(contrasena) {
    // Verificar que la contraseña tenga al menos una mayúscula
    if (!/[A-Z]/.test(contrasena)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos una minúscula
    if (!/[a-z]/.test(contrasena)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos un número
    if (!/\d/.test(contrasena)) {
        return false;
    }

    // Verificar que la contraseña tenga al menos un carácter especial
    if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(contrasena)) {
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

