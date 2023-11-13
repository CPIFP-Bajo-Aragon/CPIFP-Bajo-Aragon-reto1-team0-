<?php


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
                $nombre_usuario = mostrarempresas($conexion, $id_usuario);

                // Muestra la información de la oferta
                echo '<div class="oferta">';
                echo "<h2>$titulo</h2>";
                echo "<p>$descripcion</p>";
                echo "<p>Fecha de publicación: $fecha_publicacion</p>";
                echo "<p>Duración del contrato: $duracion_contrato meses</p>";
                echo "<p>Población: $nom_poblacion</p>";
                echo "<p>Empresa: $nombre_usuario</p>";
                echo '</div>';
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
                $nombre_usuario = mostrarempresas($conexion, $id_usuario);

                // Muestra la información de la oferta
                echo '<div class="oferta">';
                echo "<h2>$titulo</h2>";
                echo "<p>$descripcion</p>";
                echo "<p>Fecha de publicación: $fecha_publicacion</p>";
                echo "<p>Duración del contrato: $duracion_contrato meses</p>";
                echo "<p>Población: $nom_poblacion</p>";
                echo "<p>Empresa: $nombre_usuario</p>";
                echo '</div>';
            }
        }
     }
?>

<?php 
    include("../includes/conexion.php");
    include("../login/verificarLogin.php");

    // Obtener el id de usuario de la sesión actual
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
        echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
    }

    
?>