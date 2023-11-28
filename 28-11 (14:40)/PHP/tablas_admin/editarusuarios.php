<?php
include("../includes/conexion.php");

// Verifica si se ha proporcionado el parámetro 'id_usuario' en la URL
if (isset($_GET['id_usuario'])) {
    $resultado = array(); // Array para almacenar los valores
    $id = $_GET['id_usuario'];

    // Consulta los datos del alumno a editar
    $sql = "SELECT * FROM alumno WHERE id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        // Recorre los resultados y almacena la información en el array
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $resultado['id_usuario'] = $id;
            $resultado['dni'] = $fila->dni;
            $resultado['nombre'] = $fila->nombre;
            $resultado['apellidos'] = $fila->apellidos;
            $resultado['fecha_nacim'] = date('d/m/Y', strtotime($fila->fecha_nacim));
            $resultado['telefono'] = $fila->telefono;
            $resultado['carnet_conducir'] = $fila->carnet_conducir;
            $resultado['actitudes'] = $fila->actitudes;
            $resultado['aptitudes'] = $fila->aptitudes;

            // Consulta el nombre de la población
            $sqlPoblacion = "SELECT p.nombre FROM poblacion as p JOIN alumno as a ON a.id_poblacion=p.id_poblacion WHERE a.id_usuario = :id";
            $consultaPoblacion = $conexion->prepare($sqlPoblacion);
            $consultaPoblacion->bindParam(':id', $id, PDO::PARAM_INT);
            $consultaPoblacion->execute();
            $resultado['nombrePoblacion'] = $consultaPoblacion->fetchColumn();
        }

        // Convierte el array a formato JSON y lo muestra
        echo json_encode($resultado);
    } else {
        // Muestra un mensaje de error si no se pudieron obtener los datos
        echo json_encode(array('error' => 'No se pudieron obtener los datos.'));
    }
}
?>
