function validarregistroempresaadmin(event) {
    
    console.log("Entrando a la función validarregistrodeusuarioscliente");
    // Obtener los valores de los campos comunes
    var nombre_usuario = document.getElementById('nombre_usuario').value;
    var password = document.getElementById('contraseña').value;
    var correo = document.getElementById('email').value;
    var cif = document.getElementById('cif').value;
    var nombre_empresa = document.getElementById('nombre').value;
    var direccion = document.getElementById('direccion').value;
    var telefono = document.getElementById('telefono').value;

    //Comprobar que todos esos campos estan rellenos
    if (nombre_usuario === "" || password === "" || correo === "" || cif === "" || nombre_empresa === "" || direccion === "" || telefono === "") {
        alert("Por favor, completa todos los campos");
        return false; // Evita que el formulario se envíe
    }

    // Realizar las validaciones correspondientes
        if (!validarCIF(cif)) {
            alert("El CIF no es válido. Tiene que tener una letra al principio y 7 números.");
            event.preventDefault(); // Evita que el formulario se envíe
            return false; // Evitar que el formulario se envíe si la validación falla
        }

    // Validar contraseña común a ambos casos
    if (!validarContrasena(password)) {
        alert("La contraseña es incorrecta. Tiene que contener al menos 1 letra mayúscula, 1  minúscula, 1 número y 1 carácter especial.");
        event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
        return false;
    }

    if (!validartelefono(telefono)) {
        alert("El numero de telefono no es válida");
        event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
        return false;
    }

    
    return true;
    // Aquí puedes agregar más lógica según tus necesidades
}


function validarregistrodealumnosadmin(event) {
    
    console.log("Entrando a la función validarregistrodeusuarioscliente");
    // Obtener los valores de los campos comunes
    var nombre_usuario = document.getElementById('nombre_usuario_alumno').value;
    var password = document.getElementById('contraseña_alumno').value;
    var correo = document.getElementById('email_alumno').value;
    var dni = document.getElementById('dni_alumno').value;
    var nombre = document.getElementById('nombre_alumno').value;
    var apellido = document.getElementById('Apellido_alumno').value;
    var fecha_nacimiento = document.getElementById('Fecha_nacimiento').value;
    var telefono_alumno = document.getElementById('telefono_alumno').value;

    if (nombre_usuario === "" || password === "" || correo === "" || dni === "" || nombre === "" || apellido === "" || fecha_nacimiento === "") {
        alert("Por favor, completa todos los campos");
        return false; // Evita que el formulario se envíe
    }
    // Realizar las validaciones correspondientes
        if (!validarDNI(dni)) {
            console.log("dni mal");
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
    

    // Validar contraseña común a ambos casos
        if (!validarContrasena(password)) {
            alert("La contraseña es incorrecta. Tiene que contener al menos 1 letra mayúscula, 1  minúscula, 1 número y 1 carácter especial.");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }

    //Validar el numero de telefono
        if (!validartelefono(telefono_alumno)) {
            alert("El numero de telefono no es válida");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }    
    return true;
    // Aquí puedes agregar más lógica según tus necesidades
}


function validarregistrooferta(event){
    // Obtener los valores de los campos comunes
        var titulo = document.getElementById('titulobtn').value;
        var Descripcion = document.getElementById('Descripcionbtn').value;
        // var Duracion = document.getElementById('Duracionbtn').value;
        console.log(Duracion);
    //Comprobar que los campos obligatorios estan rellenos
        if (titulo === "" || Descripcion === "") {
            alert("Por favor, completa todos los campos");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }
    // Comprobar que la duracion es correcta
        if (!validarduracion(Duracion)) {
            alert("La duracion del contrato no puede ser inferior o igual a 0");
            event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            return false;
        }
}


//Validar Duracion del contrato
    function validarduracion(duracion){
        if(duracion!="" && parseFloat(duracion)<=0){
            return false;
        }
        return true;
    }

//Validar dni
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

    function validartelefono(telefono){
        // Eliminar espacios en blanco y guiones, si los hay
            telefono = telefono.replace(/\s+/g, '').replace(/-/g, '');

        // Verificar si el número de teléfono tiene exactamente 9 caracteres
            if( telefono.length === 9){
                return true;
            }else{
                return false;
            };
    }

// function validarCIF(cif) {
    function validarCIF(cif) {
        // Patrón de la expresión regular
        var patron = /^[A-Za-z]\d{7}$/;

        // Comprobación de la coincidencia
        if (patron.test(cif)) {
            return true;
        } else {
            return false;
        }
    }

//validar contraseña
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

//Validar formato fecha
    function validarFormatoFecha(fecha) {
        // Verificar que la fecha tenga el formato adecuado (YYYY-MM-DD)
        if (!/^(\d{4})-(\d{2})-(\d{2})$/.test(fecha)) {
            return false;
        }

        // Si pasa la validación, la fecha  es válida
        return true;
    }
