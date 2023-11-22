<?php
// Función para mostrar el nombre de una población
function mostrarPoblacion($conexion, $id_poblacion){
    // Consulta SQL para obtener el nombre de la población con el ID proporcionado
    $sql = "SELECT nombre FROM poblacion where id_poblacion = :id_poblacion";

    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);

    // Asocia el valor de :id_poblacion con el parámetro proporcionado
    $consulta->bindParam(':id_poblacion', $id_poblacion, PDO::PARAM_INT);
   
    // Ejecuta la consulta
    if($consulta->execute()){
        
        // Itera a través de los resultados y obtiene el nombre de la población
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $nombre= $fila->nombre;
        }

        // Retorna el nombre de la población
        return $nombre;
    }
}

// Función para mostrar el nombre de un sector
function mostrarsector($conexion, $id_sector){
    // Consulta SQL para obtener el nombre del sector con el ID proporcionado
    $sql = "SELECT nombre_sector FROM sector where id_sector = :id_sector";

    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);

    // Asocia el valor de :id_sector con el parámetro proporcionado
    $consulta->bindParam(':id_sector', $id_sector, PDO::PARAM_INT);

    // Ejecuta la consulta
    if($consulta->execute()){
        // Itera a través de los resultados y obtiene el nombre del sector
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $nombre= $fila->nombre_sector;
        }

        // Retorna el nombre del sector
        return $nombre;
    }
}


// Función para mostrar el nombre de empresas asociadas a un usuario
function mostrarempresas($conexion, $id_usuario){
     // Inicializa la variable $nombre para evitar el error "Undefined variable"
     $nombre = "";
     
    // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
    $sql = "SELECT nombre_empresa FROM empresa where id_usuario = :id_usuario";

    // Prepara la consulta utilizando la conexión proporcionada
    $consulta = $conexion->prepare($sql);

    // Asocia el valor de :id_usuario con el parámetro proporcionado
    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    // Ejecuta la consulta
    if($consulta->execute()){
        // Itera a través de los resultados y obtiene el nombre de la empresa
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $nombre= $fila->nombre_empresa;
        }

        // Retorna el nombre de la empresa
        return $nombre;
    }
}
?>