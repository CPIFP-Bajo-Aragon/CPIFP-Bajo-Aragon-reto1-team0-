<?php
        // Verificar si el formulario se ha enviado
        if (isset($_POST['Guardar'])) {
            // Recoger los datos del formulario
            $nombre_empresa = $_POST['nombre_empresa'];
            $cif = $_POST['cif'];
            $direccion = $_POST['direccion'];
            $descripcion = $_POST['descripcion'];
            $telefono = $_POST['telefono'];
            $poblacion = $_POST['poblacion'];
            $sector = $_POST['sector'];
    
            // Guarda el id de la población 
            $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
            $consultaPoblacion = $conexion->prepare($sqlPoblacion);
            $consultaPoblacion->execute();
            $poblacion = $consultaPoblacion->fetchColumn();
    
            // Guarda el id del sector 
            $sqlSector="SELECT s.id_sector FROM sector as s JOIN empresa as e WHERE s.nombre_sector='$sector'";
            $consultaSector = $conexion->prepare($sqlSector);
            $consultaSector->execute();
            $sector = $consultaSector->fetchColumn();
    
    
    
            // Actualizar los datos en la base de datos
    
            $update_empresa_sql = "UPDATE empresa 
                                  SET cif = ?, nombre_empresa = ?,  direccion = ? ,descripcion = ?, telefono = ?, id_poblacion = ?, id_sector = ?
                                  WHERE id_usuario = ?";
            $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
            $update_empresa_stmt->execute([$cif, $nombre_empresa, $direccion, $descripcion, $telefono, $poblacion, $sector, $id_usuario]);
    
            // Manejar errores o mostrar un mensaje de éxito
            if ($update_empresa_stmt->rowCount() > 0) {
                echo "Actualización exitosa";
            } else {
                echo "Error en la actualización";
            }
        }

?>