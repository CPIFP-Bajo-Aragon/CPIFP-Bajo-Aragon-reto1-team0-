<?php
function insertaralumnocliente($conexion){
    
    try{
        $contra=$_POST['password'];
        $contra = password_hash($contra, PASSWORD_DEFAULT);

        $correo=$_POST['correo'];
        $usuario=$_POST['nombre_usuario'];
        
        $dni=$_POST['dni'];
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $Fecha_nacimiento=$_POST['Fecha_nacimiento'];
        $conducir=isset($_POST['carnet_conducir']) ? 1 : 0;
        $actitudes=$_POST['actitudes'];
        $aptitudes=$_POST['aptitudes'];
        $poblacion=$_POST['poblacionalumno'];
        $telefono=$_POST['TELEFONO'];
    
    
        $sql = "INSERT INTO usuario(nombre_usuario, password, correo, validado, tipo) 
        VALUES (?, ?, ?, 0, 'alumno')";
    
        // Preparar la declaración
        $consultaUsuario = $conexion->prepare($sql);
    
        $consultaUsuario->bindparam(1, $usuario);
        $consultaUsuario->bindparam(2, $contra);
        $consultaUsuario->bindparam(3, $correo);
    
        if ($consultaUsuario->execute()) {
            $idUsuario = $conexion->lastInsertId();
    
            // Crear la consulta SQL para insertar en la tabla 'empresa'
            $sqlAlumno = "INSERT INTO alumno (id_usuario, dni, nombre, apellidos, fecha_nacim, telefono, carnet_conducir, actitudes, aptitudes, id_poblacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $consultaAlumno = $conexion->prepare($sqlAlumno);
    
                $consultaAlumno->bindparam(1, $idUsuario);
                $consultaAlumno->bindparam(2, $dni);
                $consultaAlumno->bindparam(3, $nombre);
                $consultaAlumno->bindparam(4, $apellido);
                $consultaAlumno->bindparam(5, $Fecha_nacimiento);
                $consultaAlumno->bindparam(6, $telefono);
                $consultaAlumno->bindparam(7, $conducir);
                $consultaAlumno->bindparam(8, $actitudes);
                $consultaAlumno->bindparam(9, $aptitudes);
                $consultaAlumno->bindparam(10, $poblacion);
      
            // Ejecutar la consulta para insertar en la tabla 'empresa'
            if ($consultaAlumno->execute()) {
                echo "Usuario y alumno insertados correctamente";
            } else {
                $sqlAlumno ="DELETE FROM usuario WHERE id_usuario= $idUsuario";
                $consultaAlumno2 = $conexion->prepare($sqlAlumno);
                $consultaAlumno2->execute();
                $errorInfo = $consultaAlumno->errorInfo();

            // Mostrar los detalles del error
            echo "Error al insertar en la tabla 'alumno': " . $errorInfo[2]. "a";
            }
        } else {
            
            echo "Error al insertar usuario: " ;
        }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }



function crearempresacliente($conexion)
    {
        try {
            $contra = $_POST['password'];
            $contra = password_hash($contra, PASSWORD_DEFAULT);
            $correo = $_POST['correo'];
            $usuario = $_POST['nombre_usuario'];
    
            $cif = $_POST["CIF"];
            $nombre_empresa = $_POST["nombre_empresa"];
            $direccion = $_POST["direccion"];
            $descripcion = $_POST["descripcion"];
            $telefono = $_POST["telefono"];
            $poblacion = $_POST["poblacionempresa"];
            $sector = $_POST["sector"];
    
            // Insertar en la tabla 'usuario'
            $sqlUsuario = "INSERT INTO usuario(nombre_usuario, password, correo, validado, tipo) VALUES (?, ?, ?, 0, 'empresa')";
    
            $consultaUsuario = $conexion->prepare($sqlUsuario);
    
            $consultaUsuario->bindparam(1, $usuario);
            $consultaUsuario->bindparam(2, $contra);
            $consultaUsuario->bindparam(3, $correo);
    
            if ($consultaUsuario->execute()) {
                $idUsuario = $conexion->lastInsertId();
    
                // Insertar en la tabla 'empresa'
                $sqlEmpresa = "INSERT INTO empresa (id_usuario, cif, nombre_empresa, direccion, descripcion, telefono, id_poblacion, id_sector) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
                $consultaEmpresa = $conexion->prepare($sqlEmpresa);
    
                $consultaEmpresa->bindparam(1, $idUsuario);
                $consultaEmpresa->bindparam(2, $cif);
                $consultaEmpresa->bindparam(3, $nombre_empresa);
                $consultaEmpresa->bindparam(4, $direccion);
                $consultaEmpresa->bindparam(5, $descripcion);
                $consultaEmpresa->bindparam(6, $telefono);
                $consultaEmpresa->bindparam(7, $poblacion);
                $consultaEmpresa->bindparam(8, $sector);
    
                // Ejecutar la consulta para insertar en la tabla 'empresa'
                if ($consultaEmpresa->execute()) {
                    echo "Usuario y empresa insertados correctamente";
                } else {
                    // En caso de error, eliminar el usuario recién insertado
                    $sqlEliminarUsuario = "DELETE FROM `usuario` WHERE `id_usuario` = $idUsuario";
                    $consultaEliminarUsuario = $conexion->prepare($sqlEliminarUsuario);
                    $consultaEliminarUsuario->execute();
                    echo "Error al insertar en la tabla 'empresa'";
                }
            } else {
                echo "Error al insertar usuario";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
}
?>