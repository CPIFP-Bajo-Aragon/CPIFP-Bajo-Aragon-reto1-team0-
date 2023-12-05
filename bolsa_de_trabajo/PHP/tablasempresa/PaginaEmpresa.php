<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">


    <title>Menu Empresa</title>

    <?php
        include("../includes/conexion.php");
        // include("../includes/funciones/funcionesempresa.php");
        include("../includes/links.php");
    ?>

    <style>
        @media (max-width: 700px) {
            main{
                padding: 0;
                margin: 0;
            }

            footer {
                width: 100%;
                height: 10vh;
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
                background-color: rgba(26, 154, 182, 0.3);
                color: #fff;

            }

            header{
                width: 100%;
                height: 10vh;
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
                background-color: rgba(26, 154, 182, 0.3);
                color: #fff;
            }
        }
/************************************** */
        #datos1{
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }
        #datos2{
            display: flex;
            justify-content: center; 
        }
        #datos3{
            text-align:center;
        }

        /*No borrar, si esto no está en el css no funciona el darle al nombre y que se despliegue el reto de la información*/
        .content {
            display: none;
        }

        .content.show {
            display: block;
        }  

        .contenedor {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 3vh;
            margin-top: 3vh;
        }

        .botonPublicar, .botonBuscar {
            margin: 5px;
        }

        #datos2 {
    width: auto;
    max-width: 100%;
    resize: vertical;
  }

  #datos2 textarea {
    width: 100%;
    resize: none;
    overflow-y: hidden;
    text-align: center;
    white-space: pre-wrap; /* Permite que el texto se envuelva automáticamente */
    overflow-x: hidden; /* Oculta la barra de desplazamiento horizontal */
    height: auto; /* Ajusta automáticamente la altura según el contenido */
    min-height: 50px; /* Establece una altura mínima para evitar que sea demasiado pequeño */
  }
    </style>
</head>
<body>  

    <?php
        include("../includes/cabecera_registrado.php");
        // include("../includes/conexion.php");
        include("../includes/funciones.php");
    ?>
    
    <main id="mainofertaspublicadasempresa">
        
        <h1 class="titulo">OFERTAS PUBLICADAS</h1>
        
        <div class="contenedor">
            <button id="openModal" class="botonPublicar"><i class="fa-solid fa-plus"></i></button>
            <a href="buscar-alumno" class="botonBuscar"><button><i class="fa-solid fa-magnifying-glass"></i></button></a>
        </div>

        <div class="todasOfertas">
            
            <div id="tabla">
                    <?php
                        // Manejo de paginación y obtención de datos de ofertas de trabajo desde la base de datos
                        // $pagina = 1; 
                        // $max_filas_por_pagina = 5;
                        // if (isset($_POST['pagina'])) {
                        //     $pagina = $_POST['pagina'];
                        // }
                        
                        // $inicio = ($pagina - 1) * $max_filas_por_pagina;

                        // Consulta para obtener el total de filas de ofertas de trabajo
                        $sql = "SELECT COUNT(*) FROM oferta_trabajo as o LEFT JOIN empresa as e ON o.id_usuario = e.id_usuario";
                        $totalConsulta = $conexion->prepare($sql);
                        $totalConsulta->execute();
                        $total_filas = $totalConsulta->fetchColumn();
                        $id_usuario=$_SESSION['id_usuario'];

                        // Consulta para obtener las ofertas de trabajo paginadas

                        $sql = "SELECT OT.id_oferta as id_oferta, OT.titulo AS Titulo, OT.descripcion_oferta AS Descripcion_Oferta, OT.fecha_publicacion AS Fecha_Publicacion, OT.duracion_contrato AS Duracion_Contrato, OT.carnet_conducir AS Carnet_Conducir, OT.vehiculo_propio, OT.aptitud, P.nombre AS Nombre_Poblacion, P.id_poblacion as id_poblacion FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario WHERE E.id_usuario=$id_usuario ORDER BY fecha_publicacion DESC";  //LIMIT $inicio, $max_filas_por_pagina
                        
                        $consulta = $conexion->prepare($sql);
                        
                        // Mostrar resultados en la tabla
                        if ($consulta->execute()) {
                            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $id_oferta = $fila->id_oferta;
                            
                                    echo "<section class='sectionPrueba'>";
                                        echo "<div id='tabla' class='datosOfertass'>";
                                        echo "<div id='datos1'><p></p><h1 class='titulo-oferta'>" . $fila->Titulo." "."<i class='fas fa-caret-down'></i> "."</h1>";                                echo "<p class='fecha'>" . date('d-m-Y', strtotime($fila->Fecha_Publicacion)) . "</p></div>";                     
                                        // echo "<div id='datos2'><p>" . $fila->Descripcion_Oferta . "</p></div>";
                                        echo "<div id='datos2'><textarea readonly>" . $fila->Descripcion_Oferta . "</textarea></div>";
                                        echo "<div class='content'>";
                                        echo "<p><strong>Duración del contrato: </strong>" . $fila->Duracion_Contrato . " meses</p>";
                                        echo "<p><strong>Requiere carnet de conducir: </strong>" . ($fila->Carnet_Conducir ? "Sí" : "No") . "</p>";
                                        echo "<p id='".$fila->id_poblacion."'><strong>Población: </strong>" . $fila->Nombre_Poblacion . "</p>";
                                        echo "<p><strong>Aptitudes requeridas: </strong>" . $fila->aptitud . "</p>";
                                        echo "<p><strong>Requiere vehículo propio: </strong>" . ($fila->vehiculo_propio ? "Sí" : "No") . "</p>";
                                        echo "</div>";
                                        echo "<div id='datos3'><button class='btn_inscritos' data-modal-id='$id_oferta'>Alumnos inscritos</button></div>";
                                        echo "</div>";
                                        echo "<button type='submit' name='editar' id='editar_$fila->id_oferta'><i class='fas fa-pencil-alt'></i></button>";

                                    echo "</section>";
                        }
                            
                        } else {
                            // Mensaje si no se encuentran ofertas de trabajo
                            echo "<tr><td colspan='8'>No se encontraron ofertas de trabajo.</td></tr>";
                        }
                    ?>
                    <!-- Elemento div extra no válido dentro de la tabla -->
                    <!-- <div id="midiv"></div> -->
            </div>
        </div>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarestudio'])||isset($_POST['eliminarexperiencia'])|| isset($_POST['eliminaridioma']) || isset($_POST['limpiar'])|| isset($_POST['eliminarestudio']) || isset($_POST['agregarIdioma'])||isset($_POST['agregarExperiencia'])|| isset($_POST['insertoferta'])){             
                        // Agregar estudios
                        if(isset($_POST['agregarestudio'])){
                            // Recopila los datos del formulario y los almacena en la sesión
                            $_SESSION['Titulo'] = $_POST['titulobtn'];
                            $_SESSION['Descripcion'] = $_POST['Descripcionbtn'];
                            $_SESSION['Duracion'] = $_POST['Duracionbtn'];
                            $_SESSION['Aptitudes'] = $_POST['AptitudBtn'];
                            if(isset($_POST['carnetConducir'])){
                                $_SESSION['carnetConducir'] = $_POST['carnetConducir'];
                            }
                            if(isset($_POST['cochepropio'])){
                                $_SESSION['cochepropio'] = $_POST['cochepropio'];
                            }
                            $_SESSION['Poblacion'] = $_POST['PoblacionSelect'];
                            // Obtiene la opción seleccionada para los estudios desde el formulario
                                $selectedEstudio = $_POST['EstudiosSelect'];
                            // Obtiene la información actual de los estudios almacenada en la sesión
                                $estudios = $_SESSION['estudios'];
                                if (!in_array($selectedEstudio, $estudios)) {
                                    // Si no está presente, actualiza la información en la sesión
                                    $_SESSION['estudios'][] = $selectedEstudio; // Añade la nueva opción al array
                                }
                        }
                        if(isset($_POST['limpiar'])){
                                $_SESSION['Titulo']="";
                                $_SESSION['Descripcion']="";
                                $_SESSION['Duracion']="";
                                $_SESSION['Aptitudes']="";
                                $_SESSION['carnetConducir']="";
                                $_SESSION['cochepropio']="";
                                $_SESSION['Poblacion']="";
                                
                                $estudios = array();
                                $idioma = array();
                                $experiencia=array();
                                $_SESSION['estudios'] = [];
                                $_SESSION['idiomas']=[];
                                $_SESSION['experiencia'] = []; // Asigna un array vacío antes de agregar elementos
                        }
                        //Eliminar estudio
                            if (isset($_POST['eliminarestudio'])) {
                                // Verificar si 'estudio_index' está establecido en los datos POST
                                if (isset($_POST['estudio_index'])) {
                                    
                                    $estudioIndex = $_POST['estudio_index'];
                                    // Buscar el índice del elemento en $_SESSION['estudios']
                                        $indexToRemove = array_search($estudioIndex, $_SESSION['estudios']);

                                        if ($indexToRemove !== false) {
                                            // Eliminar el elemento correspondiente del array
                                            unset($_SESSION['estudios'][$indexToRemove]);

                                            // Opcional: Reindexar el array para evitar huecos en las claves
                                            $_SESSION['estudios'] = array_values($_SESSION['estudios']);
                                        }
                                    
                                }
                            }
                        //Eliminar estudio
                        if (isset($_POST['eliminaridioma'])) {
                            // Verificar si 'idioma_index' está establecido en los datos POST
                            if (isset($_POST['idioma_index'])) {
                                $idiomaIndex['nombre'] = $_POST['idioma_index'];
                                $idiomaIndex['idioma'] = $_POST['idioma_nivel_index'];
                                // Buscar el índice del elemento en $_SESSION['idiomas']
                                $indexToRemove = array_search($idiomaIndex, $_SESSION['idiomas']);
                                if ($indexToRemove !== false) {
                                    // Eliminar el elemento correspondiente del array
                                    unset($_SESSION['idiomas'][$indexToRemove]);
                                    // Opcional: Reindexar el array para evitar huecos en las claves
                                    $_SESSION['idiomas'] = array_values($_SESSION['idiomas']);
                                }
                            }
                        }

                        if (isset($_POST['eliminarexperiencia'])) {
                            // Verificar si 'idioma_index' está establecido en los datos POST
                            
                            if (isset($_POST['nombre_index'])) {
                                $ExperienciaIndex['nombre'] = $_POST['nombre_index'];
                                $ExperienciaIndex['tiempo'] = $_POST['tiempo_index'];
                                // Buscar el índice del elemento en $_SESSION['idiomas']
                                $indexToRemove = array_search($ExperienciaIndex, $_SESSION['experiencia']);
                                if ($indexToRemove !== false) {
                                    
                                    // Eliminar el elemento correspondiente del array
                                    unset($_SESSION['experiencia'][$indexToRemove]);
                                    // Opcional: Reindexar el array para evitar huecos en las claves
                                    $_SESSION['experiencia'] = array_values($_SESSION['experiencia']);
                                }
                            }
                        }
                        
                        //AGREGAR IDIOMA
                            if (isset($_POST['agregarIdioma'])) {
                                // Asigna valores a las variables de sesión
                                    $_SESSION['Titulo'] = $_POST['titulobtn'];
                                    $_SESSION['Descripcion'] = $_POST['Descripcionbtn'];
                                    $_SESSION['Duracion'] = $_POST['Duracionbtn'];
                                    $_SESSION['Aptitudes'] = $_POST['AptitudBtn'];
                                    if(isset($_POST['carnetConducir'])){
                                        $_SESSION['carnetConducir'] = $_POST['carnetConducir'];
                                    }
                                    if(isset($_POST['cochepropio'])){
                                        $_SESSION['cochepropio'] = $_POST['cochepropio'];
                                    }
                                    $_SESSION['Poblacion'] = $_POST['PoblacionSelect'];
                                // Almacenar información del idioma en $_SESSION['idiomas']
                                    $selectedIdioma = isset($_POST['IdiomaSelect']) ? $_POST['IdiomaSelect'] : '';
                                    $selectedNivel = isset($_POST['NivelSelect']) ? $_POST['NivelSelect'] : '';
                                // Verifica si ya existe un idioma con el mismo nombre en $_SESSION['idiomas']
                                    $idiomaExistente = false;
                                    foreach ($_SESSION['idiomas'] as $idioma) {
                                        if (isset($idioma['nombre']) && $idioma['nombre'] === $selectedIdioma) {
                                            $idiomaExistente = true;
                                            break;
                                        }
                                    }
                                if (!$idiomaExistente && $selectedIdioma !== '') {
                                    // Solo agrega el idioma si no existe y el nombre no está vacío
                                        $_SESSION['idiomas'][] = ['nombre' => $selectedIdioma, 'idioma' => $selectedNivel];
                                }
                            }
                        // Agregar experiencias
                            if (isset($_POST['agregarExperiencia'])) {
                                // Guarda los valores del formulario en variables de sesión
                                $_SESSION['Titulo'] = $_POST['titulobtn'];
                                $_SESSION['Descripcion'] = $_POST['Descripcionbtn'];
                                $_SESSION['Duracion'] = $_POST['Duracionbtn'];
                                $_SESSION['Aptitudes'] = $_POST['AptitudBtn'];
                                if(isset($_POST['carnetConducir'])){
                                    $_SESSION['carnetConducir'] = $_POST['carnetConducir'];
                                }
                                if(isset($_POST['cochepropio'])){
                                    $_SESSION['cochepropio'] = $_POST['cochepropio'];
                                }
                                
                                $_SESSION['Poblacion'] = $_POST['PoblacionSelect'];
                            
                                // Obtiene la opción seleccionada para la experiencia desde el formulario
                                $selectedExperiencia = $_POST['ExperienciaSelect'];
                                $TiempoExperiencia = $_POST['Experiencia'];
                            
                                // Obtiene la información actual de la experiencia almacenada en la sesión
                                $experiencia = isset($_SESSION['experiencia']) ? $_SESSION['experiencia'] : array(); // Inicializa como un array si no existe
                            
                                $insertado = false;
                            
                                // Verifica si la experiencia ya está en la sesión
                                foreach ($experiencia as $exp) {
                                    if ($exp['nombre'] == $selectedExperiencia) {
                                        $insertado = true;
                                        break; // Sal del bucle si la experiencia ya está insertada
                                    }
                                }
                            
                                // Almacena la información actualizada de la experiencia en la sesión
                                if (!$insertado && $selectedExperiencia != "" && $TiempoExperiencia != "") {
                                    $_SESSION['experiencia'][] = ['nombre' => $selectedExperiencia, 'tiempo' => $TiempoExperiencia];
                                }
                            }
                        //Insertar oferta
                            if(isset($_POST['insertoferta'])){
                                $_SESSION['Titulo']="";
                                $_SESSION['Descripcion']="";
                                $_SESSION['Duracion']="";
                                $_SESSION['Aptitudes']="";
                                $_SESSION['carnetConducir']="";
                                $_SESSION['cochepropio']="";
                                $_SESSION['Poblacion']="";
                                
                                insertarofertempresa($conexion, $_SESSION['estudios'], $_SESSION['idiomas'], $_SESSION['experiencia']);
                                
                                $estudios = array();
                                $idioma = array();
                                $experiencia=array();
                                $_SESSION['estudios'] = [];
                                $_SESSION['idiomas']=[];
                                $_SESSION['experiencia'] = []; // Asigna un array vacío antes de agregar elementos
                                echo '<script>window.location.href = "/PHP/paginas_inicio/insetar/empresa/index.php";</script>';
                                
                                
                            }
                        ?>
                            <!-- Ventana Modal INSERTAR OFERTAS -->
                            <div id="myModalOfertas" class="modal" style="display: block;">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
                                            <h2>Nueva oferta trabajo</h2>
                                            <form id="insertForm" action="pagina-empresa" method="POST"  onsubmit="return validarregistrooferta(event)">
                                                <!-- Agrega tus campos del formulario aquí -->
                                                <label for="titulolabel">Titulo:</label>
                                                <input type="text" id="titulobtn" name="titulobtn" required placeholder="Título" value="<?php echo isset($_SESSION['Titulo']) ? $_SESSION['Titulo'] : ''; ?>">
                                                                                    
                                                <label for="Descripcionlabel">Descripcion:</label>
                                                <input type="text" id="Descripcionbtn" name="Descripcionbtn" required placeholder="Descripción" value="<?php echo isset($_SESSION['Descripcion']) ? $_SESSION['Descripcion'] : ''; ?>">

                                                <label for="DuracionLabel">Duracion contrato:</label>
                                                <input type="number" id="Duracionbtn" name="Duracionbtn" placeholder="Duración" value="<?php echo isset($_SESSION['Duracion']) ? $_SESSION['Duracion'] : ''; ?>">

                                                <label for="AptitudLabel">Aptitudes:</label>
                                                <input type="text" id="AptitudBtn" name="AptitudBtn" placeholder="Aptitudes" value="<?php echo isset($_SESSION['Aptitudes']) ? $_SESSION['Aptitudes'] : ''; ?>">

                                                <label for="carnetConducir">¿Tiene carnet de conducir?</label>
                                                <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si" <?php echo (isset($_SESSION['carnetConducir']) && $_SESSION['carnetConducir'] == 'si') ? 'checked' : ''; ?>>

                                                <label for="coche">¿Tiene coche propio?</label>
                                                <input type="checkbox" id="cochepropio" name="cochepropio" value="si" <?php echo (isset($_SESSION['cochepropio']) && $_SESSION['cochepropio'] == 'si') ? 'checked' : ''; ?>>

                                                <label for="PoblacionLabel">Poblacion:</label>
                                                <select name="PoblacionSelect" id="PoblacionSelect">
                                                    
                                                    <?php
                                                        if(isset($_SESSION['Poblacion'])){
                                                            $id_poblacion=$_SESSION['Poblacion'];
                                                            $nombrepoblacion=mostrarPoblacion($conexion, $id_poblacion);?>

                                                             <option value='<?php echo "$id_poblacion" ?>'><?php echo "$nombrepoblacion" ?></option>;
                                                            
                                                            <?php
                                                        }
                                                        listarProvinciaypoblacion($conexion);
                                                    ?>
                                                </select>

                                                <!-- Múltiples Estudios -->
                                                        <label for="EstudiosLabel">Estudios:</label>
                                                        <select name="EstudiosSelect" id="EstudiosSelect" >
                                                            <?php
                                                                listarestudios($conexion);
                                                            ?>
                                                        </select>
                                                        <div id="DIVEstudios">
                                                            <?php
                                                            // Recorre la matriz y muestra su contenido
                                                                if(isset($_SESSION['estudios']) && is_array($_SESSION['estudios'])) {
                                                                    foreach ($_SESSION['estudios'] as $estudio) {
                                                                        $nombreestudio = mostrarestudios($conexion, $estudio);
                                                                        ?>
                                                                        <div class='estudio-container'>
                                                                                <p class='estudio-title'> Título: <?= $nombreestudio ?></p>
                                                                                <input type='hidden' name='estudio_index' value='<?= $estudio ?>'>
                                                                                <button type='submit' name='eliminarestudio' id='eliminarestudio'>Eliminar Estudio</button>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                        
                                                        <button type="submit" name="agregarestudio" id="agregarestudio">Agregar Estudio</button>

                                                <!-- Múltiples Idiomas -->
                                                
                                                    <label for="IdiomaSelect">Idioma:</label>
                                                    <select name="IdiomaSelect" id="IdiomaSelect" >
                                                        <?php
                                                            listaridioma($conexion)
                                                        ?>
                                                    </select>
                                                    <select name="NivelSelect" id="NivelSelect" >
                                                        <?php
                                                            listarnivel($conexion);
                                                        ?>
                                                    </select>
                                                    <div id="DIVIdiomas">
                                                        <?php
                                                            // Recorre la matriz y muestra su contenido
                                                                if(isset($_SESSION['idiomas']) && is_array($_SESSION['idiomas'])) {
                                                                    foreach ($_SESSION['idiomas'] as $idiomas) {
                                                                        $idnivel = $idiomas['idioma']; // Check if this is the correct key
                                                                        $ididioma = $idiomas['nombre']; // Check if this is the correct key
                                                                        $idioma = mostraridioma($conexion, $ididioma);
                                                                        $nivel = mostrarnivel($conexion, $idnivel);
                                                                
                                                                        echo "<div class='estudio-container'>";
                                                                        echo "<p class='estudio-title'> Título: " . $idioma . " Nivel: " . $nivel . "</p>";
                                                                        echo "<input type='hidden' name='idioma_index' value='$ididioma'>"; // Update the name attribute
                                                                        echo "<input type='hidden' name='idioma_nivel_index' value='$idnivel'>"; // Update the name attribute
                                                                        echo "<button type='submit' name='eliminaridioma'>Eliminar Idioma</button>";
                                                                        echo "</div>";
                                                                    }
                                                                }
                                                            ?>
                                                    </div>
                                                    <button type="submit" name="agregarIdioma" id="agregarIdioma">Agregar Idioma</button>

                                                <!-- Múltiples Experiencias -->
                                                    <label for="ExperienciaSelect">Experiencia:</label>
                                                    <select name="ExperienciaSelect" id="ExperienciaSelect" >
                                                        <?php
                                                            listaroficios($conexion);
                                                        ?>
                                                    </select>
                                                    <label for="">Meses de experiencia</label>             
                                                    <input type="text" id="Experiencia" name="Experiencia">
                                                    <div id="DIVExperiencia">
                                                    <?php
                                                        // Recorre la matriz y muestra su contenido
                                                        if(isset($_SESSION['experiencia']) && is_array($_SESSION['experiencia'])) {
                                                            foreach ($_SESSION['experiencia'] as $experiencia) {
                                                                $idnombre=$experiencia['nombre'];
                                                                $tiempo=$experiencia['tiempo'];
                                                                $nombre=mostrarexperiencia($conexion, $idnombre);
                                                                echo "<div class='estudio-container'>";
                                                                echo "<p class='estudio-title'>Trabajo de : " . $nombre ." por: ". $tiempo . "meses</p>";
                                                                echo "<input type='hidden' name='nombre_index' value='$idnombre'>"; // Update the name attribute
                                                                echo "<input type='hidden' name='tiempo_index' value='$tiempo'>"; // Update the name attribute
                                                                echo "<button type='submit' name='eliminarexperiencia' id='eliminarexperiencia'>Eliminar experiencia</button>";
                                                                echo "</div>";
                                                            }
                                                        }
                                                    ?>
                                                    </div>
                                                    <button type="submit" name="agregarExperiencia" id="agregarExperiencia">Agregar Experiencia</button>

                                                <!-- Botón de Envío -->
                                                    <button type="submit" name="insertoferta" id="insertoferta">Insertar Datos</button>
                                                    
                                                    <button type="submit" name="limpiar" id="limpiar">Limpiar datos</button>
                                            </form>
                                        </div>
                                    </div>
                        <?php
        }else{
                        // Crear un array vacío
                            $estudios = array();
                            $idioma = array();
                            $experiencia=array();
                            $_SESSION['estudios'] = [];
                            $_SESSION['idiomas']=[];
                            $_SESSION['experiencia'] = []; // Asigna un array vacío antes de agregar elementos
                                ?>
                                
                                <!-- Ventana Modal INSERTAR OFERTAS -->
                                    <div id="myModalOfertas" class="modal">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
                                        <h2>Nueva oferta trabajo</h2>
                                        <form id="insertForm" action="pagina-empresa" method="POST" onsubmit="return validarregistrooferta(event)">
                                            <!-- Agrega tus campos del formulario aquí -->
                                            <label for="titutlolabel">Titulo:</label>
                                            <input type="text" id="titulobtn" name="titulobtn" required placeholder="Título">
                                            
                                            <label for="Descripcionlabel">Descripcion:</label>
                                            <input type="text" id="Descripcionbtn" name="Descripcionbtn" required placeholder="Descripción">

                                            <label for="DuracionLabel">Duracion contrato:</label>
                                            <input type="number" id="Duracionbtn" name="Duracionbtn" required placeholder="Duración">

                                            <label for="AptitudLabel">Aptitudes:</label>
                                            <input type="text" id="AptitudBtn" name="AptitudBtn" required placeholder="Aptitudes">

                                            <label for="carnetConducir">¿Tiene carnet de conducir?</label>
                                            <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si">

                                            <label for="coche">¿Tiene coche propio?</label>
                                            <input type="checkbox" id="cochepropio" name="cochepropio" value="si" <?php echo (isset($_SESSION['cochepropio']) && $_SESSION['cochepropio'] == 'si') ? 'checked' : ''; ?>>


                                            <label for="PoblacionLabel">Poblacion:</label>
                                            <select name="PoblacionSelect" id="PoblacionSelect">
                                                <?php
                                                    listarProvinciaypoblacion($conexion);
                                                ?>
                                            </select>

                                            <!-- Múltiples Estudios -->
                                                    <label for="EstudiosLabel">Estudios:</label>
                                                    <select name="EstudiosSelect" id="EstudiosSelect" >
                                                        <?php listarestudios($conexion);?>
                                                    </select>
                                                    
                                                    <button type="submit" name="agregarestudio" id="agregarestudio">Agregar Estudio</button>

                                            <!-- Múltiples Idiomas -->
                                                <label for="IdiomaSelect">Idioma:</label>
                                                <select name="IdiomaSelect" id="IdiomaSelect" >
                                                    <?php listaridioma($conexion)?>
                                                </select>
                                                <select name="NivelSelect" id="NivelSelect" >
                                                    <?php
                                                        listarnivel($conexion);
                                                    ?>
                                                </select>
                                                <button type="submit" name="agregarIdioma" id="agregarIdioma">Agregar Idioma</button>

                                            <!-- Múltiples Experiencias -->
                                                <label for="ExperienciaLabel">Experiencia:</label>
                                                <select name="ExperienciaSelect" id="ExperienciaSelect" >
                                                    <?php
                                                        listaroficios($conexion);
                                                    ?>
                                                </select>             
                                                <label for="">Meses de experiencia</label>             
                                                <input type="text" id="Experiencia" name="Experiencia">     
                                                <button type="submit" name="agregarExperiencia" id="agregarExperiencia">Agregar Experiencia</button>

                                            <!-- Botón de Envío -->
                                                <button type="submit" name="insertoferta" id="insertoferta">Insertar Datos</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
        }
            
        ?>
        <div id="editaroferta">

        </div>
        
    </main>

<script>


    function cargarVentanaModal(id_oferta) {
        fetch('/PHP/tablasempresa/obtener_datos_alumnos.php?id_oferta=' + id_oferta)
            .then(response => response.json())
            .then(datosAlumnos => {
                pintarDatosEnModal(datosAlumnos);
                modal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error al parsear JSON: ', error);
            });
    }

    function pintarDatosEnModal(datosAlumnos, id_oferta) {
        var datosAlumnosDiv = document.getElementById('datosAlumnos');
        datosAlumnosDiv.innerHTML = '';

        datosAlumnos.forEach(function(alumno) {
            var id_usuario = datosAlumnos[0].id_usuario;
            var alumnoDiv = document.createElement('div');
            alumnoDiv.textContent = alumno.nombre;
            datosAlumnosDiv.appendChild(alumnoDiv);

           var botonCurriculum = document.createElement('button');
        botonCurriculum.textContent = 'Ver perfil';
        botonCurriculum.className = 'botonPerfil';
        botonCurriculum.addEventListener('click', function() {
        // Verifica que haya datos en la respuesta
        // Redirige a la página del currículum utilizando el archivo PHP correspondiente y el id_usuario
            window.location.href = 'ver-curriculum?id_usuario=' + id_usuario;
    });
            //var formemail = document.createElement('form');
            //formemail.method='POST';
            
            //var inputEmail = document.createElement('input');
            //inputEmail.type='hidden';
            //inputEmail.value=id_usuario;

            //var botonMandarEmail = document.createElement('button');
            //botonMandarEmail.textContent = 'Mandar Email';
            //botonMandarEmail.className = 'MandarEmail';
            //botonMandarEmail.name = 'Mandar_Email';
            
            //formemail.appendChild(botonMandarEmail);
            //formemail.appendChild(inputEmail);
            //alumnoDiv.appendChild(botonCurriculum);
            //alumnoDiv.appendChild(formemail);

            //datosAlumnosDiv.appendChild(alumnoDiv);
    });
        
    }

    var buttons = document.querySelectorAll('.btn_inscritos');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id_oferta = this.getAttribute('data-modal-id');
            cargarVentanaModal(id_oferta);
        });
    });

    // Función para crear la modal dinámicamente
    function crearModal() {
        var modalContent = document.getElementById('editaroferta');

        var modal = document.createElement('div');
        modal.id = 'miModal';
        modal.className = 'modal';

        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';

        var closeButton = document.createElement('span');
        closeButton.className = 'closeI';
        closeButton.id = 'cerrarModal';
        closeButton.textContent = '×';

        var modalTitle = document.createElement('h2');
        modalTitle.textContent = 'Alumnos inscritos';

        var modalData = document.createElement('div');
        modalData.id = 'datosAlumnos';

        modalContent.appendChild(closeButton);
        modalContent.appendChild(modalTitle);
        modalContent.appendChild(modalData);

        modal.appendChild(modalContent);

        return modal;
    };
</script>


<script>
    // Función para abrir la ventana modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

     // Asigna la función openModal al botón de abrir modal para ofertas
    document.getElementById('openModal').addEventListener('click', function() {
        openModal('myModalOfertas');
    });

     // Función para cerrar la ventana modal
     function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para ofertas
    document.getElementById('myModalOfertas').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalOfertas');
    });
</script>
<script>
    const sections = document.querySelectorAll('section');

    sections.forEach(section => {
        const h1 = section.querySelector('h1');
        const content = section.querySelector('.content');

        h1.addEventListener('click', () => {
            content.classList.toggle('show');
        });
    });
</script>


<script>
 // Función para abrir un modal
    function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'block';
    }

    // Función para cerrar un modal
    function cerrarModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Función para crear un elemento de entrada
    function crearInput(type, name, value) {
        var input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.value = value;
        return input;
    }

// Obtener el contenedor del modal por su ID

// Asigna la función openModal al botón de abrir modal para empresas
document.querySelectorAll('[name="editar"]').forEach(function (button) {
    button.addEventListener('click', function (event) {
        console.log("aaaa")
        var modalContent = document.getElementById('editaroferta');

        event.preventDefault(); // Evitar la recarga de la página por defecto
        modalContent.innerHTML = ''; // Limpiar el contenido del modal


        // Crear el botón de cerrar
        var close = document.createElement('span');
        close.className = 'close';
        close.textContent = '\u00D7';  
        close.onclick = function() {
            cerrarModal('editaroferta');
        };

        // Obtener el ID de usuario desde el botón de editar
        var idUsuario = this.getAttribute('id').replace('editar_', '');

        // Crear el título del modal
        var h2 = document.createElement('h2');
        h2.textContent = 'Editar oferta';

        // Crear el formulario
        var form = document.createElement('form');
        form.action = 'ofertas-admin';
        form.method = 'POST';

        // Crear e insertar los elementos de entrada en el formulario
        var inputTitulo = crearInput('text', 'titulo', idUsuario);
        var inputDescripccion = document.createElement("textarea");
        inputDescripccion.name= 'descripcion';
        var inputDuracion = crearInput('text', 'duracion', idUsuario);
        var inputCarnet = crearInput('checkbox', 'carnet', idUsuario);
        var inputID = crearInput('hidden', 'id_oferta', idUsuario);
        var inputSubmit = document.createElement('input');
        inputSubmit.type = 'submit';
        inputSubmit.name = 'guardar';
        inputSubmit.value = 'Guardar';

        // Asignar identificadores únicos a los elementos
        inputTitulo.id = 'inputTitulo';
        inputDescripccion.id = 'inputDescripccion';
        inputDuracion.id = 'inputDuracion';
        inputCarnet.id = 'inputCarnet';


        var labelTitulo = document.createElement('label');
        labelTitulo.textContent = 'Titulo';

        var labelDescripcion = document.createElement('label');
        labelDescripcion.textContent = 'Descripcion';

        var labelDuracion = document.createElement('label');
        labelDuracion.textContent = 'DNI';

        var labelcarnet = document.createElement('label');
        labelcarnet.textContent = '¿Solicita carnet Carnet?';


        // Agregar elementos al formulario
        form.appendChild(labelTitulo);
        form.appendChild(inputTitulo);
        form.appendChild(labelDescripcion);
        form.appendChild(inputDescripccion);
        form.appendChild(labelDuracion);
        form.appendChild(inputDuracion);
        form.appendChild(labelcarnet);
        form.appendChild(inputCarnet);
        form.appendChild(inputID);
        form.appendChild(inputSubmit);

        // Agregar elementos al contenedor del modal
        modalContent.appendChild(close);
        modalContent.appendChild(h2);
        modalContent.appendChild(form);

        // Cargar datos en el modal usando la función cargarVentanaModal
        cargarVentanaModal(idUsuario);

        // Mostrar el modal
        openModal('editaroferta');
    });
});

// Función para llenar los datos en el modal
function llenarDatosEnModal(modalOfertas) {
    document.getElementById('inputTitulo').value = modalOfertas.titulo;
    document.getElementById('inputDescripccion').value = modalOfertas.descripcion_oferta;
    document.getElementById('inputDuracion').value = modalOfertas.duracion_contrato;
    if (modalOfertas.carnet_conducir == 0) {
        // Si carnet_conducir es 0, el checkbox no está marcado
        document.getElementById('inputCarnet').checked = false;
    } else {
        // Si carnet_conducir no es 0, el checkbox está marcado
        document.getElementById('inputCarnet').checked = true;
    }
}

// Función para cargar datos en el modal
function cargarVentanaModal(idUsuario) {
    // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
    fetch('/PHP/tablas_admin/editarofertas.php?id_oferta=' + idUsuario)
        .then(response => response.json())
        .then(modalOfertas => {
            // Pinta los datos en la modal
            llenarDatosEnModal(modalOfertas);

            // Muestra la modal
            openModal('modalOfertas');
        });
}
</script>

<?php
    include("../includes/footer.php");
?>

</body>
</html>
<script src="../../JS/paginas_inicio/PagomaEmpresa.js"></script>