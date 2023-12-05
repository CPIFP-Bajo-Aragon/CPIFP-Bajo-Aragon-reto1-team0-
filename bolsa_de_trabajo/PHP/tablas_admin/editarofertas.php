<?php
include("../includes/conexion.php");

    if(isset($_GET['id_oferta'])){
        $resultado = array(); // Array para almacenar los valores
    
        $id=$_GET['id_oferta'];
        // Consulta los datos de la oferta a editar
        $sql = "SELECT * FROM oferta_trabajo WHERE id_oferta = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    
        // Ejecuta la consulta y almacena los valores en el array
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $resultado['titulo'] = $fila->titulo;
                $resultado['descripcion_oferta'] = $fila->descripcion_oferta;
                $resultado['duracion_contrato'] = $fila->duracion_contrato;
                $resultado['carnet_conducir'] = $fila->carnet_conducir;
            }            
            // Convierte el array a formato JSON y lo muestra
            echo json_encode($resultado);
        }else {
            // Muestra un mensaje de error si no se pudieron obtener los datos
            echo json_encode(array('error' => 'No se pudieron obtener los datos.'));
        }
}
?>