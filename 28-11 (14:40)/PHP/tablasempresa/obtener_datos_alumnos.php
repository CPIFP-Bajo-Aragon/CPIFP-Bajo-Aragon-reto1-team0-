<?php
//    if ($_SESSION['tipoUsuario']!="empresa") {
//         // No ha iniciado sesión, redirige a la página de inicio de sesión
//         header("Location: inicio");
//         exit();
//     }

// obtener_datos_alumnos.php
include("../includes/conexion.php");
header('Content-Type: application/json');

if (isset($_GET['id_oferta'])) {
    $id_oferta = $_GET['id_oferta'];

    // Realiza la consulta para obtener los datos de los alumnos según $id_oferta
    $sql_alumnos = "SELECT a.* FROM alumno a INNER JOIN inscribir i ON a.id_usuario = i.id_usuario WHERE i.id_oferta = :id_oferta";
    $stmt_alumnos = $conexion->prepare($sql_alumnos);
    $stmt_alumnos->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);

    // Ejecuta la consulta
    if ($stmt_alumnos->execute()) {
        $alumnos = [];

        while ($fila_alumno = $stmt_alumnos->fetch(PDO::FETCH_OBJ)) {
            // Almacena los datos en un array
            $alumnos[]=[
                'id_usuario' => $fila_alumno->id_usuario,
                'nombre' => $fila_alumno->nombre
            
            ];
        }
        // Retorna los datos en formato JSON
        echo json_encode($alumnos);

        exit();
    } else {
        // Manejar error en la consulta si es necesario
        echo json_encode(['success' => false, 'error' => 'Error al obtener datos de alumnos']);
        exit();
    }
 } else {
     // Manejar error si no se proporciona el ID de oferta
     echo json_encode(['success' => false, 'error' => 'ID de oferta no proporcionado']);
     exit();
 }
?>