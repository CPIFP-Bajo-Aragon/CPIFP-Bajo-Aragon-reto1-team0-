
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../CSS/index.css">

        <title>Menu Admin</title>
        <?php
            include("../includes/conexion.php");
            include("../includes/funciones.php");
            include("../includes/links.php");
         ?>
        <style>
            .estudio-container {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 10px;
            }

            .estudio-title {
                font-weight: bold;
                margin-bottom: 5px;
            }

            #eliminarestudio {
                background-color: #ff0000;
                color: #fff;
                padding: 5px 10px;
                cursor: pointer;
                border: none;
            }

            #myModalAlumnoOferta form{
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr 1fr 1fr;
                text-align: center;
            }
            #solicitudempresa .estudio {
                border: solid 1px black;
                max-width: 50vh;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 7px;
                padding: 10px;
                display:grid;
                grid-template-columns:1fr;
            }

            @media (max-width: 700px) {
                #botones {
                    flex-direction: column; 
                    justify-content: space-around;
                }

                #button {
                    width: 150px; 
                    height: 150px; 
                    margin: 10px 8px;
                }

                button.custom-button {
                    width: 300px; 
                    height: 150px;
                }

                #mainpaginaadmin{
                    width: 400px;
                    margin-left: 20px; 
                }

                #ofertasbtn{
                    margin-top: 20px;
                    margin-bottom: 20px;
                }

                #Usuariosbtn{
                    margin-bottom: 20px;
                }

            }
            
        </style>
    <?php if ($_SESSION['tipoUsuario']!="administrador") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>

        
    <script src="../../JS/paginas_inicio/PaginaAdmin.js"></script>


    </head>
    <body>
        <?php if ($_SESSION['tipoUsuario']!="administrador") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
        }?>
        <!-- ISSET -->
        <?php
            include("../includes/cabecera_registrado.php");
        ?>
        <main id="mainpaginaadmin">
                <!-- Botones para abrir las modales -->
                <div class="botonesAbrirModal">
                        <button id="openModalBtn">INSERTAR EMPRESAS</button>

                        <button id="openModal">INSERTAR OFERTAS</button>

                        <button id="openBtn">INSERTAR ALUMNOS</button>

                        <button id="openBtninsert">INSERTAR ALUMNOS A UNA OFERTA</button>
                    </div>

                <?php 
                if(isset($_POST['insertoferta'])){
                    $_SESSION['Titulo']="";
                    $_SESSION['Descripcion']="";
                    $_SESSION['Duracion']="";
                    $_SESSION['Aptitudes']="";
                    $_SESSION['cochepropio']="";
                    $_SESSION['carnetConducir']="";
                    $_SESSION['Poblacion']="";
                    $_SESSION['Empresa']="";
                    
                    insertarofertasadmin($conexion, $_SESSION['estudios'], $_SESSION['idiomas'], $_SESSION['experiencia']);
                    
                    $estudios = array();
                    $idioma = array();
                    $experiencia=array();
                    $_SESSION['estudios'] = [];
                    $_SESSION['idiomas']=[];
                    $_SESSION['experiencia'] = []; // Asigna un array vacío antes de agregar elementos
                   
                }
                
                    if(isset($_POST['agregarestudio'])||isset($_POST['eliminarexperiencia'])|| isset($_POST['eliminaridioma']) || isset($_POST['limpiar'])|| isset($_POST['eliminarestudio']) || isset($_POST['agregarIdioma'])||isset($_POST['agregarExperiencia'])){             
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
                            $_SESSION['Empresa'] = $_POST['EmpresaSelect'];
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
                                $_SESSION['Empresa']="";
                                
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
                            echo "hola";
                            if (isset($_POST['nombre_index'])) {
                                $ExperienciaIndex['nombre'] = $_POST['nombre_index'];
                                $ExperienciaIndex['tiempo'] = $_POST['tiempo_index'];
                                // Buscar el índice del elemento en $_SESSION['idiomas']
                                $indexToRemove = array_search($ExperienciaIndex, $_SESSION['experiencia']);
                                if ($indexToRemove !== false) {
                                    echo "entra";
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
                                    $_SESSION['Empresa'] = $_POST['EmpresaSelect'];
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
                                $_SESSION['Empresa'] = $_POST['EmpresaSelect'];
                            
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
                            
                        ?>
                            <!-- Ventana Modal INSERTAR OFERTAS -->
                            <div id="myModalOfertas" class="modal" style="display: block;">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal('myModalOfertas')">&times;</span>        
                                            <h2>Nueva oferta trabajo</h2>
                                            <form id="insertForm" action="pagina-admin" method="POST"  onsubmit="return validarregistrooferta(event)">
                                                <!-- Agrega tus campos del formulario aquí -->
                                                <label for="titulolabel">Titulo:</label>
                                                <input type="text" id="titulobtn" name="titulobtn" required placeholder="Título" value="<?php echo isset($_SESSION['Titulo']) ? $_SESSION['Titulo'] : ''; ?>">
                                                                                    
                                                <label for="Descripcionlabel">Descripcion:</label>
                                                <input type="text" id="Descripcionbtn" name="Descripcionbtn" required placeholder="Descripción" value="<?php echo isset($_SESSION['Descripcion']) ? $_SESSION['Descripcion'] : ''; ?>">

                                                <label for="DuracionLabel">Duracion contrato:</label>
                                                <input type="number" id="Duracionbtn" name="Duracionbtn" placeholder="Duración" value="<?php echo isset($_SESSION['Duracion']) ? $_SESSION['Duracion'] : ''; ?>">

                                                <label for="AptitudLabel">Aptitudes:</label>
                                                <input type="text" id="AptitudBtn" name="AptitudBtn" placeholder="Aptitudes" value="<?php echo isset($_SESSION['Aptitudes']) ? $_SESSION['Aptitudes'] : ''; ?>">

                                                <label for="carnetConducir">¿Requiere carnet de conducir?</label>
                                                <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si" <?php echo (isset($_SESSION['carnetConducir']) && $_SESSION['carnetConducir'] == 'si') ? 'checked' : ''; ?>>

                                                <label for="coche">¿Requiere coche propio?</label>
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

                                                <label for="EmpresaLabel">Empresa:</label>
                                                <select name="EmpresaSelect" id="EmpresaSelect">
                                                    <?php
                                                        if(isset($_SESSION['Empresa'])){
                                                            $id_empresa=$_SESSION['Empresa'];
                                                            $nombreempresa=mostrarempresas($conexion, $id_empresa);
                                                            echo ("<option value='$id_empresa'>$nombreempresa</option>");
                                                        }
                                                        listarempresaselect($conexion);
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
                                                                        <div class="estudio-container">
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
                                        <span class="close" onclick="closeModal('myModalOfertas')">&times;</span>        
                                        <h2>Nueva oferta trabajo</h2>
                                        <form id="insertForm" action="pagina-admin" method="POST" onsubmit="return validarregistrooferta(event)">
                                            <!-- Agrega tus campos del formulario aquí -->
                                            <label for="titutlolabel">Titulo:</label>
                                            <input type="text" id="titulobtn" name="titulobtn" required placeholder="Título">
                                            
                                            <label for="Descripcionlabel">Descripcion:</label>
                                            <input type="text" id="Descripcionbtn" name="Descripcionbtn" required placeholder="Descripción">

                                            <label for="DuracionLabel">Duracion contrato:</label>
                                            <input type="number" id="Duracionbtn" name="Duracionbtn" required placeholder="Duración">

                                            <label for="AptitudLabel">Aptitudes:</label>
                                            <input type="text" id="AptitudBtn" name="AptitudBtn" required placeholder="Aptitudes">

                                            <label for="carnetConducir">¿Require carnet de conducir?</label>
                                            <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si">

                                            <label for="cochepropio">¿Require coche propio?</label>
                                            <input type="checkbox" id="cochepropio" name="cochepropio" value="si">

                                            <label for="PoblacionLabel">Poblacion:</label>
                                            <select name="PoblacionSelect" id="PoblacionSelect">
                                                <?php
                                                    listarProvinciaypoblacion($conexion);
                                                ?>
                                            </select>

                                            <label for="EmpresaLabel">Empresa:</label>
                                            <select name="EmpresaSelect" id="EmpresaSelect">
                                                <?php
                                                    listarempresaselect($conexion);
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
                
                if(isset($_POST['insertempresa'])){
                    insertarempresaadmin($conexion);
                
                } 
                if(isset($_POST['insertalumno'])){
                    insertalumnoadmin($conexion);
                
                } 
                if(isset($_POST['insertalumnoofertas'])){
                    $idofer = $_POST['ofertaalumno'];
                    $idalum = $_POST['alumnooferta'];

                    $sql = "SELECT COUNT(*) as dato FROM `inscribir` WHERE `id_oferta` = $idofer AND `id_usuario` = $idalum";
                    $consulta = $conexion->prepare($sql);

                    if ($consulta->execute()) {
                        $result = $consulta->fetch(PDO::FETCH_ASSOC);
                        $count = $result['dato'];

                        if ($count > 0) {
                            echo "El registro ya está insertado";
                        } else {
                            $sql = "INSERT INTO `inscribir`(`id_oferta`, `id_usuario`) VALUES ('$idofer','$idalum')";
                            $consulta = $conexion->prepare($sql);

                            if ($consulta->execute()) {
                                echo "Se ha insertado correctamente";
                            } else {
                                echo "No se ha podido insertar";
                            }
                        }
                    } else {
                        echo "Error ejecutando la consulta";
                    }

                } 
                ?>
                
                <!-- Ventana Modal INSERTAR EMPRESAS -->
                <div id="myModalEmpresa" class="modal">
                    <div class="modal-content">
                        <h2>Nueva empresa</h2>
                        <span class="close" onclick="closeModal('myModalEmpresa')">&times;</span>
                        <form id="insertForm" action="pagina-admin" method="POST" onsubmit="return validarregistroempresaadmin(event)">
                            <label for="nombre_usuario">Nombre Usuario:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="Nombre de usuario">

                            <label for="contraseñalabel">Contraseña:</label>
                            <input type="password" id="contraseña" name="contraseña" required placeholder="Contraseña">

                            <label for="contraseña">Email:</label>
                            <input type="email" id="email" name="emailbtn" required placeholder="Email">

                            <label for="cif">CIF:</label>
                            <input type="text" id="cif" name="cif" required placeholder="CIF">
                                
                            <label for="nombre">Nombre Empresa:</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Nombre">

                            <label for="direccion">Direccion:</label>
                            <input type="text" id="direccion" name="direccion"  placeholder="Dirección">

                            <label for="descripcion">Descripción empresa:</label>
                            <input type="text" id="descripcion" name="descripcion"  placeholder="Descripción">
                                
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono"  placeholder="Teléfono">

                            <label for="poblacionlabel">Población:</label>
                            <select name="Selectpoblacion" id="">
                                <?php
                                    listarProvinciaypoblacion($conexion);
                                ?>
                            </select>

                            <label for="sectorlabel">Sector:</label>
                            <select name="sectorselect" id="">
                                <?php
                                    listarsectores($conexion)
                                ?>
                            </select>
                            <input type="hidden" value="1" name="validado" id="validado">
                            <input type="hidden" value="empresa" name="tipo" id="tipo">

                            <button type="submit" name="insertempresa" id="insertempresa">Insertar Datos</button>

                        </form>
                    </div>
                </div>


            
                <!-- Ventana Modal INSERTAR ALUMNOS -->
                    <div id="myModalAlumnos" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h2>Nuevo Alumno</h2>
                            <form id="insertForm" action="pagina-admin" method="POST" onsubmit="return validarregistrodealumnosadmin(event)">
                                <label for="nombre_usuario">Nombre Usuario:</label>
                                <input type="text" id="nombre_usuario_alumno" name="nombre_usuario" required placeholder="Nombre de usuario">

                                <label for="contraseñalabel">Contraseña:</label>
                                <input type="password" id="contraseña_alumno" name="contraseña" required placeholder="Contraseña">

                                <label for="contraseña">Email:</label>
                                <input type="email" id="email_alumno" name="emailbtn" required placeholder="Email">

                                <label for="dni">DNI:</label>
                                <input type="text" id="dni_alumno" name="dni" required placeholder="DNI">
                    
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre_alumno" name="nombre" required placeholder="Nombre">
                                
                                <label for="Fecha_Nacimiento">Fecha Nacimiento:</label>
                                <input type="date" id="Fecha_nacimiento" name="Fecha_nacimiento" required placeholder="Fecha_nacimiento">

                                <label for="Apellido">Apellidos:</label>
                                <input type="text" id="Apellido_alumno" name="Apellido"  placeholder="Apellidos">

                                <label for="carnetConducirCheckbox">¿Tienes carnet de conducir?</label>
                                <input type="checkbox" id="carnetConducirCheckbox" name="carnetConducir" value="si">

                                <label for="cochepropioCheckbox">¿Tienes coche propio?</label>
                                <input type="checkbox" id="cochepropio" name="cochepropio" value="si">

                                <label for="aptitudes">Aptitudes:</label>
                                <input type="text" id="aptitudes" name="aptitudes"  placeholder="Aptitudes">

                                <label for="actitudes">Actitudes:</label>
                                <input type="text" id="actitudes" name="actitudes"  placeholder="Actitudes">
                                        
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" id="telefono_alumno" name="telefono"  placeholder="Teléfono">

                                <label for="poblacionlabel">Población:</label>
                                <select name="Selectpoblacion" id="">
                                    <?php
                                        listarProvinciaypoblacion($conexion);
                                    ?>
                                </select>
                                <input type="hidden" value="1" name="validado" id="validado">
                                <input type="hidden" value="alumno" name="tipo" id="tipo">

                                <button type="submint" name="insertalumno" id="insertalumno">Insertar Datos</button>
                            </form>
                        </div>
                    </div>

                    <div id="myModalAlumnoOferta" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('myModalAlumnoOferta')">&times;</span>
                            <h2>Insertar Un Alumno a Una Oferta</h2>
                            <form method="post">
                                <label for="">Oferta de trabajo</label>
                                <select name="ofertaalumno" id="ofertaalumno">
                                
                                    <option value='0' >Selecciona un valor</option>
                                    <?php
                                        listarofertasalumno($conexion);
                                    ?>
                                </select>
                                
                                <label for="">Alumno</label>
                                <select name="alumnooferta" id="alumnooferta">
                                    
                                    <option value='option' >Selecciona un valor</option>
                                    <?php
                                        listaralumnoofertas($conexion);
                                    ?>
                                </select>
                                
                                <button name="insertalumnoofertas">seleccionar</button>
                            </form>
                            <div id="solicitudempresa">

                            </div>
                            <div id="datosalumno">

                            </div>
                        </div>
                    </div>
                <div id="botones">
                    <div id="empresabtn">
                        <a href="empresas-admin">
                            <button id="button" class="custom-button">
                                <!--<i id="imgIconos" class="fa-solid fa-list fa-2xl"></i>--><p class="parrafooIconos"></p><p class="parrafoIconos">GESTIÓN EMPRESAS</p>
                            </button>
                        </a>
                    </div>
                    <div  id="ofertasbtn">
                        <a  href="ofertas-admin">
                            <button id="button" class="custom-button">
                            <p class="parrafooIconos"></p><p class="parrafoIconos"> GESTIÓN OFERTAS</p>
                            </button>
                        </a>
                    </div>
                    <div id="Usuariosbtn">
                        <a href="usuarios-admin">
                            <button id="button" class="custom-button" >
                                <p class="parrafooIconos"></p><p class="parrafoIconos"> GESTIÓN ALUMNOS</p>
                            </button>
                        </a>
                    </div>
                </div>
        </main>
        <?php include "../includes/footer.php" ?>
    </body>
</html>



<!-- Función para abrir la ventana modal -->

<script src="../../JS/validaciones/pagina_inicio/paginaAdmin.js"></script>
<script>
    
    

    // Función para cargar datos en el modal empresa
        document.getElementById('ofertaalumno').addEventListener('change', function(){
            var oferta = document.getElementById("ofertaalumno");

            // Obtén el valor seleccionado
            var idoferta = oferta.value;
            // console.log(idoferta);
            cargardatosempresa(idoferta);
        });
        function cargardatosempresa(idUsuario) {
        // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
        

        fetch('/PHP/paginas_inicio/admin/solicitudempresa.php?id_oferta=' + idUsuario)
            .then(response => response.json())
            .then(solicitudempresa => {
                // Pinta los datos en la modal
                llenarDatosEmpresa(solicitudempresa);
            });
        }

        function llenarDatosEmpresa(solicitudempresa){
            var div = document.getElementById("solicitudempresa");
            div.innerHTML = '';
            div.style = "box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);";
            var h2t = document.createElement("h2");
            h2t.textContent="   REQUISITOS DE LA EMPRESA";
            div.appendChild(h2t);


            // SOLICITUD POR PARTE DE LA EMPRESA REFERENTE A LA EXPERIENCIA LABORAL
                var divexp = document.createElement("div");
                divexp.id="exp";
                divexp.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Experiencia pedida por la empresa";
                divexp.appendChild(h2);

                if (typeof solicitudempresa.puesto_trabajo !== 'undefined'){

                    solicitudempresa.puesto_trabajo.forEach(function (puesto_trabajo, index) {
                    // Crea un nuevo div para cada par id_oficio y su primer mes
                        var divRegistro = document.createElement('div');
                        divRegistro.className = "estudio";
                        divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                    // Crea un nuevo label para idOficio
                        var id = document.createElement('label');
                        id.textContent = 'Oficio: ' + puesto_trabajo;
                    // Agrega el nuevo label al divRegistro
                        divRegistro.appendChild(id);
                    // Asegúrate de que haya al menos un mes en el array antes de intentar acceder
                        if (solicitudempresa.meses_experiencia[index]) {
                        // Crea un nuevo label para el primer mes
                            var meses = document.createElement('label');
                            meses.textContent = 'Tiempo Trabajado: ' + solicitudempresa.meses_experiencia[index] + ' meses';
                        // Agrega el nuevo label al divRegistro
                            divRegistro.appendChild(meses);
                        }
                    // Agrega el nuevo divRegistro al contenedor principal (div)
                    divexp.appendChild(divRegistro);
                    
                });
                }else{
                    var divRegistro = document.createElement('div');
                    var error = document.createElement('label');
                    error.textContent = 'No hay peticion refente a la experiencia laboral';
                    // Agrega el nuevo label al divRegistro
                    divRegistro.appendChild(error);
                    divexp.appendChild(divRegistro);
                }
                div.appendChild(divexp);

            // SOLICITUD POR PARTE DE LA EMPRESA REFERENTE AL IDIOMA
                var dividm = document.createElement("div");
                dividm.id="idm";
                dividm.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Idioma pedido por la empresa"
                dividm.appendChild(h2);

                if (typeof solicitudempresa.nombre_idioma !== 'undefined'){
                    solicitudempresa.nombre_idioma.forEach(function (idoma, indexidm) {
                    
                        // Crea un nuevo div para cada par id_oficio y su primer mes
                            var divRegistro = document.createElement('div');
                            divRegistro.className = "idioma";
                        divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                        // Crea un nuevo label para idOficio
                            var nombre = document.createElement('label');
                            nombre.textContent = 'Idioma: ' + idoma;
                        // Agrega el nuevo label al divRegistro
                            divRegistro.appendChild(nombre);
                        // Asegúrate de que haya al menos un mes en el array antes de intentar acceder
                            if (solicitudempresa.nivel[indexidm]) {
                            // Crea un nuevo label para el primer mes
                                var nivel = document.createElement('label');
                                nivel.textContent = 'Nivel : ' + solicitudempresa.nivel[indexidm];
                            // Agrega el nuevo label al divRegistro
                                divRegistro.appendChild(nivel);
                            }
                        // Agrega el nuevo divRegistro al contenedor principal (div)
                        dividm.appendChild(divRegistro);
                        
                    });
                }else{
                    var divRegistro = document.createElement('div');
                    var error = document.createElement('label');
                    error.textContent = 'No hay peticion referente al idioma';
                    // Agrega el nuevo label al divRegistro
                    divRegistro.appendChild(error);
                    dividm.appendChild(divRegistro);
                }
                div.appendChild(dividm);
            


            // SOLICITUD POR PARTE DE LA EMPRESA REFERENTE A TENER ESTUDIOS
                var dives = document.createElement("div");
                dives.id="es";
                dives.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Estudios pedidos por la empresa"
                dives.appendChild(h2);

                
                    if (typeof solicitudempresa.nombre_estudio !== 'undefined'){
                        solicitudempresa.nombre_estudio.forEach(function (estudio) {
                        
                            // Crea un nuevo div para cada par id_oficio y su primer mes
                                var divRegistro = document.createElement('div');
                                divRegistro.className = "estudios";
                                divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                            // Crea un nuevo label para idOficio
                                var nombre = document.createElement('label');
                                nombre.textContent = 'Estudio: ' + estudio;
                            // Agrega el nuevo label al divRegistro
                                divRegistro.appendChild(nombre);
                            // Agrega el nuevo divRegistro al contenedor principal (div)
                            dives.appendChild(divRegistro);
                            
                        });
                    }else{
                        var divRegistro = document.createElement('div');
                        var error = document.createElement('label');
                        error.textContent = 'No hay peticion referente al estudio';
                        // Agrega el nuevo label al divRegistro
                        divRegistro.appendChild(error);
                        dives.appendChild(divRegistro);
                    }
                
                div.appendChild(dives);
        }  

    
    // Función para cargar datos en el modal alumn o
        document.getElementById('alumnooferta').addEventListener('change', function(){
            var alumno = document.getElementById("alumnooferta");
            var idalumno  = alumno.value;
            cargardatosalumno(idalumno);
            
        });
        function cargardatosalumno(idUsuario) {
            // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
            

            fetch('/PHP/paginas_inicio/admin/datosalumno.php?id_usuario=' + idUsuario)
                .then(response => response.json())
                .then(datosalumno => {
                    // Pinta los datos en la modal
                    llenarDatosalumno(datosalumno);
                });
        }

        function llenarDatosalumno(datosalumno){
            var div = document.getElementById("datosalumno");
            div.innerHTML = '';
            div.style = "box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);";
            var h2t = document.createElement("h2");
            h2t.textContent="DATOS DEL ALUMNO";
            div.appendChild(h2t);


            // Datos referentes a la experiencia del alumno
                var divexp = document.createElement("div");
                divexp.id="exp";
                divexp.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Experiencia del alumno";
                divexp.appendChild(h2);

                if (typeof datosalumno.puesto_trabajo !== 'undefined'){

                    datosalumno.puesto_trabajo.forEach(function (puesto_trabajo, index) {
                    // Crea un nuevo div para cada par id_oficio y su primer mes
                        var divRegistro = document.createElement('div');
                        divRegistro.className = "expalumno";
                        divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                    // Crea un nuevo label para idOficio
                        var id = document.createElement('label');
                        id.textContent = 'Oficio: ' + puesto_trabajo;
                    // Agrega el nuevo label al divRegistro
                        divRegistro.appendChild(id);
                    // Asegúrate de que haya al menos un mes en el array antes de intentar acceder
                        if (datosalumno.fecha_inicio[index]) {
                        // Crea un nuevo label para el primer mes
                            var inicio = document.createElement('label');
                            inicio.textContent = ' Empezo el: ' + datosalumno.fecha_inicio[index];
                            var fin = document.createElement('label');
                            fin.textContent = ' Acabo el: ' + datosalumno.fecha_fin[index];
                        // Agrega el nuevo label al divRegistro
                            divRegistro.appendChild(inicio);
                            divRegistro.appendChild(fin);
                        }
                    // Agrega el nuevo divRegistro al contenedor principal (div)
                    divexp.appendChild(divRegistro);
                    
                });
                }else{
                    var divRegistro = document.createElement('div');
                    var error = document.createElement('label');
                    error.textContent = 'No hay peticion refente a la experiencia laboral';
                    // Agrega el nuevo label al divRegistro
                    divRegistro.appendChild(error);
                    divexp.appendChild(divRegistro);
                }
                div.appendChild(divexp);
        
            //Datos sobre los idiomas del alumno
                var dividm = document.createElement("div");
                dividm.id="idm";
                dividm.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Idiomas hablados por el alumno"
                dividm.appendChild(h2);

                if (typeof datosalumno.nombre_idioma !== 'undefined'){
                    datosalumno.nombre_idioma.forEach(function (idoma, indexidm) {
                    
                        // Crea un nuevo div para cada par id_oficio y su primer mes
                            var divRegistro = document.createElement('div');
                            divRegistro.className = "idioma";
                            divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";

                        // Crea un nuevo label para idOficio
                            var nombre = document.createElement('label');
                            nombre.textContent = 'Idioma: ' + idoma;
                        // Agrega el nuevo label al divRegistro
                            divRegistro.appendChild(nombre);
                        // Asegúrate de que haya al menos un mes en el array antes de intentar acceder
                            if (datosalumno.nivel[indexidm]) {
                            // Crea un nuevo label para el primer mes
                                var nivel = document.createElement('label');
                                nivel.textContent = ' Nivel : ' + datosalumno.nivel[indexidm];
                            // Agrega el nuevo label al divRegistro
                                divRegistro.appendChild(nivel);
                            }
                        // Agrega el nuevo divRegistro al contenedor principal (div)
                        dividm.appendChild(divRegistro);
                        
                    });
                }else{
                    var divRegistro = document.createElement('div');
                    var error = document.createElement('label');
                    error.textContent = 'No hay peticion referente al idioma';
                    // Agrega el nuevo label al divRegistro
                    divRegistro.appendChild(error);
                    dividm.appendChild(divRegistro);
                }
                div.appendChild(dividm);

            //Datos osbre los Estudios del alumno
                var dives = document.createElement("div");
                dives.id="es";
                dives.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                var h2 = document.createElement("h2");
                h2.textContent="Estudios obtenidos por el alumno"
                dives.appendChild(h2);

                
                    if (typeof datosalumno.nombre_estudio !== 'undefined'){
                        datosalumno.nombre_estudio.forEach(function (estudio) {
                        
                            // Crea un nuevo div para cada par id_oficio y su primer mes
                                var divRegistro = document.createElement('div');
                                divRegistro.className = "estudios";
                                divRegistro.style=" border-left: 2px solid #3498db; padding-left: 10px; ";
                            // Crea un nuevo label para idOficio
                                var nombre = document.createElement('label');
                                nombre.textContent = 'Estudio: ' + estudio;
                            // Agrega el nuevo label al divRegistro
                                divRegistro.appendChild(nombre);
                            // Agrega el nuevo divRegistro al contenedor principal (div)
                            dives.appendChild(divRegistro);
                            
                        });
                    }else{
                        var divRegistro = document.createElement('div');
                        var error = document.createElement('label');
                        error.textContent = 'No hay peticion referente al estudio';
                        // Agrega el nuevo label al divRegistro
                        divRegistro.appendChild(error);
                        dives.appendChild(divRegistro);
                    }
                
                div.appendChild(dives);
        }  

    
    // Función para abrir la ventana modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    };

    // Asigna la función openModal al botón de abrir modal para empresas
    document.getElementById('openModalBtn').addEventListener('click', function() {
        openModal('myModalEmpresa');
    });

    // Asigna la función openModal al botón de abrir modal para ofertas
    document.getElementById('openModal').addEventListener('click', function() {
        openModal('myModalOfertas');
    });

    // Asigna la función openModal al botón de abrir modal para alumnos
    document.getElementById('openBtn').addEventListener('click', function() {
        openModal('myModalAlumnos');
    });

    document.getElementById('openBtninsert').addEventListener('click', function() {
        openModal('myModalAlumnoOferta');
    });

    // Función para cerrar la ventana modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.getElementById('myModalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalEmpresa');
    });

    // Asigna la función closeModal al span de cerrar modal para ofertas
    document.getElementById('myModalOfertas').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalOfertas');
    });

    // Asigna la función closeModal al span de cerrar modal para alumnos
    document.getElementById('myModalAlumnos').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalAlumnos');
    });
</script>
