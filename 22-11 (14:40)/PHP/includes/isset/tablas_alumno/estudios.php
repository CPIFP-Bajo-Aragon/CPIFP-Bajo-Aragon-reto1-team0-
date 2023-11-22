<?php

// Verificar si se envió el formulario para agregar un nuevo estudio
if (isset($_POST['Guardar'])) {
    // Recoger los datos del formulario
    $id_estudio = $_POST['id_estudio'];
    $id_instituto = $_POST['id_instituto'];

    // Verificar si ya existe un registro con los mismos valores
    $check_duplicate_sql = "SELECT COUNT(*) FROM tener_estudio WHERE id_estudio = ? AND id_instituto = ? AND  id_usuario = ?";
    $check_stmt = $conexion->prepare($check_duplicate_sql);
    $check_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);
    $count = $check_stmt->fetchColumn();

    if ($count == 0) {
        // No hay duplicados, proceder con la inserción
        $insert_sql = "INSERT INTO tener_estudio (id_estudio, id_instituto, id_usuario)
                       VALUES (?, ?, ?)";
        $insert_stmt = $conexion->prepare($insert_sql);
        $insert_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);

        // Manejar errores o mostrar un mensaje de éxito
        if ($insert_stmt->rowCount() > 0) {
            echo "Estudio guardado con éxito.";

            // Obtener los estudios actualizados después de la inserción
            $resultados = obtenerEstudios($conexion, $id_usuario);
        } else {
            echo "Error al guardar el estudio.";
        }
    } else {
        echo "El estudio ya existe.";
    }
}


if (isset($_POST['eliminar'])) {
    // Obtener el id de usuario de la sesión actual
    $id_usuario = $_SESSION['id_usuario'];
    

    // Recoger los datos del formulario
    $id_estudio = $_POST['id_estudio'];
    $id_instituto = $_POST['id_instituto'];


    // Eliminar Estudio
    $delete_sql = "DELETE FROM tener_estudio WHERE id_estudio = ? AND id_instituto = ? AND id_usuario = ?";
    $delete_stmt = $conexion->prepare($delete_sql);
    $delete_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);

    // Manejar errores o mostrar un mensaje de éxito
    if ($delete_stmt->rowCount() > 0) {
        echo "Estudio eliminado.";
        $resultados = obtenerEstudios($conexion, $id_usuario);
    } else {
        echo "Error al eliminar estudio.";
    }
}
?>