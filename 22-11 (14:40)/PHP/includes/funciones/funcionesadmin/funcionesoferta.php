<?php
    //Listar ofertas Admin
    function listarofertas($conexion, $max_filas_por_pagina){
        // Manejo de paginación y obtención de datos de ofertas de trabajo desde la base de datos
        $pagina = 1; // Página por defecto.
        if (isset($_POST['pagina'])) {
            $pagina = $_POST['pagina'];
        }
        
        $inicio = ($pagina - 1) * $max_filas_por_pagina;

        // Consulta para obtener el total de filas de ofertas de trabajo
        $sql = "SELECT COUNT(*) FROM oferta_trabajo" ;
        $totalConsulta = $conexion->prepare($sql);
        $totalConsulta->execute();
        $total_filas = $totalConsulta->fetchColumn();

        // Consulta para obtener las ofertas de trabajo paginadas
        $sql = "SELECT OT.id_oferta as id_oferta, OT.titulo AS Titulo, OT.descripcion_oferta AS Descripcion_Oferta, OT.fecha_publicacion AS Fecha_Publicacion, OT.duracion_contrato AS Duracion_Contrato, OT.carnet_conducir AS Carnet_Conducir, P.nombre AS Nombre_Poblacion, P.id_poblacion as id_poblacion ,E.nombre_empresa AS Nombre_Empresa, OT.validada as validada, OT.activa as activa FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario LIMIT $inicio, $max_filas_por_pagina ";
        
        $consulta = $conexion->prepare($sql);
        
        // Mostrar resultados en la tabla
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Imprimir cada fila de la tabla
                echo "<tr>";
                echo "<td>" . $fila->Titulo . "</td>";
                echo "<td>" . $fila->Descripcion_Oferta . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($fila->Fecha_Publicacion)) . "</td>"; // Formatea la fecha
                echo "<td>" . $fila->Duracion_Contrato . "</td>";
                echo "<td>" . ($fila->Carnet_Conducir ? "Sí" : "No") . "</td>";
                echo "<td id='".$fila->id_poblacion."'>" . $fila->Nombre_Poblacion . "</td>";
                echo "<td>" . $fila->Nombre_Empresa . "</td><td>";
                        
                        echo ("<form action='ofertas-admin' method='post'>");
                        echo "<input type='hidden' name='id_oferta' id='id_oferta' value='$fila->id_oferta'>";
                        
                        if($fila->validada==0){
                        echo ("<button type='submit' name='validar' id='editar'>validar</button>");
                            
                        }
                        if($fila->activa==1){
                            echo ("<button type='submit' name='desactivar' id='desactivar'>desactivar</button>");

                        }else{
                            echo ("<button type='submit' name='activar' id='activar'>activar</button>");

                        }
                        echo "<button type='submit' name='editar' id='editar_$fila->id_oferta'><i class='fas fa-pencil-alt'></i></button>";

                        echo ("</form>");
                        echo ("</td>");
                echo "</tr>";
            }
            
            // Formulario para la paginación
            echo ('<form action="ofertas-admin" method="post">');
            paginar($max_filas_por_pagina, $conexion, $total_filas);
            echo ('</form>');
        
        } else {
            // Mensaje si no se encuentran ofertas de trabajo
            echo "<tr><td colspan='8'>No se encontraron ofertas de trabajo.</td></tr>";
        }
    }

// Función para borrar una oferta de trabajo y sus registros asociados
    // function borrarregistroofertas($conexion, $id){
    //     // Elimina registros asociados a la oferta en otras tablas
    //     $sql = "DELETE FROM solicita_hablar_idioma WHERE id_oferta = :id_usuario";
    //     $consulta = $conexion->prepare($sql);
    //     $consulta->bindParam(':id_usuario', $id);
    //     $consulta->execute();

    //     $sql = "DELETE FROM pide_tener_estudio WHERE id_oferta = :id_usuario";
    //     $consulta = $conexion->prepare($sql);
    //     $consulta->bindParam(':id_usuario', $id);
    //     $consulta->execute();

    //     $sql = "DELETE FROM pedir_experiencia WHERE id_oferta = :id_usuario";
    //     $consulta = $conexion->prepare($sql);
    //     $consulta->bindParam(':id_usuario', $id);
    //     $consulta->execute();

    //     $sql = "DELETE FROM inscribir WHERE id_oferta = :id_usuario";
    //     $consulta = $conexion->prepare($sql);
    //     $consulta->bindParam(':id_usuario', $id);
    //     $consulta->execute();

    //     // Finalmente, elimina la oferta de trabajo
    //     $sql = "DELETE FROM oferta_trabajo WHERE id_oferta = :id_usuario";
    //     $consulta = $conexion->prepare($sql);
    //     $consulta->bindParam(':id_usuario', $id);
    //     $consulta->execute();
    //     // $fecha_publicacion = date('d/m/Y', strtotime($fila->fecha_publicacion)); // Formatea la fecha
    // }

    function borrarregistroofertas($conexion, $id){
        // Elimina registros asociados a la oferta en otras tablas
        $sql = "DELETE FROM solicita_hablar_idioma WHERE id_oferta = :id_oferta";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_oferta', $id);
        $consulta->execute();
    
        $sql = "DELETE FROM pide_tener_estudio WHERE id_oferta = :id_oferta";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_oferta', $id);
        $consulta->execute();
    
        $sql = "DELETE FROM pedir_experiencia WHERE id_oferta = :id_oferta";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_oferta', $id);
        $consulta->execute();
    
        $sql = "DELETE FROM inscribir WHERE id_oferta = :id_oferta";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_oferta', $id);
        $consulta->execute();
    
        // Finalmente, elimina la oferta de trabajo
        $sql = "DELETE FROM oferta_trabajo WHERE id_oferta = :id_oferta";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_oferta', $id);
        $consulta->execute();
        // $fecha_publicacion = date('d/m/Y', strtotime($fila->fecha_publicacion)); // Formatea la fecha
    }
    

//Funcion para insertar una oferta Admin
    function insertarofertasadmin($conexion, $estudios, $experiencia, $idiomas){
        if(isset($_POST['insertoferta'])){
            $titulo=$_POST['titulobtn'];
            $descripcion=$_POST['Descripcionbtn'];
            $fecha=$fecha_actual = date("Y-m-d");
            $duracion=$_POST['Duracionbtn'];
            $aptitud=$_POST['AptitudBtn'];
            $conducir = isset($_POST['carnetConducir']) ? $_POST['carnetConducir'] : 0; // Asumiendo 0 si no está marcada
            $id_poblacion=$_POST['PoblacionSelect'];
            $id_empresa=$_POST['EmpresaSelect'];
            
            
            if($conducir==="si"){
                $conducir=1;
            }else{
                $conducir=0;
            }

            // Insertar en la tabla oferta_trabajo
            $sql="INSERT INTO `oferta_trabajo`(`titulo`, `descripcion_oferta`, `fecha_publicacion`, `duracion_contrato`, `aptitud`, `carnet_conducir`, `id_poblacion`, `id_usuario`, activa, validada) VALUES ('$titulo','$descripcion','$fecha','$duracion','$aptitud','$conducir','$id_poblacion','$id_empresa', 1, 1)";
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
                    echo "hola";
                    $nombreexperiencia=$trabajo['nombre'];
                    $tiempoexperiencia=$trabajo['tiempo'];

                    
                    $sqlExperiencia = "INSERT INTO `pedir_experiencia`(`id_oficio`, `id_oferta`, `anos_experiencia`) VALUES (:id_oficio, :id_oferta, :meses_experiencia)";
                    $stmtExperiencia = $conexion->prepare($sqlExperiencia);
                    $stmtExperiencia->bindParam(':id_oficio', $nombreexperiencia);
                    $stmtExperiencia->bindParam(':id_oferta', $id_oferta);
                    $stmtExperiencia->bindParam(':meses_experiencia', $tiempoexperiencia); 
                    if ($stmtExperiencia->execute()) {
                        echo("Todo correcto experiencia");
                    } else {
                        echo("Ha habido un error experiencia");
                    }
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

    function editarregistrooferta($conexion, $id) {
        $resultado = array(); // Array para almacenar los valores
    
        // Consulta los datos de la oferta a editar
        $sql = "SELECT * FROM oferta_trabajo WHERE id_oferta = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    
        // Ejecuta la consulta y almacena los valores en el array
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $resultado['id_oferta'] = $id;
                $resultado['titulo'] = $fila->titulo;
                $resultado['descripcion'] = $fila->descripcion_oferta;
                $resultado['duracion_contrato'] = $fila->duracion_contrato;
                $resultado['carnet'] = $fila->carnet_conducir;
                $resultado['id_poblacion'] = $fila->id_poblacion;
                $resultado['aptitud'] = $fila->aptitud;
    
                // Guarda el nombre de la población
                $sqlPoblacion = "SELECT nombre FROM poblacion WHERE id_poblacion = :id_poblacion";
                $consultaPoblacion = $conexion->prepare($sqlPoblacion);
                $consultaPoblacion->bindParam(':id_poblacion', $fila->id_poblacion, PDO::PARAM_INT);
                $consultaPoblacion->execute();
                $resultado['nombrePoblacion'] = $consultaPoblacion->fetchColumn();
            }
            return $resultado;
        }
    
        echo "<script> var datosOferta = " . json_encode($resultado) . ";</script>";
    }
    
?>



