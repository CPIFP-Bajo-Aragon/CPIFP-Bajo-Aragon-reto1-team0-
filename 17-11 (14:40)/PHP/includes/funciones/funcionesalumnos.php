<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");

// Obtener el id de usuario de la sesión actual
$id_usuario = $_SESSION['id_usuario'];
//COSAS DE LOS ALUMNOS
    // Función para listar ofertas de trabajo desde la perspectiva de un alumno
    function listarOfertasDesdeAlumno($conexion){
        // Consulta para obtener todas las ofertas de trabajo
        $sql = "SELECT * FROM oferta_trabajo";
        $consulta = $conexion->prepare($sql);

        // Ejecuta la consulta
        if($consulta->execute()){
          

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
    echo '<form action="ofertas-alumno" method="POST">';
    echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
    echo '<input type="submit" value="Inscribirme" name="inscribirme">';
    echo '</form>';
    echo '</div>';
}

// Procesa la inscripción fuera del bucle
if (isset($_POST['inscribirme'])) {
    // Obtén el id de la oferta seleccionada
    $id_oferta = $_POST['id_oferta'];

    // Obtén el id del usuario actual (alumno)
    $id_usuario_alumno = $_SESSION['id_usuario'];

    // Prepara la consulta para insertar la inscripción
    $sql = "INSERT INTO inscribir (id_oferta, id_usuario) VALUES (:id_oferta, :id_usuario)";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario_alumno, PDO::PARAM_INT);

    // Ejecuta la consulta de inserción
    if ($stmt->execute()) {
        echo "Inscripción exitosa";
    } else {
        echo "Error en la inscripción: " . $stmt->errorInfo()[2];
    }
}

        } else {
            // Muestra un mensaje si la consulta no se pudo realizar
            echo "No se ha podido realizar la consulta";
        }
    }

    
// Función para validar y mostrar resultados de búsqueda de ofertas de trabajo
    function validarbusquedaofertas($conexion){

        // Variable para indicar si se ha realizado una búsqueda
        $busquedaRealizada = false;
        
        // Se marca que se ha realizado una búsqueda (incluso antes de comprobar si existe POST)
        $busquedaRealizada = true;

        // Obtiene el término de búsqueda desde el formulario POST
        $Busqueda = $_POST['Busqueda'];

        // Prepara la consulta SQL con LIKE en id_oferta y título
        $sql = "SELECT * FROM oferta_trabajo WHERE id_oferta LIKE :Busqueda OR titulo LIKE :Busqueda";
        $consulta = $conexion->prepare($sql);

        // Vincula el parámetro de búsqueda y ejecuta la consulta
        $consulta->bindParam(':Busqueda', $Busqueda, PDO::PARAM_STR);
        $consulta->execute();

        // Obtiene todos los resultados como objetos
        $resultados = $consulta->fetchAll(PDO::FETCH_OBJ);

        // Comprueba si la consulta se ejecutó correctamente antes de iterar sobre los resultados
        if($consulta->execute()){
            
            // Itera sobre los resultados y muestra la información de cada oferta
            while($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id_oferta = $fila->id_oferta;
                $titulo = $fila->titulo;
                $descripcion = $fila->descripcion_oferta;
                $fecha_publicacion = $fila->fecha_publicacion;
                $duracion_contrato = $fila->duracion_contrato;
                $id_poblacion = $fila->id_poblacion;
                $id_usuario = $fila->id_usuario;

                // Obtiene el nombre de la población y de la empresa asociada
                $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);
                $nombre_empresa = mostrarempresas($conexion, $id_usuario);

                // Muestra la información de la oferta
                echo '<div class="oferta">';
                echo "<h2>$titulo</h2>";
                echo "<p>$descripcion</p>";
                echo "<p>Fecha de publicación: $fecha_publicacion</p>";
                echo "<p>Duración del contrato: $duracion_contrato meses</p>";
                echo "<p>Población: $nom_poblacion</p>";
                echo "<p>Empresa: $nombre_empresa</p>";
                echo '</div>';
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




//FUNCION EDITAR DATOS PERSONALES
function editarDatosPersonales($conexion) {
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
        $password = $_POST['password'];
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['DNI'];
        $telefono = $_POST['telefono'];
        $carnet_conducir = $_POST['carnet'];
        $actitudes = $_POST['actitud'];
        $aptitudes = $_POST['aptitud'];
        $id_poblacion = $_POST['poblacion'];
         
        if ($carnet_conducir == 1) {
            $carnet_conducir_texto = "Si";
        } else {
            $carnet_conducir_texto = "No";
        }
     

        // print_r($_POST);exit;
        // Actualizar los datos en la base de datos
        $update_sql = "UPDATE usuario 
                       SET nombre_usuario = ?, password = ?, correo = ?
                       WHERE id_usuario = ?";
        $update_stmt = $conexion->prepare($update_sql);
        $update_stmt->execute([$nombre_usuario, $password, $correo, $id_usuario]);

        $update_alumno_sql = "UPDATE alumno 
                              SET apellidos = ?, dni = ?,  nombre = ? ,telefono = ?, carnet_conducir = ?, 
                                  actitudes = ?, aptitudes = ?, id_poblacion = ? 
                              WHERE id_usuario = ?";
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt->execute([$apellidos, $dni, $nombre, $telefono,  $carnet_conducir_texto, $actitudes, $aptitudes, $id_poblacion, $id_usuario]);

        // Manejar errores o mostrar un mensaje de éxito
        if ($update_stmt->rowCount() > 0 || $update_alumno_stmt->rowCount() > 0) {
           
            header("location: datospersonales.php");
        } else {
            echo "Error en la actualización";
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
            po.nombre AS nombre_poblacion,
            u.nombre_usuario AS nombre_usuario,
            o.puesto_trabajo
        FROM poseer_experiencia pe
        JOIN alumno a ON pe.id_usuario = a.id_usuario
        JOIN usuario u ON a.id_usuario = u.id_usuario
        JOIN oficio o ON pe.id_oficio = o.id_oficio
        JOIN poblacion po ON a.id_poblacion = po.id_poblacion
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
            echo '<form action="resumen.php" method="POST">';
            echo '<input type="hidden" name="id_oferta" value="' . $id_oferta . '">';
            echo '<input type="submit" value="Anular" name="anular">';
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
        echo "Anulacion exitosa";
    } else {
        echo "Error en la anulacion inscripción: " . $stmt->errorInfo()[2];
    }
}

        } else {
            // Muestra un mensaje si la consulta no se pudo realizar
            echo "No se ha podido realizar la consulta";
        }
    }
    
