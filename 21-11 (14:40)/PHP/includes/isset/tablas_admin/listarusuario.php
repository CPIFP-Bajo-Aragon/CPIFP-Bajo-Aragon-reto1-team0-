<?php
    if(isset($_POST['editar'])){

        $id = $_POST["id_usuario"];
        
        //MOSTRAR PERFIL
        $sqlOferta="SELECT * FROM alumno WHERE id_usuario='$id'";
        $stmt = $conexion->prepare($sqlOferta);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $dni = $fila->dni;
                $nombre = $fila->nombre;
                $apellidos = $fila->apellidos;
                // $fecha_nacim = $fila->fecha_nacim;
                $fecha_nacim = date('d/m/Y', strtotime($fila->fecha_nacim));
                $telefono= $fila->telefono;
                $carnet_conducir=$fila->carnet_conducir;
                $actitudes=$fila->actitudes;
                $aptitudes=$fila->aptitudes;
                $id_poblacion=$fila->id_poblacion;
                //$id=$fila->id_usuario;



                // Guarda el nombre de la población 
               $sqlPoblacion="SELECT p.nombre FROM poblacion as p JOIN alumno as a ON a.id_poblacion=p.id_poblacion WHERE a.id_usuario=$id";
               $consultaPoblacion = $conexion->prepare($sqlPoblacion);
               $consultaPoblacion->execute();
               $nombrePoblacion = $consultaPoblacion->fetchColumn();
        
               echo " <div id='modalEmpresa' class='modal' style='display: block;'>
                <div class='modal-content'>
                <span class='close' onclick=\"cerrarModal('modalEmpresa')\">&times;</span>  
                <h2>Editar alumno</h2>
                <form action='usuarios-admin' method='POST'>
                <label for='dni'>DNI</label>
                <input type='text' name='dni' value='$dni'>

                <label for='nombre'>Nombre</label>
                <input type='text' name='nombre' value='$nombre'>

                <label for='nombre'>Apellidos</label>
                <input type='text' name='apellidos' value='$apellidos'>

                <label for='fecha_nacim'>Fecha de nacimiento</label>
                <input type='date' name='fecha_nacim' value='$fecha_nacim'>

                <label for='telefono'>Teléfono</label>
                <input type='text' name='telefono' value='$telefono'>

                <label for='carnet'>Carnet de conducir</label>
                <input type='text' name='carnet' value='$carnet_conducir'>

                <label for='actitudes'>Actitudes</label>
                <input type='text' name='actitudes' value='$actitudes'>

                <label for='aptitudes'>Aptitudes</label>
                <input type='text' name='aptitudes' value='$aptitudes'>

                <label for='poblacion'>Población</label>
                <input type='text' name='poblacion' value='$nombrePoblacion'>

                <input type='submit' name='Guardar' value='Guardar'>
                </form>
                </div>
                </div>";
            }
        }
    }

 // Verificar si el formulario se ha enviado
    if (isset($_POST['Guardar'])) {
        // Recoger los datos del formulario
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $fecha_nacim = $_POST['fecha_nacim'];
        $telefono = $_POST['telefono'];
        $carnet = $_POST['carnet'];
        $actitudes = $_POST['actitudes'];
        $aptitudes = $_POST['aptitudes'];
        $poblacion = $_POST['poblacion'];


        // Guarda el id de la población 
        $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
        $consultaPoblacion = $conexion->prepare($sqlPoblacion);
        $consultaPoblacion->execute();
        $poblacionId = $consultaPoblacion->fetchColumn();

        // Actualizar los datos en la base de datos
        $update_alumno_sql = "UPDATE alumno 
                                SET dni = ?, nombre = ?,  apellidos = ? ,fecha_nacim = ?, telefono = ?, carnet_conducir = ?, actitudes = ?, aptitudes = ?, id_poblacion = ?
                                WHERE dni = ?";
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt->bindValue(1, $dni);
        $update_alumno_stmt->bindValue(2, $nombre);
        $update_alumno_stmt->bindValue(3, $apellidos);
        $update_alumno_stmt->bindValue(4, $fecha_nacim);
        $update_alumno_stmt->bindValue(5, $telefono);
        $update_alumno_stmt->bindValue(6, $carnet);
        $update_alumno_stmt->bindValue(7, $actitudes);
        $update_alumno_stmt->bindValue(8, $aptitudes);
        $update_alumno_stmt->bindValue(9, $poblacionId);
        $update_alumno_stmt->bindValue(10, $dni);

        $update_alumno_stmt->execute();
    }     

    if(isset($_POST['borrar'])){

        echo '<script>
        var confirmacion = confirm("¿Estás seguro de que quieres borrar este alumno?");
        console.log("Valor de confirmar_borrar:", document.getElementById("confirmar_borrar").value);
        if (confirmacion) {
            '.
            $sql = "DELETE FROM habla_idioma WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
       
        $sql = "DELETE FROM tener_estudio WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM inscribir WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM mensaje WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM poseer_experiencia WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();




        $id_usuario=$_POST['id_usuario'];
         // Intenta eliminar el registro de la tabla 'empresa' usando el ID de usuario
         $sql = "DELETE FROM alumno WHERE id_usuario = :id_usuario";
         $consulta = $conexion->prepare($sql);
         $consulta->bindParam(':id_usuario', $id_usuario);
         $consulta->execute();


         // Intenta eliminar el registro de la tabla 'usuario' usando el ID de usuario
         $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
         $consulta = $conexion->prepare($sql);
         $consulta->bindParam(':id_usuario', $id_usuario);
         $consulta->execute();
            '
        }        
        </script>';
       


    }

    if(isset($_POST['validar'])){
        $id = $_POST["id_usuario"];
        validarregistro($conexion, $id);
    }
?>