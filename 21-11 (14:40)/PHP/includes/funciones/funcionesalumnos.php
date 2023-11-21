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
    $sql = "SELECT ot.*, p.nombre as Nombre_Poblacion, e.nombre_empresa, s.nombre_sector
        FROM oferta_trabajo ot 
        LEFT JOIN empresa e ON ot.id_usuario = e.id_usuario
        LEFT JOIN sector s ON e.id_sector = s.id_sector
        LEFT JOIN poblacion p ON ot.id_poblacion = p.id_poblacion
        WHERE ot.activa = 1";

    $consulta = $conexion->prepare($sql);

    // Ejecuta la consulta
    if ($consulta->execute()) {

        
        // Itera a través de las ofertas de trabajo y muestra la información
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $id_oferta = $fila->id_oferta;
            $titulo = $fila->titulo;
            $descripcion = $fila->descripcion_oferta;
            $fecha_publicacion = $fila->fecha_publicacion;
            $duracion_contrato = $fila->duracion_contrato;
            $activa = $fila->activa;
            $id_poblacion = $fila->id_poblacion;
            $id_usuario = $fila->id_usuario;

            // Obtiene el nombre de la población asociada a la oferta
            $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);

            // Obtiene el nombre de la empresa asociada a la oferta
            $nombre_empresa = mostrarempresas($conexion, $id_usuario);

            // Verificar si el alumno ya está inscrito en la oferta
            $esta_inscrito = estaInscrito($conexion, $id_oferta, $_SESSION['id_usuario']);

            // Imprimir la información de la oferta
            echo '<div class="oferta">';
            echo "<h2>$titulo</h2>";
            echo "<p>$descripcion</p>";
            echo "<p class='fecha-publicacion'><strong>Fecha de publicación:</strong> " . date('d/m/Y', strtotime($fecha_publicacion)) . "</p>";
            echo "<p class='duracion-contrato'><strong>Duración del contrato:</strong> $duracion_contrato meses</p>";
            echo "<p class='poblacion' id='" . $fila->id_poblacion . "'><strong>Población:</strong> " . $fila->Nombre_Poblacion . "</p>";
            echo "<p><strong>Empresa:</strong>" . $fila->nombre_empresa . "</p>";
            echo "<p class='sector'><strong>Sector:</strong> " . $fila->nombre_sector . "</p>";
            // echo "<p><strong>Activa:</strong>" . ($activa == 1 ? 'Sí' : 'No') . "</p>";

            // Imprimir el botón de inscripción solo si el alumno no está inscrito
            if (!$esta_inscrito) {
                echo '<form action="ofertas-alumno" method="POST" class="inscripcion" id="formInscribir">';
                echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
                echo '<input type="hidden" name="inscribirme" value="1">'; 
                echo '<input type="submit" value="Inscribirme">';
                echo '</form>';

            } else {
                echo '<p class="ya-inscrito"><strong>Te has inscrito en esta oferta</strong></p>';
            }

            echo '</div>';
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
        // $fecha_nacim = $_POST['fecha_nacim'];
        $carnet_conducir = $_POST['carnet'];
        $actitudes = $_POST['actitud'];
        $aptitudes = $_POST['aptitud'];
        $id_poblacion = $_POST['poblacionSelect'];
        

        if ($carnet_conducir == 1) {
            $carnet_conducir_texto = "Si";
        } else {
            $carnet_conducir_texto = "No";
        }

        // Actualizar los datos en la base de datos
        $update_sql = "UPDATE usuario 
                       SET nombre_usuario = ?, correo = ?
                       WHERE id_usuario = ?";
        $update_stmt = $conexion->prepare($update_sql);
        $update_stmt->execute([$nombre_usuario, $correo, $id_usuario]);

        $update_alumno_sql = "UPDATE alumno 
                              SET apellidos = ?, dni = ?, nombre = ?, telefono = ?, carnet_conducir = ?, 
                                  actitudes = ?, aptitudes = ?,  id_poblacion = ? 
                              WHERE id_usuario = ?";
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt->execute([$apellidos, $dni, $nombre, $telefono, $carnet_conducir, $actitudes, $aptitudes, $id_poblacion, $id_usuario]);

        // Manejar errores o mostrar un mensaje de éxito
        if ($update_stmt->rowCount() > 0 || $update_alumno_stmt->rowCount() > 0) {
            header("location: datos-personales-alumno");
        } else {
            echo "No se ha hecho ninguna modificación.";
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
        $actitudes = $_POST['actitud'];
        $aptitudes = $_POST['aptitud'];
        

        if ($carnet_conducir == 1) {
            $carnet_conducir_texto = "Si";
        } else {
            $carnet_conducir_texto = "No";
        }
        
        // Actualizar los datos en la base de datos
        $update_alumno_sql = "UPDATE alumno 
                              SET carnet_conducir = ?, actitudes = ?, aptitudes = ? 
                              WHERE id_usuario = ?";
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt->execute([$carnet_conducir, $actitudes, $aptitudes, $_SESSION['id_usuario']]); // Cambiado a $_SESSION['id_usuario']
        
        // Manejar errores o mostrar un mensaje de éxito
        if ($update_alumno_stmt->rowCount() > 0) {
            header("location: habilidades-alumno");
        } else {
            echo "No se ha hecho ninguna modificación.";
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
        // ... Código anterior ...

        // Itera a través de las ofertas de trabajo y muestra la información
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $id_oferta = $fila->id_oferta;
            $titulo = $fila->titulo;
            $descripcion = $fila->descripcion_oferta;
            $fecha_publicacion = $fila->fecha_publicacion;
            $duracion_contrato = $fila->duracion_contrato;
            $id_poblacion = $fila->id_poblacion;
            $id_usuario = $fila->id_usuario;
        
            // Obtiene el nombre de la población asociada a la oferta
            $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);
        
            // Obtiene el nombre de la empresa asociada a la oferta
            $nombre_empresa = mostrarempresas($conexion, $id_usuario);
        
            // Muestra la información de la oferta
            echo '<div class="oferta">';
            echo "<h2>$titulo</h2>";
            echo "<p>$descripcion</p>";
            echo "<p>Fecha de publicación: $fecha_publicacion</p>";
            echo "<p>Duración del contrato: $duracion_contrato meses</p>";
            echo "<p>Población: $nom_poblacion</p>";
            echo "<p>Empresa: $nombre_empresa</p>";
        
            // Imprime el botón de inscripción con el ID de la oferta
            echo '<form action="resumen-alumno" method="POST" name="formInscribir" id="formInscribir">';
            echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
                echo '<input type="hidden" name="anular" value="1">'; 
                echo '<input type="submit" value="anular" id="anular">';
            echo '</form>';
            echo '</div>';

        }

        // Procesa la inscripción fuera del bucle
if (isset($_POST['anular'])) {
    // Obtén el id de la oferta seleccionada
    $id_oferta = $_POST['id_oferta'];

    // Obtén el id del usuario actual (alumno)
    $id_usuario_alumno = $_SESSION['id_usuario'];

    // Prepara la consulta para insertar la inscripción
    $sql = "DELETE FROM inscribir WHERE id_oferta = :id_oferta AND id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario_alumno, PDO::PARAM_INT);

    // Ejecuta la consulta de inserción
    if ($stmt->execute()) {
        // Redirige a la misma página después de enviar el formulario
        echo " anulacion";
      
        
    } else {
        echo "Error en la anulacion";
    }
}

        } else {
            // Muestra un mensaje si la consulta no se pudo realizar
            echo "No se ha podido realizar la consulta";
        }
    }
    
