<?php

    include("../includes/conexion.php");
    include("../includes/funciones.php");
    
    $sqlEmpresa="SELECT * FROM empresa";
    $stmt = $conexion->prepare($sqlEmpresa);
    
        // Ejecuta la consulta
    if ($stmt->execute()) {

        // Itera a través de las empresas y genera opciones HTML
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $nombre = $fila->nombre_empresa;
            $direccion = $fila->direccion;
            $descripcion = $fila->descripcion;
            $telefono= $fila->telefono;
            $id_poblacion=$fila->id_poblacion;
            $id_sector=$fila->id_sector;


        }

    }
?>