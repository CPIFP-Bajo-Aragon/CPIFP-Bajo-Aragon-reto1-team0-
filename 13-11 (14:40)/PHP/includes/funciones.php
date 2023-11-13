

<?php


// Función para generar la interfaz de paginación
function paginar($max_filas_por_pagina, $conexion, $total_filas) {
        
    // Calcula el número total de páginas necesarias
    $total_paginas = ceil($total_filas / $max_filas_por_pagina);

    // Imprime el inicio del menú desplegable
    echo ('Página: <select name="pagina" id="pagina" onchange="this.form.submit()">');

    // Itera a través de las páginas y genera opciones para el menú desplegable
    for ($i = 1; $i <= $total_paginas; $i++) {
        // Verifica si la página actual es la seleccionada
        $selected = ($_POST['pagina'] == $i) ? 'selected' : '';

        // Imprime la opción del menú desplegable
        echo ("<option value='$i' $selected>$i</option>");
    }

    // Cierra el menú desplegable
    echo ('</select>');
}
// Función para verificar un usuario antes se llamava validarusuario
function verificarusuario($conexion){
    // Verifica si la solicitud es de tipo POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Obtiene el nombre de usuario y contraseña del formulario
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        // Consulta para verificar los datos en la base de datos
        $sql = "SELECT COUNT(*) as cantidad FROM usuario WHERE nombre_usuario = :usuario AND contra = :contrasena";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->execute();

        // Obtiene el resultado de la consulta y la cantidad de filas encontradas
        $resultado = $stmt->fetch();
        $cantidad = $resultado["cantidad"];

        // Retorna la cantidad de filas encontradas
        return $cantidad;
    }
}



//OBTENER NOMBRES A TRAVES DEL ID
    // Función para mostrar el nombre de una población
        function mostrarPoblacion($conexion, $id_poblacion){
            // Consulta SQL para obtener el nombre de la población con el ID proporcionado
            $sql = "SELECT nombre FROM poblacion where id_poblacion = :id_poblacion";

            // Prepara la consulta utilizando la conexión proporcionada
            $consulta = $conexion->prepare($sql);

            // Asocia el valor de :id_poblacion con el parámetro proporcionado
            $consulta->bindParam(':id_poblacion', $id_poblacion, PDO::PARAM_INT);

            // Ejecuta la consulta
            if($consulta->execute()){
                // Itera a través de los resultados y obtiene el nombre de la población
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $nombre= $fila->nombre;
                }

                // Retorna el nombre de la población
                return $nombre;
            }
        }

    // Función para mostrar el nombre de un sector
        function mostrarsector($conexion, $id_sector){
            // Consulta SQL para obtener el nombre del sector con el ID proporcionado
            $sql = "SELECT nombre_sector FROM sector where id_sector = :id_sector";

            // Prepara la consulta utilizando la conexión proporcionada
            $consulta = $conexion->prepare($sql);

            // Asocia el valor de :id_sector con el parámetro proporcionado
            $consulta->bindParam(':id_sector', $id_sector, PDO::PARAM_INT);

            // Ejecuta la consulta
            if($consulta->execute()){
                // Itera a través de los resultados y obtiene el nombre del sector
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $nombre= $fila->nombre_sector;
                }

                // Retorna el nombre del sector
                return $nombre;
            }
        }


    // Función para mostrar el nombre de empresas asociadas a un usuario
        function mostrarempresas($conexion, $id_usuario){
            // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
            $sql = "SELECT nombre_empresa FROM empresa where id_usuario = :id_usuario";

            // Prepara la consulta utilizando la conexión proporcionada
            $consulta = $conexion->prepare($sql);

            // Asocia el valor de :id_usuario con el parámetro proporcionado
            $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            // Ejecuta la consulta
            if($consulta->execute()){
                // Itera a través de los resultados y obtiene el nombre de la empresa
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $nombre= $fila->nombre_empresa;
                }

                // Retorna el nombre de la empresa
                return $nombre;
            }
        }

//LISTAR PARA LOS SELECTS
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
        function listarProvinciaypoblacion($conexion, $select_name) {
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
                            <option name="<?php echo $select_name?>" value="<?php echo($id_poblacion) ?>"><?php echo ($nombre_provincia. "-" .$nombre_poblacion) ?></option>;
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
                    $filtro .= "<option value='$id' id='id_sector' name='id_sector'>$nombre</option>";
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
//COSAS DE LOS ADMINISTRADORES
    //Listar usuarios admin

//Ofertas del admin
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
            $sql = "SELECT OT.id_oferta as id_oferta, OT.titulo AS Titulo, OT.descripcion_oferta AS Descripcion_Oferta, OT.fecha_publicacion AS Fecha_Publicacion, OT.duracion_contrato AS Duracion_Contrato, OT.carnet_conducir AS Carnet_Conducir, P.nombre AS Nombre_Poblacion, P.id_poblacion as id_poblacion ,E.nombre_empresa AS Nombre_Empresa FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario LIMIT $inicio, $max_filas_por_pagina ";
            
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
                            echo ("<form action='listarofertas.php' method='post'>");
                            echo "<input type='hidden' name='id_oferta' id='id_oferta' value='$fila->id_oferta'>";
                            // echo ("<input type='submit' value='borrar' name='borrar' id='borrar'>");
                            echo ("<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash'></i></button>");
                            // echo ("<input type='submit' value='editar' name='editar' id='editar'>");
                            echo ("<button type='submit' name='editar' id='editar'><i class='fas fa-pencil-alt'></i></button>");
                            echo ("</form>");
                            echo ("</td>");
                    echo "</tr>";
                }
                
                // Formulario para la paginación
                echo ('<form action="listarofertas.php" method="post">');
                paginar($max_filas_por_pagina, $conexion, $total_filas);
                echo ('</form>');
            
            } else {
                // Mensaje si no se encuentran ofertas de trabajo
                echo "<tr><td colspan='8'>No se encontraron ofertas de trabajo.</td></tr>";
            }
        }

    // Función para borrar una oferta de trabajo y sus registros asociados
        function borrarregistroofertas($conexion, $id){
            // Elimina registros asociados a la oferta en otras tablas
            $sql = "DELETE FROM solicita_hablar_idioma WHERE id_oferta = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id);
            $consulta->execute();

            $sql = "DELETE FROM pide_tener_estudio WHERE id_oferta = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id);
            $consulta->execute();

            $sql = "DELETE FROM pedir_experiencia WHERE id_oferta = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id);
            $consulta->execute();

            $sql = "DELETE FROM inscribir WHERE id_oferta = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id);
            $consulta->execute();

            // Finalmente, elimina la oferta de trabajo
            $sql = "DELETE FROM oferta_trabajo WHERE id_oferta = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id);
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
            $sql="INSERT INTO `oferta_trabajo`(`titulo`, `descripcion_oferta`, `fecha_publicacion`, `duracion_contrato`, `aptitud`, `carnet_conducir`, `id_poblacion`, `id_usuario`) VALUES ('$titulo','$descripcion','$fecha','$duracion','$aptitud','$conducir','$id_poblacion','$id_empresa')";
            $stmtoferta = $conexion->prepare($sql);
            $stmtoferta->execute();
    
            $id_oferta = $conexion->lastInsertId(); // Obtiene el ID de la oferta insertada
            
           // Inserta en la tabla 'pide_tener_estudio'
            if (!empty($estudios)) {
                echo("hola");
                foreach ($estudios as $id_estudio) {
                    $sqlEstudio = "INSERT INTO pide_tener_estudio (id_oferta, id_estudio) VALUES (:id_oferta, :id_estudio)";
                    $stmtEstudio = $conexion->prepare($sqlEstudio);
                    $stmtEstudio->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                    $stmtEstudio->bindParam(':id_estudio', $id_estudio, PDO::PARAM_INT);

                    if ($stmtEstudio->execute()) {
                        echo("Todo correcto");
                    } else {
                        echo("Ha habido un error");
                    }
                    echo($id_estudio);
                }
            }

            // Inserta en la tabla 'pedir_experiencia'
            if (!empty($experiencia)) {
                foreach ($experiencia as $id_oficio) {
                    $sqlExperiencia = "INSERT INTO pedir_experiencia (id_oficio, id_oferta, anos_experiencia) VALUES (:id_oficio, :id_oferta, :anos_experiencia)";
                    $stmtExperiencia = $conexion->prepare($sqlExperiencia);
                    $stmtExperiencia->bindParam(':id_oficio', $id_oficio, PDO::PARAM_INT);
                    $stmtExperiencia->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                    $stmtExperiencia->bindParam(':anos_experiencia', $anos_experiencia, PDO::PARAM_INT); // Asegúrate de tener esta variable
                    $stmtExperiencia->execute();
                }
            }

            // Inserta en la tabla 'solicita_hablar_idioma'
            if (!empty($idiomas)) {
                foreach ($idioma as $idioma_data) {
                    $nombre_idioma = $idioma_data['nombre'];
                    $nivel_idioma = $idioma_data['nivel'];
                    $sqlIdioma = "INSERT INTO solicita_hablar_idioma (id_oferta, id_idioma, id_nivel) VALUES (:id_oferta, :id_idioma, :id_nivel_idioma)";
                    $stmtIdioma = $conexion->prepare($sqlIdioma);
                    $stmtIdioma->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
                    $stmtIdioma->bindParam(':id_idioma', $id_idioma, PDO::PARAM_INT);
                    $stmtIdioma->bindParam(':id_nivel_idioma', $id_nivel_idioma, PDO::PARAM_INT);
                    $stmtIdioma->execute();
                }
            }

    
            echo("Inserción exitosa<br><br>");
        }
    }
    
           
    //Editar ofertas Admin
        function editarofertasadmin($conexion, $id){
            $titulo=$_POST['titulobtn'];
            $descripcion=$_POST['Descripcionbtn'];
            $fecha=$_POST['fecha'];
            $duracion=$_POST['Duracionbtn'];
            $aptitud=$_POST['AptitudBtn'];
            $conducir=$_POST['carnetConducirCheckbox'];
            $id_poblacion=$_POST['PoblacionSelect'];
            $id_empresa=$_POST['EmpresaSelect'];
            $id_idioma=$_POST['IdiomaSelect'];
            $id_nivel_idioma=$_POST['NivelSelect'];
            $id_estudios=$_POST['EstudiosSelect'];
            $id_oficios=$_POST['ExperienciaSelect'];

            $sql="UPDATE `oferta_trabajo` SET `titulo`='$titulo',`descripcion_oferta`='$descripcion',`fecha_publicacion`='$fecha',`duracion_contrato`='$duracion',`aptitud`='$aptitud',`carnet_conducir`='$conducir',`id_poblacion`='$id_poblacion',`id_usuario`='$id_usuario' where id_oferta=$id";
        }

//Empresas para el admin
        // Función para listar empresas paginadas
            function listarempresas($conexion, $max_filas_por_pagina) {
                $pagina = 1; // Página por defecto.
                if (isset($_POST['pagina'])) {
                    $pagina = $_POST['pagina'];
                }
                $inicio = ($pagina - 1) * $max_filas_por_pagina;

                // Consulta para obtener el total de filas
                $sql_total_filas = "SELECT COUNT(*) as total_filas FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario";
                $consulta_total_filas = $conexion->prepare($sql_total_filas);
                $consulta_total_filas->execute();
                $total_filas = $consulta_total_filas->fetchColumn();

                // Consulta paginada para obtener los datos de las empresas
                $sql_empresas = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario LIMIT $inicio, $max_filas_por_pagina;";
                $consulta_empresas = $conexion->prepare($sql_empresas);

                // Ejecuta la consulta paginada
                if ($consulta_empresas->execute()) {
                    while ($fila = $consulta_empresas->fetch(PDO::FETCH_OBJ)) {
                        // Extrae la información de la empresa
                        $id_usuario = $fila->id_usuario;
                        $nombre_usuario = $fila->nombre_usuario;
                        $nombre = $fila->nombre;
                        $cif = $fila->cif;
                        $direccion = $fila->direccion;
                        $correo = $fila->correo;
                        $telefono = $fila->telefono;
                        $validado = $fila->validado;

                        // Verifica si la empresa está validada
                        if ($validado == "1") {
                            $validado = "validado";
                        } else {
                            $validado = "novalidado";
                        }

                        $id_poblacion = $fila->id_poblacion;
                        $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);
                        $id_sector = $fila->id_sector;
                        $nombre_sector = mostrarsector($conexion, $id_sector);

                        // Construye la fila de la tabla
                        $tabla = "<tr class='$validado'>";
                        $tabla .= "<td> $id_usuario<input type='hidden' name='id_usuario' value='$id_usuario'></td>";
                        $tabla .= "<td>$nombre</td>";
                        $tabla .= "<td>$nombre_usuario</td>";
                        $tabla .= "<td>$direccion</td>";
                        $tabla .= "<td>$correo</td>";
                        $tabla .= "<td>$telefono</td>";
                        $tabla .= "<td>$cif</td>";
                        $tabla .= "<td id='$id_poblacion'>$nom_poblacion</td>";
                        $tabla .= "<td>$validado</td>";
                        $tabla .= "<td id='$id_sector'>$nombre_sector</td>";

                        // Verifica si la empresa está validada y muestra los botones correspondientes
                        if ($validado == "validado") {
                            $tabla .= "<td>";
                            $tabla .= "<form action='listarempresas.php' method='post'>";
                            $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                            // $tabla .= "<input type='submit' value='borrar' name='borrar' id='borrar'>";
                            $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                            // $tabla .= "<input type='submit' value='editar' name='editar' id='editar'>";
                            $tabla .=  "<button type='submit' name='editar' id='editar'><i class='fas fa-pencil-alt'></i></button>";
                            $tabla .= "</form>";
                            $tabla .= "</td>";
                        } else {
                            $tabla .= "<td>";
                            $tabla .= "<form action='listarempresas.php' method='post'>";
                            $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                            // $tabla .= "<input type='submit' value='validar' name='validar' id='validar'>";
                            $tabla .=  "<button type='submit' name='validar' id='validar'><i class='fas fa-check'></i></button>";
                            // $tabla .= "<input type='submit' value='editar' name='editar' id='editar'>";
                            $tabla .=  "<button type='submit' name='editar' id='editar'><i class='fas fa-pencil-alt'></i></button>";
                            // $tabla .= "<input type='submit' value='borrar' name='borrar' id='borrar'>";
                            $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                            $tabla .= "</form>";
                            $tabla .= "</td>";
                        }

                        $tabla .= "</tr>";

                        // Muestra la fila en la tabla
                        echo $tabla;
                    }

                    // Llama a la función para mostrar la paginación
                    paginar($max_filas_por_pagina, $conexion, $total_filas);
                }
            }
        // Función para borrar el registro de una empresa
            function borrarregistroempresa($conexion, $id_usuario){
                try {
                    // Intenta eliminar el registro de la tabla 'empresa' usando el ID de usuario
                    $sql = "DELETE FROM empresa WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                    // Intenta eliminar el registro de la tabla 'usuario' usando el ID de usuario
                    $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();
                } catch (PDOException $e) {
                    // En caso de error, imprime un mensaje de error
                    echo "Error: " . $e->getMessage();
                }
            }
        // Función para validar el registro de una empresa
            function validarregistroempresa($conexion, $id_usuario) {

                // Prepara la consulta SQL para actualizar el campo 'validado' a 1
                $sql = "UPDATE usuario SET validado = 1 WHERE id_usuario = :id_usuario";

                // Prepara la consulta utilizando la conexión proporcionada
                $consulta = $conexion->prepare($sql);

                // Asocia el valor de :id_usuario con el parámetro proporcionado
                $consulta->bindParam(':id_usuario', $id_usuario);

                // Ejecuta la consulta para actualizar el estado de validación
                $consulta->execute();
            }
        // Función para editar el registro de una empresa en la base de datos
            function editarregistroempresa($conexion, $id) {

                // Verifica si se ha enviado el formulario
                if (isset($_POST['guardar'])) {

                    // Obtiene los datos del formulario
                    $id_usuario = $_POST['id_usuario'];
                    $nombre_usuario = $_POST['nombre_usuario'];
                    $nombre = $_POST['nombre'];
                    $cif = $_POST['cif'];
                    $direccion = $_POST['direccion'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];
                    
                    // Actualiza los datos en la base de datos
                    $sql = "UPDATE usuario
                            SET 
                            nombre_usuario = :nombre_usuario,
                            nombre=:nombre,
                            cif=:cif,
                            direccion=:direccion,
                            correo=:correo,
                            telefono=:telefono
                            WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
                    $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                    $consulta->bindParam(':cif', $cif, PDO::PARAM_STR);
                    $consulta->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                    $consulta->bindParam(':correo', $correo, PDO::PARAM_STR);
                    $consulta->bindParam(':telefono', $telefono, PDO::PARAM_STR);
                    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $consulta->execute();

                    // Redirecciona a la lista de empresas después de la edición
                    header('Location: listarempresas.php');
                    exit();
                } else {
                    // Muestra el formulario para editar

                    // Consulta los datos de la empresa a editar
                    $sql = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario WHERE usuario.id_usuario = :id";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

                    // Ejecuta la consulta y muestra el formulario con los datos actuales
                    if ($consulta->execute()) {
                        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                            $nombre_usuario = $fila->nombre_usuario;
                            $nombre = $fila->nombre;
                            $cif = $fila->cif;
                            $direccion = $fila->direccion;
                            $correo = $fila->correo;
                            $telefono = $fila->telefono;
                            
                            // Muestra el formulario con los valores actuales
                            echo "<form action='listarempresas.php' method='POST'>";
                            echo "<input type='text' name='nombre_usuario' value='$nombre_usuario'>";
                            echo "<input type='text' name='nombre' value='$nombre'>";
                            echo "<input type='text' name='cif' value='$cif'>";
                            echo "<input type='text' name='direccion' value='$direccion'>";
                            echo "<input type='text' name='correo' value='$correo'>";
                            echo "<input type='text' name='telefono' value='$telefono'>";
                            echo "<input type='hidden' name='id_usuario' value='$id'>";
                            echo "<input type='submit' name='guardar' value='Guardar'>";
                            echo "</form>";


                        }
                    }
                }
            }
            function insertarempresaadmin($conexion){
                if(isset($_POST['insertarempresa'])){
                    $nombre_usuario=$_POST['nombre_usuario'];
                    $contraseña=$_POST['contraseña'];
                    $email=$_POST['emailbtn'];
                    $cif=$_POST['cif'];
                    $nombre=$_POST['nombre'];
                    $direccion=$_POST['direccion'];
                    $descripcion=$_POST['descricion'];
                    $telefono=$_POST['telefono'];
                    $id_poblacion=$_POST['poblacionselect'];
                    $id_sector=$_POST['sectorselect'];
                    $validado=$_POST['validado'];
                    $tipo=$_POST['tipo'];

                    $sql = "INSERT INTO `usuario`( `nombre_usuario`, `password`, `nombre`, `correo`, `validado`, `tipo`) VALUES ('$nombre_usuario','$contrasena','$nombre','$email','$validado','$tipo');";
                    $consulta=$conexion->prepare('$sql');
                    $consulta->execute();

                    // Obtener el ID generado automáticamente
                        $id_insertado = $conexion->lastInsertId();

                    $sql="INSERT INTO empresa(`id_usuario`, `cif`, `nombre_empresa`, `direccion`, `descripcion`, `telefono`, `id_poblacion`, `id_sector`) VALUES ('$id_insertado','$cif','$nombre','$direccion','$descripcion','$telefono','$id_poblacion','$id_sector');";
                }
            }


//COSAS DE LAS EMPRESAS   



//codigo para encriptar y desencriptar contraseñas
    /*
        //Asi se encripta una contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Asi se haria un login si las contraseñas en la base de datos estubieran encriptadas
        if (password_verify($password, $stored_hashed_password)) {
            echo "Inicio de sesión exitoso.";
            // Aquí puedes redirigir al usuario a su área protegida, etc.
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    */


?>
