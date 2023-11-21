<?php
// obtener_datos_alumnos.php

if (isset($_GET['id_oferta'])) {
    $id_oferta = $_GET['id_oferta'];

    // Realiza la consulta para obtener los datos de los alumnos según $id_oferta
    $sql_alumnos = "SELECT * FROM alumnos WHERE id_oferta = :id_oferta";
    $stmt_alumnos = $conexion->prepare($sql_alumnos);
    $stmt_alumnos->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);

    // Ejecuta la consulta
    if ($stmt_alumnos->execute()) {
        $alumnos = [];
        while ($fila_alumno = $stmt_alumnos->fetch(PDO::FETCH_OBJ)) {
            // Almacena los datos en un array
            $alumnos[] = [
                'nombre' => $fila_alumno->nombre,
                // Agrega más campos según tus necesidades
            ];
        }

        // Retorna los datos en formato JSON
        echo json_encode($alumnos);
        
    } else {
        // Manejar error en la consulta si es necesario
        echo json_encode(['error' => 'Error al obtener datos de alumnos']);
    }
} else {
    // Manejar error si no se proporciona el ID de oferta
    echo json_encode(['error' => 'ID de oferta no proporcionado']);
}
?>
