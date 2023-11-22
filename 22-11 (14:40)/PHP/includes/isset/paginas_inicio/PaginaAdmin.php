<?php
    if ($_SESSION['tipoUsuario']!="administrador") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }

    if(isset($_POST['agregarestudio'])|| isset($_POST['agregarIdioma'])||isset($_POST['agregarExperiencia'])|| isset($_POST['insertoferta'])){             
        // Agregar estudios
            if(isset($_POST['agregarestudio'])){
                // Recopila los datos del formulario y los almacena en la sesión
                $_SESSION['Titulo'] = $_POST['titulobtn'];
                $_SESSION['Descripcion'] = $_POST['Descripcionbtn'];
                $_SESSION['Duracion'] = $_POST['Duracionbtn'];
                $_SESSION['Aptitudes'] = $_POST['AptitudBtn'];
                $_SESSION['Contrato'] = $_POST['carnetConducir'];
                $_SESSION['Poblacion'] = $_POST['PoblacionSelect'];
                $_SESSION['Empresa'] = $_POST['EmpresaSelect'];
                // Obtiene la opción seleccionada para los estudios desde el formulario
                    $selectedEstudio = $_POST['EstudiosSelect'];
                // Obtiene la información actual de los estudios almacenada en la sesión
                    $estudios = isset($_SESSION['estudios']);
                // Agrega la nueva opción de estudio si está seleccionada
                    if (!empty($selectedEstudio)) {
                        $estudios = $selectedEstudio;
                    }
                // Almacena la información actualizada de los estudios en la sesión
                    $_SESSION['estudios'][]= $estudios;
            }
        //AGREGAR IDIOMA
            if (isset($_POST['agregarIdioma'])) {
                // Asigna valores a las variables de sesión
                    $_SESSION['Titulo'] = $_POST['titulobtn'];
                    $_SESSION['Descripcion'] = $_POST['Descripcionbtn'];
                    $_SESSION['Duracion'] = $_POST['Duracionbtn'];
                    $_SESSION['Aptitudes'] = $_POST['AptitudBtn'];
                    $_SESSION['Contrato'] = $_POST['carnetConducir'];
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
            if(isset($_POST['agregarExperiencia'])){
                $_SESSION['Titulo']=$_POST['titulobtn'];
                $_SESSION['Descripcion']=$_POST['Descripcionbtn'];
                $_SESSION['Duracion']=$_POST['Duracionbtn'];
                $_SESSION['Aptitudes']=$_POST['AptitudBtn'];
                $_SESSION['Contrato']=$_POST['carnetConducir'];
                $_SESSION['Poblacion']=$_POST['PoblacionSelect'];
                $_SESSION['Empresa']=$_POST['EmpresaSelect'];
                // Obtiene la opción seleccionada para los experiencia desde el formulario
                $selectedExperiencia = $_POST['ExperienciaSelect'];
                $TiempoExperiencia = $_POST['Experiencia'];
                // Obtiene la información actual de los experiencia almacenada en la sesión
                    $experiencia = isset($_SESSION['experiencia']);
                // Agrega la nueva opción de estudio si está seleccionada
                    if (!empty($selectedExperiencia)) {
                        $experiencia = $selectedExperiencia;
                    }
                // Almacena la información actualizada de los experiencia en la sesión
                    $_SESSION['experiencia'][]= ['nombre'=>$selectedExperiencia, 'tiempo'=>$TiempoExperiencia];
                  
            }
        //Insertar oferta
            if(isset($_POST['insertoferta'])){
                $_SESSION['Titulo']="";
                $_SESSION['Descripcion']="";
                $_SESSION['Duracion']="";
                $_SESSION['Aptitudes']="";
                $_SESSION['Contrato']="";
                $_SESSION['Poblacion']="";
                $_SESSION['Empresa']="";
                
                insertarofertasadmin($conexion, $_SESSION['estudios'], $_SESSION['idiomas'], $_SESSION['experiencia']);
            }
        ?>
            <!-- Ventana Modal INSERTAR OFERTAS -->
                <div id="myModalOfertas" class="modal" style="display: block;">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
                        <h2>Nueva oferta trabajo</h2>
                        <form id="insertForm" action="pagina-admin" method="POST">
                            <!-- Agrega tus campos del formulario aquí -->
                            <label for="titulolabel">Titulo:</label>
                            <input type="text" id="titulobtn" name="titulobtn" required placeholder="Título" value="<?php echo isset($_SESSION['Titulo']) ? $_SESSION['Titulo'] : ''; ?>">
                                                                
                            <label for="Descripcionlabel">Descripcion:</label>
                            <input type="text" id="Descripcionbtn" name="Descripcionbtn" required placeholder="Descripción" value="<?php echo isset($_SESSION['Descripcion']) ? $_SESSION['Descripcion'] : ''; ?>">

                            <label for="DuracionLabel">Duracion contrato:</label>
                            <input type="number" id="Duracionbtn" name="Duracionbtn" required placeholder="Duración" value="<?php echo isset($_SESSION['Duracion']) ? $_SESSION['Duracion'] : ''; ?>">

                            <label for="AptitudLabel">Aptitudes:</label>
                            <input type="text" id="AptitudBtn" name="AptitudBtn" required placeholder="Aptitudes" value="<?php echo isset($_SESSION['Aptitudes']) ? $_SESSION['Aptitudes'] : ''; ?>">

                            <label for="carnetConducir">¿Tiene carnet de conducir?</label>
                            <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si" <?php echo (isset($_SESSION['Contrato']) && $_SESSION['Contrato'] == 'si') ? 'checked' : ''; ?>>

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
                                        <?php
                                            listarestudios($conexion);
                                        ?>
                                    </select>
                                    
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
                                <button type="submit" name="agregarExperiencia" id="agregarExperiencia">Agregar Experiencia</button>

                            <!-- Botón de Envío -->
                                <button type="submit" name="insertoferta" id="insertoferta">Insertar Datos</button>
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
                        <form id="insertForm" action="pagina-admin" method="POST">
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