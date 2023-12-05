<?php
//Funcion para insertar alumnos desde el cliente
    function insertaralumnocliente($conexion)
{
    try {

        //Transaccion para que en caso de error en la tabla alumno no inserte nada en usuario
        //ya que si no da error en el nombre usuario como ya existente.
        $conexion->beginTransaction();

        // Obtener la contraseña del formulario y aplicar hash
        $contra = $_POST['password'];
        $contra = password_hash($contra, PASSWORD_DEFAULT);

        // Obtener otros datos del formulario
        $correo = $_POST['correo'];
        $usuario = $_POST['nombre_usuario'];

        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $Fecha_nacimiento = $_POST['Fecha_nacimiento'];
        $conducir = isset($_POST['conducir']) ? 1 : 0;
        $coche = isset($_POST['coche']) ? 1 : 0;

        $actitudes = $_POST['actitudes'];
        $aptitudes = $_POST['aptitudes'];
        $poblacion = $_POST['poblacionSelect'];
        $telefono = $_POST['TELEFONO'];

        // Consulta SQL para validar si el nombre de usuario ya existe
        $ValidarNomUsuario = "SELECT COUNT(*) FROM usuario WHERE nombre_usuario = ?";
        $consultaValidarNomUsuario = $conexion->prepare($ValidarNomUsuario);
        $consultaValidarNomUsuario->bindParam(1, $usuario);
        $consultaValidarNomUsuario->execute();

        // Obtén el resultado de la consulta
        $usuarioExistente = $consultaValidarNomUsuario->fetchColumn();

        if ($usuarioExistente > 0) {
            // El usuario ya existe, muestra un mensaje o realiza alguna acción
            echo "El nombre de usuario ya está en uso. Por favor, elige otro.";
            return;
        }

        // Consulta SQL para validar si el DNI ya existe
        $ValidarDNIexistente = "SELECT COUNT(*) FROM alumno WHERE dni = ?";
        $consultaValidarDNIexistente = $conexion->prepare($ValidarDNIexistente);
        $consultaValidarDNIexistente->bindParam(1, $dni);
        $consultaValidarDNIexistente->execute();

        // Obtén el resultado de la consulta
        $DNIExistente = $consultaValidarDNIexistente->fetchColumn();

        if ($DNIExistente > 0) {
            // El DNI existe, muestra un mensaje o realiza alguna acción
            echo "El DNI ya está en uso. Por favor, use otro.";
            return;
        }

        // Consulta SQL para insertar en la tabla 'usuario'
        $sql = "INSERT INTO usuario(nombre_usuario, password, correo, validado, tipo) 
            VALUES (?, ?, ?, 0, 'alumno')";

        // Preparar la declaración
        $consultaUsuario = $conexion->prepare($sql);

        // Asociar los parámetros
        $consultaUsuario->bindParam(1, $usuario);
        $consultaUsuario->bindParam(2, $contra);
        $consultaUsuario->bindParam(3, $correo);

        // Ejecutar la consulta para insertar en la tabla 'usuario'
        if ($consultaUsuario->execute()) {
            // Obtener el ID del usuario recién insertado
            $idUsuario = $conexion->lastInsertId();

            // Consulta SQL para insertar en la tabla 'alumno'
            $sqlAlumno = "INSERT INTO alumno (`id_usuario`, `dni`, `nombre`, `apellidos`, `fecha_nacim`, `telefono`, `carnet_conducir`, `actitudes`, `aptitudes`, `id_poblacion`, `vehiculo_propio`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar la declaración
            $consultaAlumno = $conexion->prepare($sqlAlumno);

            // Asociar los parámetros
            $consultaAlumno->bindParam(1, $idUsuario);
            $consultaAlumno->bindParam(2, $dni);
            $consultaAlumno->bindParam(3, $nombre);
            $consultaAlumno->bindParam(4, $apellido);
            $consultaAlumno->bindParam(5, $Fecha_nacimiento);
            $consultaAlumno->bindParam(6, $telefono);
            $consultaAlumno->bindParam(7, $conducir);
            $consultaAlumno->bindParam(8, $actitudes);
            $consultaAlumno->bindParam(9, $aptitudes);
            $consultaAlumno->bindParam(10, $poblacion);
            $consultaAlumno->bindParam(11, $coche);

            // Ejecutar la consulta para insertar en la tabla 'alumno'
            if ($consultaAlumno->execute()) {

                //commmit en caso de todo correcto
                $conexion->commit();

                // Si la inserción es exitosa, mostrar mensaje
                echo "Usuario y alumno insertados correctamente";
            } else {
                // Si hay un error al insertar en la tabla 'alumno', eliminar el usuario previamente insertado
                $conexion->rollBack();
                echo "Error al crear Usuario y alumno";
            }
        } else {
            // Si hay un error al insertar en la tabla 'usuario', mostrar mensaje
            echo "Error al insertar usuario: ";
        }
    } catch (Exception $e) {
        // Capturar cualquier excepción y mostrar mensaje de error
        echo "Error: " . $e->getMessage();
    }
}



//Funcion para insertar empresas desde cliente
    function crearempresacliente($conexion){
        try {
            // Obtener la contraseña del formulario y aplicar hash
            $contra = $_POST['password'];
            $contra = password_hash($contra, PASSWORD_DEFAULT);
            $correo = $_POST['correo'];
            $usuario = $_POST['nombre_usuario'];

            // Obtener otros datos del formulario
            $cif = $_POST["CIF"];
            $nombre_empresa = $_POST["nombre_empresa"];
            $direccion = $_POST["direccion"];
            $descripcion = $_POST["descripcion"];
            $telefono = $_POST["telefono"];
            $poblacion = $_POST['poblacionSelect'];
            $id_sector = $_POST["sectorSelect"];

            // Consulta SQL para validar si el nombre de usuario ya existe
            $ValidarNomUsuario = "SELECT COUNT(*) FROM usuario WHERE nombre_usuario = ?";
            $consultaValidarNomUsuario = $conexion->prepare($ValidarNomUsuario);
            $consultaValidarNomUsuario->bindParam(1, $usuario);
            $consultaValidarNomUsuario->execute();

            // Obtén el resultado de la consulta
            $usuarioExistente = $consultaValidarNomUsuario->fetchColumn();

            if ($usuarioExistente > 0) {
                // El usuario ya existe, muestra un mensaje o realiza alguna acción
                echo "El nombre de usuario ya está en uso. Por favor, elige otro.";
                return;
            }


             // Consulta SQL para validar si el CIF ya existe
            $ValidarCIFexistente = "SELECT COUNT(*) FROM alumno WHERE cif = ?";
            $consultaValidarCIFexistente = $conexion->prepare($ValidarCIFexistente);
            $consultaValidarCIFexistente->bindParam(1, $cif);
            $consultaValidarCIFexistente->execute();

            
            $CIFExistente = $consultaValidarCIFexistente->fetchColumn();

            if ($CIFExistente > 0) {
                // El CIF existe, muestra un mensaje 
                echo "El CIF ya está en uso. Por favor, use otro.";
                return;
            }


            // Consulta SQL para insertar en la tabla 'usuario'
            $sqlUsuario = "INSERT INTO usuario(nombre_usuario, password, correo, validado, tipo) VALUES (?, ?, ?, 0, 'empresa')";

            // Preparar la declaración
            $consultaUsuario = $conexion->prepare($sqlUsuario);

            // Asociar los parámetros
            $consultaUsuario->bindparam(1, $usuario);
            $consultaUsuario->bindparam(2, $contra);
            $consultaUsuario->bindparam(3, $correo);

            // Ejecutar la consulta para insertar en la tabla 'usuario'
            if ($consultaUsuario->execute()) {
                // Obtener el ID del usuario recién insertado
                $idUsuario = $conexion->lastInsertId();

                // Consulta SQL para insertar en la tabla 'empresa'
                $sqlEmpresa = "INSERT INTO empresa (id_usuario, cif, nombre_empresa, direccion, descripcion, telefono, id_poblacion, id_sector) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Preparar la declaración
                $consultaEmpresa = $conexion->prepare($sqlEmpresa);

                // Asociar los parámetros
                $consultaEmpresa->bindparam(1, $idUsuario);
                $consultaEmpresa->bindparam(2, $cif);
                $consultaEmpresa->bindparam(3, $nombre_empresa);
                $consultaEmpresa->bindparam(4, $direccion);
                $consultaEmpresa->bindparam(5, $descripcion);
                $consultaEmpresa->bindparam(6, $telefono);
                $consultaEmpresa->bindparam(7, $poblacion);
                $consultaEmpresa->bindparam(8, $id_sector);

                // Ejecutar la consulta para insertar en la tabla 'empresa'
                if ($consultaEmpresa->execute()) {
                    // Si la inserción es exitosa, mostrar mensaje
                    echo "Usuario y empresa insertados correctamente";
                } else {
                    // Si hay un error al insertar en la tabla 'empresa', eliminar el usuario previamente insertado
                    $sqlEliminarUsuario = "DELETE FROM `usuario` WHERE `id_usuario` = $idUsuario";
                    $consultaEliminarUsuario = $conexion->prepare($sqlEliminarUsuario);
                    $consultaEliminarUsuario->execute();
                    echo "Error al insertar en la tabla 'empresa'";
                }
            } else {
                // Si hay un error al insertar en la tabla 'usuario', mostrar mensaje
                echo "Error al insertar usuario";
            }
        } catch (Exception $e) {
            // Capturar cualquier excepción y mostrar mensaje de error
            echo "Error: " . $e->getMessage();
        }
    }

?>