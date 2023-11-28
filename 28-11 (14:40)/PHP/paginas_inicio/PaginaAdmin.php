
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

            }
            
        </style>


        
    <script src="../../JS/paginas_inicio/PaginaAdmin.js"></script>
    </head>
    <body>
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
                    </div>

                <?php 
                
                    if(isset($_POST['agregarestudio'])||isset($_POST['eliminarexperiencia'])|| isset($_POST['eliminaridioma']) || isset($_POST['limpiar'])|| isset($_POST['eliminarestudio']) || isset($_POST['agregarIdioma'])||isset($_POST['agregarExperiencia'])|| isset($_POST['insertoferta'])){             
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
                        ?>
                            <!-- Ventana Modal INSERTAR OFERTAS -->
                            <div id="myModalOfertas" class="modal" style="display: block;">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
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
                                        <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
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

                                            <label for="carnetConducir">¿Tiene carnet de conducir?</label>
                                            <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si">

                                            <label for="cochepropio">¿Tiene carnet de conducir?</label>
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
                                <input type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="Nombre de usuario">

                                <label for="contraseñalabel">Contraseña:</label>
                                <input type="password" id="contraseña" name="contraseña" required placeholder="Contraseña">

                                <label for="contraseña">Email:</label>
                                <input type="email" id="email" name="emailbtn" required placeholder="Email">

                                <label for="dni">DNI:</label>
                                <input type="text" id="dni" name="dni" required placeholder="DNI">
                    
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" required placeholder="Nombre">
                                
                            <label for="Fecha_Nacimiento">Fecha Nacimiento:</label>
                            <input type="date" id="Fecha_nacimiento" name="Fecha_nacimiento" required placeholder="Fecha_nacimiento">

                                <label for="Apellido">Apellidos:</label>
                                <input type="text" id="Apellido" name="Apellido"  placeholder="Apellidos">

                                <label for="carnetConducirCheckbox">¿Tienes carnet de conducir?</label>
                                <input type="checkbox" id="carnetConducirCheckbox" name="carnetConducir" value="si">

                                <label for="cochepropioCheckbox">¿Tienes coche propio?</label>
                                <input type="checkbox" id="cochepropio" name="cochepropio" value="si">

                                <label for="aptitudes">Aptitudes:</label>
                                <input type="text" id="aptitudes" name="aptitudes"  placeholder="Aptitudes">

                                <label for="actitudes">Actitudes:</label>
                                <input type="text" id="actitudes" name="actitudes"  placeholder="Actitudes">
                                        
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" id="telefono" name="telefono"  placeholder="Teléfono">

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

                <div id="botones">
                    <div id="empresabtn">
                        <a href="empresas-admin">
                            <button id="button" class="custom-button">
                                <i id="imgIconos" class="fa-solid fa-list fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafoIconos">EMPRESAS</p>
                            </button>
                        </a>
                    </div>
                    <div  id="ofertasbtn">
                        <a  href="ofertas-admin">
                            <button id="button" class="custom-button">
                                <i id="imgIconos" class="fa-solid fa-bag-shopping fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafoIconos">OFERTAS</p>
                            </button>
                        </a>
                    </div>
                    <div id="Usuariosbtn">
                        <a href="usuarios-admin">
                            <button id="button" class="custom-button" >
                                <i id="imgIconos" class="fa-solid fa-users fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafoIconos">ALUMNOS</p>
                            </button>
                        </a>
                    </div>
                </div>
        </main>
        <?php include "../includes/footer.php" ?>
         <!-- Ventana modal -->


    </body>
</html>



<!-- Función para abrir la ventana modal -->

<script src="../../JS/validaciones/pagina_inicio/paginaAdmin.js"></script>
<script>
    // Función para abrir la ventana modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

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

