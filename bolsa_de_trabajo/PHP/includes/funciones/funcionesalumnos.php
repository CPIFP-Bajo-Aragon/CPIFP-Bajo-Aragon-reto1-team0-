<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");

// Obtener el id de usuario de la sesión actual
$id_usuario = $_SESSION['id_usuario'];
//COSAS DE LOS ALUMNOS


function estaInscrito($conexion, $id_oferta, $id_usuario_alumno) {
    $sql = "SELECT COUNT(*) FROM inscribir WHERE id_oferta = :id_oferta AND id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario_alumno, PDO::PARAM_INT);
    $stmt->execute();

    $cantidad_inscripciones = $stmt->fetchColumn();


    return $cantidad_inscripciones > 0;
}

function listarOfertasDesdeAlumno($conexion) {
    // Consulta para obtener todas las ofertas de trabajo


    $sql = "SELECT ot.*, MAX(p.nombre) as Nombre_Poblacion, e.nombre_empresa, e.id_sector as id_sector_empresa, o.id_sector as id_sector_oficio, s.nombre_sector as nombre_sector_empresa,  o.puesto_trabajo, pe.anos_experiencia, s_oficio.nombre_sector as nombre_sector_oficio,  
    GROUP_CONCAT(DISTINCT est.nombre_estudio) AS nombre_estudios,
    GROUP_CONCAT(DISTINCT CONCAT(i.nombre, ': ', n.nivel)) AS idiomas_requeridos
    FROM oferta_trabajo ot 
    LEFT JOIN pedir_experiencia pe ON ot.id_oferta = pe.id_oferta
    LEFT JOIN solicita_hablar_idioma shi ON ot.id_oferta = shi.id_oferta
    LEFT JOIN idioma i ON shi.id_idioma = i.id_idioma 
    LEFT JOIN nivel n ON shi.id_nivel = n.id_nivel 
    LEFT JOIN pide_tener_estudio pte ON ot.id_oferta = pte.id_oferta
    LEFT JOIN oficio o ON pe.id_oficio = o.id_oficio  
    LEFT JOIN estudio est ON pte.id_estudio = est.id_estudio  
    LEFT JOIN empresa e ON ot.id_usuario = e.id_usuario
    LEFT JOIN sector s ON e.id_sector = s.id_sector
    LEFT JOIN sector s_oficio ON o.id_sector = s_oficio.id_sector 
    LEFT JOIN poblacion p ON ot.id_poblacion = p.id_poblacion
    WHERE ot.activa = 1
    GROUP BY ot.id_oferta";
    
    
    $consulta = $conexion->prepare($sql);

    //control de cada empresa solicite varios requisitos


    // Ejecuta la consulta
    if ($consulta->execute()) {

        
        // Itera a través de las ofertas de trabajo y muestra la información
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $id_oferta = $fila->id_oferta;
            $titulo = $fila->titulo;
            $descripcion = $fila->descripcion_oferta;
            $fecha_publicacion = $fila->fecha_publicacion;
            $duracion_contrato = $fila->duracion_contrato;
            $aptitud = $fila->aptitud;

            $carnet_conducir = $fila->carnet_conducir;
            $vehiculo_propio = $fila->vehiculo_propio;
            $activa = $fila->activa;
            $id_poblacion = $fila->id_poblacion;
            $id_usuario = $fila->id_usuario;

            // Obtiene el nombre de la población asociada a la oferta
            $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);

           //nombre de estudios requeridos
            $nombre_estudios = $fila->nombre_estudios;

            //idiomas requeridos
            $idiomas_requeridos = $fila->idiomas_requeridos;


            //obtiene el sctor
            // Obtiene el nombre del sector de la empresa asociada a la oferta
            $id_sector_empresa = $fila->id_sector_empresa;
            $nom_sector = mostrarsector($conexion, $id_usuario);

            // Obtiene el nombre de la empresa asociada a la oferta
            $nombre_empresa = mostrarempresas($conexion, $id_usuario);

            // Verificar si el alumno ya está inscrito en la oferta
            $esta_inscrito = estaInscrito($conexion, $id_oferta, $_SESSION['id_usuario']);

            //Si solicita carnet de conducir
            if ($carnet_conducir == 1) {
                $carnet_conducir_texto = "Si";
            } else {
                $carnet_conducir_texto = "No";
            }
            //vehiculo propio
            if ($vehiculo_propio == 1) {
                $vehiculo_propio_texto = "Si";
            } else {
                $vehiculo_propio_texto = "No";
            }

           
            // Imprimir la información de la oferta
            echo '<section class="oferta" id="oferta">';
            echo '<div class="datos1">';

            echo "<h2 class='titulooferta'>$titulo"."   "." <i class='fas fa-caret-down'></i> </h2>";
            echo "<p class='nombre_empresa'>Empresa:" . $fila->nombre_empresa . "</p>";

            echo "<p class='fecha_publicacion'> " . date('d/m/Y', strtotime($fecha_publicacion)) . "</p>";

            echo '</div>';
            
            echo "<p class='poblacion' id='" . $fila->id_poblacion . "'><strong>Población:</strong> " . $fila->Nombre_Poblacion . "</p>";

            echo "<p class='sector' id='" . $fila-> id_sector_oficio . "'><strong>Categoria:</strong> " . $fila-> nombre_sector_oficio . "</p>";
            echo "<p class='descripcion'>$descripcion</p>";

            if (!$esta_inscrito) {
                echo '<form action="ofertas-alumno" method="POST" class="inscripcion" id="formInscribir">';
                echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
                echo '<input type="hidden" name="inscribirme" value="1" class="incribirme">'; 
                echo '<input type="submit" value="inscribirme" class="incribirme">';
                echo '</form>';

            } else {
                echo '<p class="ya-inscrito"><strong>Te has inscrito en esta oferta</strong></p>';
            }
           
            echo '<div class="detalles">';
            echo "<p class='titulo2'><strong>REQUISITOS</strong></p>";

            echo "<p class='enunciado'><strong>Estudios requeridos</strong> </p>";
            echo "<p class='estudios_requeridos'> " . $fila->nombre_estudios . "</p>";

            echo "<p class='enunciado'><strong>Idiomas requeridos </strong>   </p>";
            echo "<p class='idiomas_requeridos'> $idiomas_requeridos  </p>";

            echo "<p class='enunciado'><strong>Carnet Conducir</strong>  </p>";
            echo "<p class='carnet_conducir'> $carnet_conducir_texto </p>";

            echo "<p class='enunciado'><strong>Experiencia Requerida</strong></p>";
            echo "<p class='carnet_conducir'>" . $fila->puesto_trabajo . " </p>";

            echo "<p class='enunciado'><strong>Años Experiencia</strong> </p>";
            echo "<p class='anios_experiencia'>" . $fila->anos_experiencia . " </p>";

            echo "<p class='enunciado'><strong>Aptitudes Minimas</strong></p>";
            echo "<p class='aptitudes'>" . $fila->aptitud . " </p>";

            echo "<p class='titulo2'><strong>DETALLES</strong></p>";
            echo "<p class='enunciado' ><strong>Tipo de Contrato</strong> </p>";


            echo "<p class='enunciado' ><strong>Duracion del Contrato</strong> </p>";
            echo "<p class='duracion_contrato'>$duracion_contrato meses</p>";

            echo "<p class='enunciado' ><strong>Sector Empresa</strong> </p>";
            echo "<p class='sector' id='" . $fila-> id_sector_empresa . "'> " . $fila-> nombre_sector_empresa . "</p>";
            
            // echo "<button type='submit' name='editar' id='editar_$fila->id_oferta'>Ver Detalles</button>";



            // echo "<p><strong>Activa:</strong>" . ($activa == 1 ? 'Sí' : 'No') . "</p>";

            // Imprimir el botón de inscripción solo si el alumno no está inscrito
            

            echo '</div>';
            echo '</section>';
        }
    } else {
        // Muestra un mensaje si la consulta no se pudo realizar
        echo "No se ha podido realizar la consulta";
    }
}

// Procesa la inscripción fuera del bucle
if (isset($_POST['inscribirme'])) {
    // Obtén el id de la oferta seleccionada
    $id_oferta = $_POST['id_oferta'];

    // Obtén el id del usuario actual (alumno)
    $id_usuario_alumno = $_SESSION['id_usuario'];

    // Verificar si el alumno ya está inscrito en la oferta
    $esta_inscrito = estaInscrito($conexion, $id_oferta, $id_usuario_alumno);

    // Procesar la inscripción solo si no está inscrito
    if (!$esta_inscrito) {
        // Prepara la consulta para insertar la inscripción
        $sql = "INSERT INTO inscribir (id_oferta, id_usuario) VALUES (:id_oferta, :id_usuario)";

        try {
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario_alumno, PDO::PARAM_INT);

            // Ejecuta la consulta de inserción
            if ($stmt->execute()) {
                // Redirige a la misma página después de enviar el formulario
                header("Location: ofertas-alumno" );
                exit();
            } else {
                echo "Error en la inscripción";
            }
        } catch (PDOException $e) {
            // Maneja la excepción por clave duplicada
            if ($e->getCode() == 23000 && $e->errorInfo[1] == 1062) {
                echo "Ya estás inscrito en esta oferta.";
            } else {
                echo "Error en la inscripción: " . $e->getMessage();
            }
        }
    }
}





function obtenerdatosalumnos($conexion){
    // include("../includes/conexion.php");
    // include("../login/verificarLogin.php");

    // Obtener el id de usuario de la sesión actual
    // $id_usuario = $_SESSION['id_usuario'];
    $id_usuario = $_SESSION['id_usuario'];



    // Consultar la base de datos para obtener los datos del usuario y del alumno mediante un JOIN
    $sql = "SELECT usuario.*, alumno.*, poblacion.nombre as nombre_poblacion
            FROM usuario 
            LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
            LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion
            WHERE usuario.id_usuario = :id_usuario";



    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Manejar errores si la consulta no es exitosa
        // echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
    }
}


    // Consultar la base de datos para obtener los datos del usuario y del alumno mediante un JOIN
    $sql = "SELECT usuario.*, alumno.* 
            FROM usuario 
            LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
            WHERE usuario.id_usuario = :id_usuario";



    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Manejar errores si la consulta no es exitosa
        // echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
    }

    function listarPoblacion($conexion, $poblacionSeleccionada = '') {
        // ... (código existente)
    // Consulta para obtener todas las provincias
    $sql = "SELECT * FROM provincia";
    $consulta = $conexion->prepare($sql);

    // Ejecuta la consulta
    if($consulta->execute()){
        // Itera a través de las provincias
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            // Obtiene el nombre y el ID de la provincia
            $nombre_provincia = $fila->nombre;
            $id_provincia = $fila->id_provincia;

            // Consulta para obtener todas las poblaciones asociadas a la provincia actual
            $sql = "SELECT * FROM poblacion WHERE id_provincia = $id_provincia";
            $consulta2 = $conexion->prepare($sql);

            // Ejecuta la segunda consulta
            if($consulta2->execute()) {
                // Itera a través de las poblaciones asociadas a la provincia actual
                while ($fila2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
                    // Obtiene el nombre y el ID de la población
                    $nombre_poblacion = $fila2->nombre;
                    $id_poblacion = $fila2->id_poblacion;
                    ?>
                    <!-- Imprime una opción para el elemento de selección -->
                    <option value="<?php echo($id_poblacion) ?>"><?php echo ($nombre_provincia. "-" .$nombre_poblacion) ?></option>;
                    <?php
                }
            }
        }
    }
        // Itera a través de las provincias y poblaciones para imprimir las opciones
        foreach ($provincias as $id_provincia => $provincia) {
            echo '<optgroup label="' . $provincia['nombre_provincia'] . '">';
            
            foreach ($provincia['poblaciones'] as $poblacion) {
                $id_poblacion = $poblacion['id_poblacion'];
                $nombre_poblacion = $poblacion['nombre_poblacion'];
    
                echo '<option value="' . $id_poblacion . '"';
                
                // Verifica si esta población está seleccionada
                if ($id_poblacion == $poblacionSeleccionada) {
                    echo ' selected';
                }
    
                echo '>' . $nombre_poblacion . '</option>';
            }
    
            echo '</optgroup>';
        }
    }
    



    // FUNCION EDITAR DATOS PERSONALES
        function editarDatosPersonales($conexion)
        {
            // Obtener el id de usuario de la sesión actual
            // include("../login/verificarLogin.php");
            $id_usuario = $_SESSION['id_usuario'];

            // Consultar la base de datos para obtener los datos del usuario y del alumno mediante un JOIN
            $sql = "SELECT usuario.*, alumno.*
                    FROM usuario 
                    LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
                    WHERE usuario.id_usuario = :id_usuario";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Manejar errores si la consulta no es exitosa
                // echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
                return;
            }

            // Verificar si el formulario se ha enviado
            if (isset($_POST['Guardar'])) {
                // Recoger los datos del formulario
                $nombre_usuario = $_POST['nombre_usuario'];
                // $password = $_POST['password'];
                // $password = password_hash($password, PASSWORD_DEFAULT);
                $correo = $_POST['correo'];

                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $dni = $_POST['DNI'];
                $telefono = $_POST['telefono'];
                $fecha_nacim = $_POST['fecha_nacim'];
                $carnet_conducir = $_POST['carnet'];
                $vehiculo_propio = $_POST['vehiculo_propio'];
                $actitudes = $_POST['actitud'];
                $aptitudes = $_POST['aptitud'];
                $id_poblacion = $_POST['poblacionSelect'];
                

                if ($carnet_conducir == 1) {
                    $carnet_conducir_texto = "Si";
                } else {
                    $carnet_conducir_texto = "No";
                }

                if ($vehiculo_propio == 1) {
                    $carnet_conducir_texto = "Si";
                } else {
                    $carnet_conducir_texto = "No";
                }

                //Foto de perfil

                // $imagen_tmp = $_FILES['imagen']['tmp_name'];
                // $imagen_data = file_get_contents($imagen_tmp);
                // $imagen_base64 = base64_encode($imagen_data);

                // Actualizar los datos en la base de datos
                $update_sql = "UPDATE usuario 
                            SET nombre_usuario = ?, correo = ?
                            WHERE id_usuario = ?";
                $update_stmt = $conexion->prepare($update_sql);
                $update_stmt->execute([$nombre_usuario, $correo, $id_usuario]);

                $update_alumno_sql = "UPDATE alumno 
                                    SET  apellidos = ?, dni = ?, nombre = ?, telefono = ?, fecha_nacim = ?, carnet_conducir = ?, vehiculo_propio = ?,  
                                        actitudes = ?, aptitudes = ?,  id_poblacion = ? 
                                    WHERE id_usuario = ?";
                $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
                $update_alumno_stmt->execute([$apellidos, $dni, $nombre, $telefono, $fecha_nacim, $carnet_conducir, $vehiculo_propio,  $actitudes, $aptitudes, $id_poblacion, $id_usuario]);
                
                // Manejar errores o mostrar un mensaje de éxito
                if ($update_stmt->rowCount() > 0 || $update_alumno_stmt->rowCount() > 0) {
                    header("location: datos-personales-alumno");
                } else {
                   
                }
            }
        }

    //funcion editar habilidades
        function editarHabilidades($conexion)
        {
            // Obtener el id de usuario de la sesión actual
            // include("../login/verificarLogin.php");
            $id_usuario = $_SESSION['id_usuario'];

            // Consultar la base de datos para obtener los datos del usuario y del alumno mediante un JOIN
            $sql = "SELECT usuario.*, alumno.*
                    FROM usuario 
                    LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
                
                    WHERE usuario.id_usuario = :id_usuario";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Manejar errores si la consulta no es exitosa
                // echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
                return;
            }

            // Verificar si el formulario se ha enviado
            if (isset($_POST['Guardar'])) {
                // Recoger los datos del formulario
                $carnet_conducir = $_POST['carnet'];
                $vehiculo_propio = $_POST['vehiculo_propio'];
                
                $actitudes = $_POST['actitud'];
                $aptitudes = $_POST['aptitud'];
                

                if ($carnet_conducir == 1) {
                    $carnet_conducir_texto = "Si";
                } else {
                    $carnet_conducir_texto = "No";
                }
                
                // Actualizar los datos en la base de datos
                $update_alumno_sql = "UPDATE alumno 
                                    SET carnet_conducir = ?, vehiculo_propio = ?, actitudes = ?, aptitudes = ? 
                                    WHERE id_usuario = ?";
                $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
                $update_alumno_stmt->execute([$carnet_conducir, $vehiculo_propio, $actitudes, $aptitudes, $_SESSION['id_usuario']]); 
                
                // Manejar errores o mostrar un mensaje de éxito
                if ($update_alumno_stmt->rowCount() > 0) {
                    header("location: habilidades-alumno");
                } else {
                   
                }
            }
        }



//FUNCION MOSTRAR EXPERIENCA LABORAL
    function obtenerExperienciaLaboral($conexion, $id_usuario) {
        // $id_usuario = $_SESSION['id_usuario'];
    
        $sql = "SELECT 
                pe.id_oficio,
                pe.id_usuario,
                pe.fecha_inicio,
                pe.fecha_fin,
                pe.nombre_empresa,
                pe.poblacion,
                u.nombre_usuario AS nombre_usuario,
                o.puesto_trabajo
            FROM poseer_experiencia pe
            JOIN alumno a ON pe.id_usuario = a.id_usuario
            JOIN usuario u ON a.id_usuario = u.id_usuario
            JOIN oficio o ON pe.id_oficio = o.id_oficio
            WHERE pe.id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }




// $resultados = obtenerExperienciaLaboral($conexion, $id_usuario);




//FUNCION MOSTRAR ESTUDIOS
    function obtenerEstudios($conexion, $id_usuario) {
        // $id_usuario = $_SESSION['id_usuario'];

        $sql = "
            SELECT 
                te.*,
                a.nombre AS nombre_usuario,
                e.nombre_estudio,
                i.nombre_instituto
            FROM tener_estudio te
            JOIN alumno a ON te.id_usuario = a.id_usuario
            JOIN estudio e ON te.id_estudio = e.id_estudio
            JOIN instituto i ON te.id_instituto = i.id_instituto
            WHERE te.id_usuario = :id_usuario;
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


// $resultados = obtenerEstudios($conexion, $id_usuario);


//FUNCION MOSTRAR IDIOMAS
    function obtenerIdiomas($conexion, $id_usuario) {
        // $id_usuario = $_SESSION['id_usuario'];

        $sql = "
            SELECT 
                ha.*,
                a.nombre AS nombre_usuario,
                i.nombre,
                n.nivel
            FROM habla_idioma ha
            JOIN alumno a ON ha.id_usuario = a.id_usuario
            JOIN idioma i ON ha.id_idioma = i.id_idioma
            JOIN nivel n ON ha.id_nivel = n.id_nivel
            WHERE ha.id_usuario = :id_usuario;
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


// $resultados = obtenerIdiomas($conexion, $id_usuario);

//FUNCION MOSTRAR OFERTAS EN LAS QUE ESTA INSCRITO
// Función para verificar si el alumno está inscrito en una oferta
function noInscrito($conexion, $id_oferta, $id_usuario_alumno) {
    $sql = "SELECT COUNT(*) FROM inscribir WHERE id_oferta = :id_oferta AND id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario_alumno, PDO::PARAM_INT);
    $stmt->execute();

    $cantidad_inscripciones = $stmt->fetchColumn();

    // devuevle true si no está inscrito.
    return $cantidad_inscripciones == 0; // devuevle true si no está inscrito.
}

// Función para mostrar las ofertas en las que está inscrito el alumno
function mostrarOfertasInscritas($conexion, $id_usuario) {
    $sql = "SELECT oferta_trabajo.* FROM oferta_trabajo
            JOIN inscribir ON oferta_trabajo.id_oferta = inscribir.id_oferta
            
            WHERE inscribir.id_usuario = ?";

    $consulta = $conexion->prepare($sql);

    // Vincula el parámetro
    $consulta->bindParam(1, $id_usuario, PDO::PARAM_INT);

    // Ejecuta la consulta
    if ($consulta->execute()) {
        // Itera a través de las ofertas de trabajo y muestra la información
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $id_oferta = $fila->id_oferta;
            $titulo = $fila->titulo;
            $descripcion = $fila->descripcion_oferta;
            $fecha_publicacion = date('d/m/Y', strtotime($fila->fecha_publicacion));
            $duracion_contrato = $fila->duracion_contrato;
            $id_poblacion = $fila->id_poblacion;
            $id_usuario_oferta = $fila->id_usuario;

            // Obtiene el nombre de la población asociada a la oferta
            $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);

            // Obtiene el nombre de la empresa asociada a la oferta
            $nombre_empresa = mostrarempresas($conexion, $id_usuario_oferta);


          

            echo '<div class="oferta">';
            echo "<h2 class='titulooferta'>$titulo </h2>";
            echo "<p class='nombre_empresa'>Empresa: $nombre_empresa</p>";
            echo "<p class='fecha_publicacion'> $fecha_publicacion</p>";
            echo "<p class='poblacion' ><strong>Población:</strong>  $nom_poblacion </p>";
            echo "<p><strong>Duración del contrato:</strong> $duracion_contrato meses</p>";
            echo "<p class='descripcion'>$descripcion</p>";

        $no_inscrito = noInscrito($conexion, $id_oferta, $_SESSION['id_usuario']);

        if (!$no_inscrito) {
            echo '<form action="resumen-alumno" method="POST" class="inscripcion" id="formAnular">';
            echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
            echo '<input type="hidden" name="anular" value="1">'; 
            echo '<input type="submit" value="anular">';
            echo '</form>';
        } else {
            echo '<p class="ya-inscrito"><strong>Inscripción anulada</strong></p>';
        }

        echo '</div>';
                }
            } else {
                // Muestra un mensaje si la consulta no se pudo realizar
                echo "No se ha podido realizar la consulta";
            }
        }

        // Procesa la anulación de la inscripción fuera del bucle
        if (isset($_POST['anular'])) {
            // Obtén el id de la oferta seleccionada
            $id_oferta_anular = $_POST['id_oferta'];

            // Obtén el id del usuario actual (alumno)
            $id_usuario_alumno_anular = $_SESSION['id_usuario'];

            // Verificar si el alumno ya está inscrito en la oferta
            $no_inscrito_anular = noInscrito($conexion, $id_oferta_anular, $id_usuario_alumno_anular);

            // Procesar la anulación solo si está inscrito
            if (!$no_inscrito_anular) {
                // Prepara la consulta para eliminar la inscripción
                $sql_anular = "DELETE FROM inscribir WHERE id_oferta = :id_oferta AND id_usuario = :id_usuario";

                try {
                    $stmt_anular = $conexion->prepare($sql_anular);
                    $stmt_anular->bindParam(':id_oferta', $id_oferta_anular, PDO::PARAM_INT);
                    $stmt_anular->bindParam(':id_usuario', $id_usuario_alumno_anular, PDO::PARAM_INT);

                    // Ejecuta la consulta para anular la inscripción
                    if ($stmt_anular->execute()) {
                        // Redirige a la misma página después de enviar el formulario
                        header("Location: resumen-alumno");
                        exit();
                    } else {
                        echo "Error al anular la inscripción";
                    }
                } catch (PDOException $e) {
                    echo "Error en la anulación de la inscripción: " . $e->getMessage();
                }
            }
        }
