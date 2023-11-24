<?php
    session_start();
    
    if ($_SESSION['tipoUsuario']!="empresa") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }


    /*ISSET */
        if (isset($_POST['Enviar'])) {
        
            include("../includes/conexion.php");
            include("../includes/funciones.php");
        
            // Recoge los datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion_oferta'];
            $duracion_contrato = $_POST['duracion_contrato'];
            $aptitudes = $_POST['aptitud'];
            $carnet_conducir = $_POST['carnet_conducir'];
            $id_poblacion = $_POST['id_poblacion'];
            
        
            $id_puesto = $_POST['puesto'];
            $id_estudio = $_POST['estudios'];
            $id_experiencia = $_POST['experiencia'];
            $id_idioma = $_POST['idioma'];
            $id_nivel_idioma = $_POST['nivel_idioma'];
        
            try {
                // Inicia la transacción
            $conexion->beginTransaction();
        
            // Inserta la oferta en la tabla 'oferta_trabajo'
            $sqlOferta = "INSERT INTO oferta_trabajo (titulo, descripcion_oferta, fecha_publicacion, duracion_contrato, aptitud, carnet_conducir, id_poblacion, id_usuario)
                VALUES (:titulo, :descripcion_oferta, NOW(), :duracion_contrato, :aptitud, :carnet_conducir, :id_poblacion, :id_usuario)";
            
            $stmtOferta = $conexion->prepare($sqlOferta);
            $stmtOferta->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmtOferta->bindParam(':descripcion_oferta', $descripcion, PDO::PARAM_STR);
            $stmtOferta->bindParam(':duracion_contrato', $duracion_contrato, PDO::PARAM_INT);
            $stmtOferta->bindParam(':aptitud', $aptitudes, PDO::PARAM_STR);
            $stmtOferta->bindParam(':carnet_conducir', $carnet_conducir, PDO::PARAM_STR);
            $stmtOferta->bindParam(':id_poblacion', $id_poblacion, PDO::PARAM_INT);
            $stmtOferta->bindParam(':id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
        
            if ($stmtOferta->execute()) {
                echo("Inserción exitosa<br><br>");
        
                $id_oferta = $conexion->lastInsertId(); // Obtiene el ID de la oferta insertada
        
                // Inserta en la tabla 'pide_tener_estudio'
                $sqlEstudio = "INSERT INTO pide_tener_estudio (id_oferta, id_estudio) VALUES (:id_oferta, :id_estudio)";
                $stmtEstudio = $conexion->prepare($sqlEstudio);
                $stmtEstudio->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                $stmtEstudio->bindParam(':id_estudio', $id_estudio, PDO::PARAM_INT);
                $stmtEstudio->execute();
        
                echo("Inserción exitosa<br><br>");
        
        
                // Inserta en la tabla 'pedir_experiencia'
                $sqlExperiencia = "INSERT INTO pedir_experiencia (id_oficio, id_oferta, anos_experiencia) VALUES (:id_puesto, :id_oferta, :id_experiencia)";
                $stmtExperiencia = $conexion->prepare($sqlExperiencia);
                $stmtExperiencia->bindParam(':id_puesto', $id_puesto, PDO::PARAM_INT);
                $stmtExperiencia->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                $stmtExperiencia->bindParam(':id_experiencia', $id_experiencia, PDO::PARAM_INT);
                $stmtExperiencia->execute();
        
                echo("Inserción exitosa<br><br>");
        
        
                // Inserta en la tabla 'solicita_hablar_idioma'
                $sqlIdioma = "INSERT INTO solicita_hablar_idioma (id_oferta, id_idioma, id_nivel) VALUES (:id_oferta, :id_idioma, :id_nivel_idioma)";
                $stmtIdioma = $conexion->prepare($sqlIdioma);
                $stmtIdioma->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                $stmtIdioma->bindParam(':id_idioma', $id_idioma, PDO::PARAM_INT);
                $stmtIdioma->bindParam(':id_nivel_idioma', $id_nivel_idioma, PDO::PARAM_INT);
                $stmtIdioma->execute();
        
                echo("Inserción exitosa<br><br>");
        
                $conexion->commit();
        
                // Redirige al usuario a una página de éxito o donde desees
                echo("To correcto jefe");
            } else {
                // En caso de error en la inserción, muestra un mensaje de error
                echo "Error al crear la oferta: " . implode(" ", $stmtOferta->errorInfo());
            }
            }catch (Exception $e) {
                // En caso de excepción, revierte la transacción
            $conexion->rollBack();
                echo "Error: " . $e->getMessage();
            }
        
        
        } else {
            // Si no se ha enviado el formulario, redirige a una página de error o donde desees
            echo "Error al crear la oferta: No se ha enviado el formulario.";
        }


?>

<script src="../..//JS/tablasempresa/procesarFormularioOferta.js"></script>