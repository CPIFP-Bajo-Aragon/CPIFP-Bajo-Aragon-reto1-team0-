<?php
 // Manejo de formularios POST para borrar y editar registros de ofertas de trabajo
if (isset($_POST["activar"])) {
    $id = $_POST["id_oferta"];
    // Prepara la conofertas-adminsulta SQL para actualizar el campo 'validado' a 1
    $sql = "UPDATE oferta_trabajo SET activa = 1 WHERE id_oferta = :id_oferta";


    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);


    // Asocia el valor de :id_usuario con el parámetro proporcionado
    $consulta->bindParam(':id_oferta', $id);


    // Ejecuta la consulta para actualizar el estado de validación
    $consulta->execute();
}
if (isset($_POST["desactivar"])) {
    $id = $_POST["id_oferta"];
    // Prepara la consulta SQL para actualizar el campo 'validado' a 1
    $sql = "UPDATE oferta_trabajo SET activa = 0 WHERE id_oferta = :id_oferta";


    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);


    // Asocia el valor de :id_usuario con el parámetro proporcionado
    $consulta->bindParam(':id_oferta', $id);


    // Ejecuta la consulta para actualizar el estado de validación
    $consulta->execute();
}


if (isset($_POST["validar"])) {
    $id = $_POST["id_oferta"];
    // Prepara la consulta SQL para actualizar el campo 'validado' a 1
    $sql = "UPDATE oferta_trabajo SET validada = 1 WHERE id_oferta = :id_oferta";


    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);


    // Asocia el valor de :id_usuario con el parámetro proporcionado
    $consulta->bindParam(':id_oferta', $id);


    // Ejecuta la consulta para actualizar el estado de validación
    $consulta->execute();
}



$datosOferta = array(); // Definir datosOferta con un valor predeterminado vacío

if (isset($_POST["editar"])) {
    $id = $_POST["id_oferta"];
    $datosOferta = editarregistrooferta($conexion, $id);
    echo "<script> var datosOferta = " . json_encode($datosOferta) . ";</script>";
}




// Verificar si el formulario se ha enviado
if (isset($_POST['Guardar'])) {
        // Recoger los datos del formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion_contrato = $_POST['duracion_contrato'];
        $carnet = $_POST['carnet'];
        $poblacion = $_POST['poblacion'];
        $aptitud = $_POST['aptitud'];
        $id_oferta = $_POST['id_oferta'];

        // Guarda el id de la población 
        $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
        $consultaPoblacion = $conexion->prepare($sqlPoblacion);
        $consultaPoblacion->execute();
        $poblacionId = $consultaPoblacion->fetchColumn();

        // Actualizar los datos en la base de datos
        $update_empresa_sql = "UPDATE oferta_trabajo 
                                   SET titulo = ?, descripcion_oferta = ?,  duracion_contrato = ? ,carnet_conducir = ?, id_poblacion = ?, aptitud = ?
                                   WHERE id_oferta = ?";
        $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
        $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
        $update_empresa_stmt->bindValue(1, $titulo);
        $update_empresa_stmt->bindValue(2, $descripcion);
        $update_empresa_stmt->bindValue(3, $duracion_contrato);
        $update_empresa_stmt->bindValue(4, $carnet);
        $update_empresa_stmt->bindValue(5, $poblacionId);
        $update_empresa_stmt->bindValue(6, $aptitud);
        $update_empresa_stmt->bindValue(7, $id_oferta);

        $update_empresa_stmt->execute();
}  
?>