<?php

include("../../includes/conexion.php");


$resultado = array(); // Array para almacenar los valores
$caracteristicas=[];
$id=$_GET['id_usuario'];
// Consulta los datos de la oferta a editar
$sql = "SELECT * FROM alumno WHERE id_usuario = :id";
$consulta = $conexion->prepare($sql);
$consulta->bindParam(':id', $id, PDO::PARAM_INT);

// Ejecuta la consulta y almacena los valores en el array
if ($consulta->execute()) {
    while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
        $resultado['dni'] = $fila->dni;
        $resultado['nombre'] = $fila->nombre;
        $resultado['apellidos'] = $fila->apellidos;
        $resultado['fecha_nacim'] = $fila->fecha_nacim;
    }

    $sql="SELECT COUNT(*) AS numreg FROM poseer_experiencia JOIN oficio ON poseer_experiencia.id_oficio = oficio.id_oficio where `id_usuario`=:id;"; 
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $numreg=$fila->numreg;
        }
    }
    
    $sql = "SELECT * FROM poseer_experiencia JOIN oficio ON poseer_experiencia.id_oficio = oficio.id_oficio where poseer_experiencia.id_usuario = :id; ";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        if($numreg>0){
            $i=0;
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $caracteristicas['puesto_trabajo'][$i]=$fila->puesto_trabajo;
                $caracteristicas['fecha_inicio'][$i] = $fila->fecha_inicio;
                $caracteristicas['fecha_fin'][$i] = $fila->fecha_fin;
                $i=$i+1;
            }
        }
    }




    $sql="SELECT COUNT(*) AS numreg FROM tener_estudio JOIN estudio ON tener_estudio.id_estudio = estudio.id_estudio WHERE id_usuario = :id"; 
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $numreg=$fila->numreg;
        }
    }

    $sql = "SELECT * FROM tener_estudio JOIN estudio ON tener_estudio.id_estudio = estudio.id_estudio WHERE id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        if($numreg>0){
            $i=0;
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $caracteristicas['nombre_estudio'][$i] =$fila->nombre_estudio;
                $i=$i+1;
            }
        }
    }

    $sql = "SELECT count(*) as numreg FROM habla_idioma JOIN idioma ON habla_idioma.id_idioma = idioma.id_idioma JOIN nivel ON habla_idioma.id_nivel = nivel.id_nivel WHERE id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $numreg=$fila->numreg;
        }
    }

    $sql = "SELECT * FROM habla_idioma JOIN idioma ON habla_idioma.id_idioma = idioma.id_idioma JOIN nivel ON habla_idioma.id_nivel = nivel.id_nivel WHERE id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        $i=0;
        if($numreg>0){
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $caracteristicas['nombre_idioma'][$i] =$fila->nombre;

                $caracteristicas['nivel'][$i] =$fila->nivel;
                
                $i=$i+1;
            }
        }
    }
    
    // Convierte el array a formato JSON y lo muestra
    echo json_encode($caracteristicas);
}else {
    // Muestra un mensaje de error si no se pudieron obtener los datos
    echo json_encode(array('error' => 'No se pudieron obtener los datos.'));
}
?>