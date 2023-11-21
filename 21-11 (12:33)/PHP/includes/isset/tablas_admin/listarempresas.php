<?php
    // Manejo de formularios POST y llamadas a funciones PHP según acciones
    if (isset($_POST["validar"])) {
        $id = $_POST["id_usuario"];
        validarregistro($conexion, $id);
    }
    if (isset($_POST["borrar"])) {
        echo "entra";
        $id = $_POST["id_usuario"];
        borrarregistroempresa($conexion, $id);
    }
    if (isset($_POST["guardar"])) {
            
            $id = $_POST["id_usuario"];
            // Obtiene los datos del formulario
            $id_usuario = $_POST['id_usuario'];
            $nombre_usuario = $_POST['nombre_usuario'];
            $nombre_empresa = $_POST['nombre'];
            $cif = $_POST['cif'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $poblacion = $_POST['poblacionSelect'];
            $sector = $_POST['id_sector'];
            
            
            // Actualiza los datos en la base de datos
            $sql = "UPDATE empresa
                    SET 
                    nombre_empresa= :nombre_empresa,
                    cif=:cif,
                    id_poblacion=:id_poblacion,
                    direccion=:direccion,
                    telefono=:telefono,
                    id_sector=:sector
                    WHERE id_usuario = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':nombre_empresa', $nombre_empresa);
            $consulta->bindParam(':cif', $cif);
            $consulta->bindParam(':direccion', $direccion);
            $consulta->bindParam(':telefono', $telefono);
            $consulta->bindParam(':id_poblacion', $poblacion );
            $consulta->bindParam(':sector', $sector );
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();


            $sqlUsuario = "UPDATE usuario
                    SET 
                    nombre_usuario=:nombre_usuario,
                    correo=:correo
                    WHERE id_usuario = :id_usuario";
            $consulta = $conexion->prepare($sqlUsuario);
            $consulta->bindParam(':nombre_usuario', $nombre_usuario);
            $consulta->bindParam(':correo', $correo);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();

        
        
        
            
    }
    if (isset($_POST["editar"])) {
        $id = $_POST["id_usuario"];
        editarregistroempresa($conexion, $id);
    }
?>