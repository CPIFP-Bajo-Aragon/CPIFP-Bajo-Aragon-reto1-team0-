<?php
 // Manejo de formularios POST para borrar y editar registros de ofertas de trabajo
if (isset($_POST["activar"])) {
    $id = $_POST["id_oferta"];
    // Prepara la conofertas-adminsulta SQL para actualizar el campo 'validado' a 1
    $sql = "UPDATE usuario SET validado = 1 WHERE id_oferta = :id_oferta";


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
    $sql = "UPDATE usuario SET validado = 0 WHERE id_oferta = :id_oferta";


    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);


    // Asocia el valor de :id_usuario con el parámetro proporcionado
    $consulta->bindParam(':id_oferta', $id);


    // Ejecuta la consulta para actualizar el estado de validación
    $consulta->execute();
}
if (isset($_POST["editar"])) {
    $id = $_POST["id_oferta"];
    
    //MOSTRAR PERFIL
    $sqlOferta="SELECT * FROM oferta_trabajo WHERE id_oferta='$id'";
    $stmt = $conexion->prepare($sqlOferta);

    // Ejecuta la consulta
    if ($stmt->execute()) {

        // Itera a través de las empresas y genera opciones HTML
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $titulo = $fila->titulo;
            $descripcion = $fila->descripcion_oferta;
            $duracion_contrato = $fila->duracion_contrato;
            $carnet = $fila->carnet_conducir;
            $poblacion= $fila->id_poblacion;
            $aptitud=$fila->aptitud;

            // Guarda el nombre de la población 
           $sqlPoblacion="SELECT nombre FROM poblacion as p JOIN oferta_trabajo as o ON o.id_poblacion=p.id_poblacion WHERE o.id_oferta=$id";
           $consultaPoblacion = $conexion->prepare($sqlPoblacion);
           $consultaPoblacion->execute();
           $nombrePoblacion = $consultaPoblacion->fetchColumn();

            //FORMULARIO
            echo "<div id='modalEmpresa' class='modal' style='display: block;'>";
            echo "<div class='modal-content'>";
            echo "<span class='close' onclick=\"cerrarModal('modalEmpresa')\">&times;</span>";  
            echo "<h2>Editar oferta</h2>";
            echo "<form action='ofertas-admin' method='POST'>
                <label for='titulo'>Título</label>
                <input type='text' name='titulo' placeholder='Título' value='$titulo'>
    
                <label for='descripcion'>Descripción</label>
                <input type='text' name='descripcion' placeholder='Descripción' value='$descripcion'>
    
                <label for='duracion_contrato'>Duración contrato</label>
                <input type='text' name='duracion_contrato' placeholder='Duración del contrato' value='$duracion_contrato'>
    
                <label for='carnet'>Carnet</label>
                <input type='text' name='carnet' value='$carnet'>
    
                <label for='poblacion'>Población</label>
                <input type='text' name='poblacion' placeholder='Población' value='$nombrePoblacion'>
    
                <label for='aptitud'>Aptitudes necesarias</label>
                <input type='text' name='aptitud' placeholder='Aptitudes' value='$aptitud'>

                <input type='hidden' name='id_oferta' value='$id'>
    
                <input type='submit' name='Guardar' value='Guardar' id='Guardar'>
                  </form>";
            echo "</div>";
            echo "</div>";  
            
        }

        }           
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