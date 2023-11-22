<?php
    if (isset($_POST['Guardar'])) {
        // Obtener el id de usuario de la sesión actual
        $id_usuario = $_SESSION['id_usuario'];
    
        // Recoger los datos del formulario
        $id_idioma = $_POST['id_idioma'];
        $id_nivel = $_POST['id_nivel'];
    
        // Verificar si ya existe un registro con los mismos valores
        $check_duplicate_sql = "SELECT COUNT(*) FROM habla_idioma WHERE id_usuario = ? AND id_idioma = ? AND id_nivel = ?";
        $check_stmt = $conexion->prepare($check_duplicate_sql);
        $check_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
        $count = $check_stmt->fetchColumn();
    
        if ($count == 0) {
            // No hay duplicados, proceder con la inserción
            $insert_sql = "INSERT INTO habla_idioma (id_usuario, id_idioma, id_nivel)
            VALUES (?, ?, ?)";
            $insert_stmt = $conexion->prepare($insert_sql);
            $insert_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
    
            // Manejar errores o mostrar un mensaje de éxito
            if ($insert_stmt->rowCount() > 0) {
                echo "Idioma guardado con éxito.";
    
                // Obtener los idiomas actualizados después de la inserción
                $resultados = obtenerIdiomas($conexion, $id_usuario);
            } else {
                echo "Error al guardar el idioma.";
            }
        } else {
            echo "El idioma ya existe.";
        }
    }

    if (isset($_POST['eliminar'])) {
        // Obtener el id de usuario de la sesión actual
        $id_usuario = $_SESSION['id_usuario'];
        
    
        // Recoger los datos del formulario
        $id_idioma = $_POST['id_idioma'];
        $id_nivel = $_POST['id_nivel'];
    
        // Eliminar Estudio
        $delete_sql = "DELETE FROM habla_idioma WHERE id_usuario = ? AND id_idioma = ? AND id_nivel = ?";
        $delete_stmt = $conexion->prepare($delete_sql);
        $delete_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
    
        // Manejar errores o mostrar un mensaje de éxito
        if ($delete_stmt->rowCount() > 0) {
            echo "Idioma eliminado.";
            $resultados = obtenerIdiomas($conexion, $id_usuario);
        } else {
            echo "Error al eliminar Idioma.";
        }
    }
?>