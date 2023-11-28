<?php

//Funcion para insertar una oferta desde el usuario empresa

function insertarofertempresa($conexion, $estudios, $experiencia, $idiomas){
    if(isset($_POST['insertoferta'])){
        $titulo=$_POST['titulobtn'];
        $descripcion=$_POST['Descripcionbtn'];
        $fecha=$fecha_actual = date("Y-m-d");
        $duracion=$_POST['Duracionbtn'];
        $aptitud=$_POST['AptitudBtn'];
        $conducir = isset($_POST['carnetConducir']) ? $_POST['carnetConducir'] : 0; // Asumiendo 0 si no está marcada
        $coche = isset($_POST['cochepropio']) ? $_POST['cochepropio'] : 0; // Asumiendo 0 si no está marcada
        $id_poblacion=$_POST['PoblacionSelect'];
        $id_empresa=$_SESSION['id_usuario'];

        if($conducir==="si"){
            $conducir=1;
        }else{
            $conducir=0;
        }
        if($coche==="si"){
            $coche=1;
        }else{
            $coche=0;
        }

        // Insertar en la tabla oferta_trabajo
        $sql="INSERT INTO `oferta_trabajo`(`titulo`, `descripcion_oferta`, `fecha_publicacion`, `duracion_contrato`, `aptitud`, `carnet_conducir`, `id_poblacion`, `id_usuario`, activa, validada, vehiculo_propio) VALUES ('$titulo','$descripcion','$fecha','$duracion','$aptitud','$conducir','$id_poblacion','$id_empresa', 0, 0, $coche)";
        $stmtoferta = $conexion->prepare($sql);
        $stmtoferta->execute();

        $id_oferta = $conexion->lastInsertId(); // Obtiene el ID de la oferta insertada
        
        // Inserta en la tabla 'pide_tener_estudio'
            if (!empty($_SESSION['estudios'])) {
                foreach ($_SESSION['estudios'] as $id_estudio) {
                    $sqlEstudio = "INSERT INTO pide_tener_estudio (id_oferta, id_estudio) VALUES (:id_oferta, :id_estudio)";
                    $stmtEstudio = $conexion->prepare($sqlEstudio);
                    $stmtEstudio->bindParam(':id_oferta', $id_oferta);
                    $stmtEstudio->bindParam(':id_estudio', $id_estudio);
                    $stmtEstudio->execute();
                }
            }

        // Inserta en la tabla 'pedir_experiencia'
            if (!empty( $_SESSION['experiencia'])) {
                foreach ( $_SESSION['experiencia'] as $trabajo) {
                    $nombreexperiencia=$trabajo['nombre'];
                    $tiempoexperiencia=$trabajo['tiempo'];

                    
                    $sqlExperiencia = "INSERT INTO `pedir_experiencia`(`id_oficio`, `id_oferta`, `anos_experiencia`) VALUES (:id_oficio, :id_oferta, :meses_experiencia)";
                    $stmtExperiencia = $conexion->prepare($sqlExperiencia);
                    $stmtExperiencia->bindParam(':id_oficio', $nombreexperiencia);
                    $stmtExperiencia->bindParam(':id_oferta', $id_oferta);
                    $stmtExperiencia->bindParam(':meses_experiencia', $tiempoexperiencia); 
                    $stmtExperiencia->execute();
                    
                }
            }

        // Inserta en la tabla 'solicita_hablar_idioma'
        if (!empty($_SESSION['idiomas'])) {
            foreach ($_SESSION['idiomas'] as $idioma) {
                $nombre_idioma = intval($idioma['nombre']);
                $nivel_idioma = intval($idioma['idioma']);
                //echo($nombre_idioma);
                //echo($nivel_idioma);
                $sqlIdioma = "INSERT INTO solicita_hablar_idioma (id_oferta, id_idioma, id_nivel) VALUES (:id_oferta, :id_idioma, :id_nivel_idioma)";
                $stmtIdioma = $conexion->prepare($sqlIdioma);
                $stmtIdioma->bindParam(':id_oferta', $id_oferta);
                $stmtIdioma->bindParam(':id_idioma', $nombre_idioma);
                $stmtIdioma->bindParam(':id_nivel_idioma', $nivel_idioma);
                $stmtIdioma->execute();
                
            }
        }
    
    }
}
