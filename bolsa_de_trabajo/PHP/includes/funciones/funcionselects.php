<?php
//Listar nombres de empresas para meter en el select
    function listarempresaselect($conexion) {
        // Consulta para obtener todas las empresas
        $sql = "SELECT * FROM empresa";
        $stmt = $conexion->prepare($sql);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Inicializa una cadena para almacenar las opciones HTML
            $filtro = "";
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $id = $fila->id_usuario;
                $nombre = $fila->nombre_empresa;
    
                // Agrega una opción al filtro
                $filtro .= "<option value='$id' name='EmpresaSelect' >$nombre</option>";
            }
    
            // Imprime las opciones HTML generadas
            echo $filtro;
        }
    }

// Función para listar provincias y poblaciones en un elemento de selección HTML
    function listarProvinciaypoblacion($conexion) {
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
    }

// Función para listar sectores en un elemento de selección HTML
    function listarsectores($conexion){
            // Consulta para obtener todos los sectores
            $sql = "SELECT * FROM sector";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $filtro = "";

                // Itera a través de los sectores y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_sector;
                    $nombre = $fila->nombre_sector;

                    // Agrega una opción al filtro
                    // $filtro .= "<option value='$id' id='id_sector' name='id_sector'>$nombre</option>";
                    $filtro .= "<option value='$id'>$nombre</option>";  
                }

                // Imprime las opciones HTML generadas
                echo $filtro;
            }
    }

// Función para listar estudios en un elemento de selección HTML
    function listarestudios($conexion){
            // Consulta para obtener todos los estudios
            $sql = "SELECT * FROM estudio";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $option = "";

                // Itera a través de los estudios y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_estudio;
                    $nombre = $fila->nombre_estudio;

                    // Agrega una opción al filtro
                    $option .= "<option value='$id'>$nombre</option>";
                }

                // Imprime las opciones HTML generadas
                echo $option;
            }
    }

// Función para listar niveles en un elemento de selección HTML
    function listarnivel($conexion){
            // Consulta para obtener todos los niveles
            $sql = "SELECT * FROM nivel";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $option = "";

                // Itera a través de los niveles y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_nivel;
                    $nombre = $fila->nivel;

                    // Agrega una opción al filtro
                    $option .= "<option value='$id'>$nombre</option>";
                }

                // Imprime las opciones HTML generadas
                echo $option;
            }
    }

// Función para listar idiomas en un elemento de selección HTML
    function listaridioma($conexion){
            // Consulta para obtener todos los idiomas
            $sql = "SELECT * FROM idioma";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $option = "";

                // Itera a través de los idiomas y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_idioma;
                    $nombre = $fila->nombre;

                    // Agrega una opción al filtro
                    $option .= "<option value='$id' id='id_estudio' name='id_estudio'>$nombre</option>";
                }

                // Imprime las opciones HTML generadas
                echo $option;
            }
    }

// Función para listar oficios en un elemento de selección HTML
    function listaroficios($conexion){
            // Consulta para obtener todos los oficios
            $sql = "SELECT * FROM oficio";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $option = "";

                // Itera a través de los oficios y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_oficio;
                    $nombre = $fila->puesto_trabajo;

                    // Agrega una opción al filtro
                    $option .= "<option value='$id' id='id_estudio' name='id_estudio'>$nombre</option>";
                }

                // Imprime las opciones HTML generadas
                echo $option;
            }
    }

//Funcion para listar los institutos
    function listarinstitutos($conexion){
            // Consulta para obtener todos los idiomas
            $sql = "SELECT * FROM instituto";
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta
            if($stmt->execute()) {
                // Inicializa una cadena para almacenar las opciones HTML
                $option = "";

                // Itera a través de los idiomas y genera opciones HTML
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $fila->id_instituto;
                    $nombre = $fila->nombre_instituto;

                    // Agrega una opción al filtro
                    $option .= "<option value='$id' id='id_instituto' name='instituto'>$nombre</option>";
                }

                // Imprime las opciones HTML generadas
                echo $option;
            }
    }

//Funcion de listar ofertas de trabajo
    function listarofertasalumno($conexion){
        // Consulta para obtener todas las empresas
        $sql = "SELECT * FROM `oferta_trabajo` JOIN `empresa` ON `oferta_trabajo`.`id_usuario` = `empresa`.`id_usuario` where oferta_trabajo.activa=1 and oferta_trabajo.validada=1;";
        $stmt = $conexion->prepare($sql);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Inicializa una cadena para almacenar las opciones HTML
            $filtro = "";
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $id = $fila->id_oferta;
                $titulo = $fila->titulo;
                $nombre_empresa = $fila->nombre_empresa;
    
                // Agrega una opción al filtro
                $filtro .= "<option value='$id' name='EmpresaSelect' >$nombre_empresa-$titulo</option>";
            }
    
            // Imprime las opciones HTML generadas
            echo $filtro;
        }
    }
    function listaralumnoofertas($conexion){
        // Consulta para obtener todas las empresas
        $sql = "SELECT * FROM `alumno`; ";
        $stmt = $conexion->prepare($sql);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Inicializa una cadena para almacenar las opciones HTML
            $filtro = "";
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $id = $fila->id_usuario;
                $dni = $fila->dni;
                $nombre = $fila->nombre;
    
                // Agrega una opción al filtro
                $filtro .= "<option value='$id' name='EmpresaSelect' >$nombre-$dni</option>";
            }
    
            // Imprime las opciones HTML generadas
            echo $filtro;
        }
    }
?>