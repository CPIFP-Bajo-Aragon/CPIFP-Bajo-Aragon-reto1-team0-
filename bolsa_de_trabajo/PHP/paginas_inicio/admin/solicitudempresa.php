<?php
    include("../../includes/conexion.php");


    $resultado = array(); // Array para almacenar los valores
    $caracteristicas=[];
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

        $sql="SELECT COUNT(*) AS numreg FROM pedir_experiencia JOIN oficio ON pedir_experiencia.id_oficio = oficio.id_oficio where `id_oferta`=:id;"; 
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $numreg=$fila->numreg;
            }
        }
        
        $sql = "SELECT * FROM pedir_experiencia JOIN oficio ON pedir_experiencia.id_oficio = oficio.id_oficio where pedir_experiencia.id_oferta = :id; ";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        // Ejecuta la consulta y almacena los valores en el array
        if ($consulta->execute()) {
            if($numreg>0){
                $i=0;
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $caracteristicas['puesto_trabajo'][$i]=$fila->puesto_trabajo;
                    $caracteristicas['meses_experiencia'][$i] = $fila->anos_experiencia;
                    $i=$i+1;
                }
            }
        }




        $sql="SELECT COUNT(*) AS numreg FROM pide_tener_estudio JOIN estudio ON pide_tener_estudio.id_estudio = estudio.id_estudio WHERE id_oferta = :id"; 
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $numreg=$fila->numreg;
            }
        }

        $sql = "SELECT * FROM pide_tener_estudio JOIN estudio ON pide_tener_estudio.id_estudio = estudio.id_estudio WHERE id_oferta = :id";
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

        $sql = "SELECT count(*) as numreg FROM solicita_hablar_idioma JOIN idioma ON solicita_hablar_idioma.id_idioma = idioma.id_idioma JOIN nivel ON solicita_hablar_idioma.id_nivel = nivel.id_nivel WHERE id_oferta = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $numreg=$fila->numreg;
            }
        }

        $sql = "SELECT * FROM solicita_hablar_idioma JOIN idioma ON solicita_hablar_idioma.id_idioma = idioma.id_idioma JOIN nivel ON solicita_hablar_idioma.id_nivel = nivel.id_nivel WHERE id_oferta = :id";
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