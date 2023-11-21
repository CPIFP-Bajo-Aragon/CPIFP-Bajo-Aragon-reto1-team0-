<?php
    if (isset($_POST['Guardar'])) {
        // Obtener el id de usuario de la sesión actual
        $id_usuario = $_SESSION['id_usuario'];

        // Recoger los datos del formulario
        $id_oficio = $_POST['id_oficio'];
        $nombre_empresa = $_POST['nombre_empresa'];
        $poblacion = $_POST['poblacion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        // Antes de la inserción, verificar duplicados
        $check_duplicate_sql = "SELECT COUNT(*) FROM poseer_experiencia WHERE id_usuario = ? AND id_oficio = ?";
        $check_stmt = $conexion->prepare($check_duplicate_sql);
        $check_stmt->execute([$id_usuario, $id_oficio]);
        $count = $check_stmt->fetchColumn();

        if ($count == 0) {
            // No hay duplicados, proceder con la inserción
            $insert_sql = "INSERT INTO poseer_experiencia (id_usuario, id_oficio, nombre_empresa, poblacion, fecha_inicio, fecha_fin)
                           VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conexion->prepare($insert_sql);
            $insert_stmt->execute([$id_usuario, $id_oficio, $nombre_empresa, $poblacion, $fecha_inicio, $fecha_fin]);

            // Manejar errores o mostrar un mensaje de éxito
            if ($insert_stmt->rowCount() > 0) {
                echo "Experiencia laboral guardada con éxito.";
                $resultados = obtenerExperienciaLaboral($conexion, $id_usuario); // Actualizar resultados
            } else {
                echo "Error al guardar la experiencia laboral.";
            }
        } else {
            echo "Ya existe una experiencia laboral con estos valores.";
        }
    }
?>