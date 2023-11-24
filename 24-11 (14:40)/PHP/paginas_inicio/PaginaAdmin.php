
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../CSS/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Enlace a FontAwesome versión 5.15.3 con integridad y crossorigin -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-2zjzftqJpq2bFA0O4d0oPy/byYo8qz60YU5T1OnF5txU5n6Z7soMKs5d5oJbcFU3Y" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="../../JS/validaciones/pagina_inicio/paginaAdmin.js"></script>
        <title>Menu Admin</title>
        <?php
            include("../includes/conexion.php");
            include("../includes/funciones.php");
         ?>
        <style>

/* @media (max-width: 700px) {
    body {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 7fr 4fr;
        height: 100vh;
    }
    .botonesAbrirModal{
        
        display: flex;
        flex-direction: column;
    }
    #botones{
        
        display: flex;
        flex-direction: column;
        


    }

    .parrafoIconoss{
        margin-top: 100%;

    }
    #empresa{
        flex: 1;
    }
    #ofertas{
        flex: 1;
    }
    #Usuarios{
        flex: 1;
    }
    #chat{
        flex: 1;
    }
    #button{
        width: 15px;
        height: 15px;
    }

    #botones button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    #botones button p{
      
        font-size: 1em;
    }

    #botones i {
        font-size: 2rem;  
        margin-bottom: 0.5rem; 
    }
    footer {
        position: fixed;
        width: 100vw;
        height: 10vh;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto auto auto;
        background-color: rgba(26, 154, 182, 0.3);
        color: #fff;
    }
} */
@media (max-width: 700px) {
            body {
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: 1fr 7fr 4fr;
                height: 100vh;
                
            }

            #botones {
                display: flex;
                flex-direction: column;
                margin-top: 10%;
            }
            

            #empresa, #ofertas, #Usuarios {
                flex: 1;
            }

            #button {
                width: 10px;
                height: 10px;
            }

            #botones button {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            #botones button p {
                font-size: 1em; 
            }

            #botones i {
                font-size: 2rem; /* Ajusta el tamaño del icono según tus necesidades */
                margin-bottom: 0.5rem; /* Ajusta el margen inferior según tus necesidades */
            }

            footer {
                height: 10vh;
                width: 100vw;
                display: grid;
                grid-template-rows: 1fr 1fr 1fr;
                grid-template-columns: 1fr;
                background-color: rgba(26, 154, 182, 0.3);
                color: #fff;
                position: fixed;
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
        <div>
            <?php
                if ($_SESSION['tipoUsuario']!="administrador") {
                    // No ha iniciado sesión, redirige a la página de inicio de sesión
                    // header("Location: inicio");
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
                            $_SESSION['estudios'] = [];
                            $_SESSION['idiomas']=[];
                            $_SESSION['experiencia'] = [];
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
                                        <input type="checkbox" id="carnetConducir" name="carnetConducir" value="si" <?php echo (isset($_SESSION['Contrato']) && $_SESSION['Contrato'] == 'si') ? 'checked' : ''; ?>>

                                        <label for="PoblacionLabel">Poblacion:</label>
                                        <select name="PoblacionSelect" id="PoblacionSelect">
                                            
                                            <?php
                                                if(isset($_SESSION['Poblacion']) && is_array($_SESSION['Poblacion'])){
                                                    $id_poblacion=$_SESSION['Poblacion'];
                                                    $nombrepoblacion=mostrarPoblacion($conexion, $id_poblacion);
                                                    echo ("<option value='$id_poblacion'>$nombrepoblacion</option>");
                                                }
                                                listarProvinciaypoblacion($conexion);
                                            ?>
                                        </select>

                                        <label for="EmpresaLabel">Empresa:</label>
                                        <select name="EmpresaSelect" id="EmpresaSelect">
                                            <?php
                                                if(isset($_SESSION['Empresa']) && is_array($_SESSION['Empresa'])){
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
                                                                $nombreestudio=mostrarestudios($conexion, $estudio);
                                                                echo "Título: " . $nombreestudio . "<br>";
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
                                                                $idnivel=$idiomas['idioma'];
                                                                $ididioma=$idiomas['nombre'];
                                                                $idioma=mostraridioma($conexion, $ididioma);
                                                                $nivel=mostrarnivel($conexion, $idnivel);
                                                                echo "Título: " . $idioma ." Nivel: ". $nivel . "<br>";
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
                                                        $nombre=$experiencia['nombre'];
                                                        $tiempo=$experiencia['tiempo'];
                                                        $nombre=mostrarexperiencia($conexion, $nombre);
                                                        echo "Trabajo de : " . $nombre ." por: ". $tiempo . "meses <br>";
                                                    }
                                                }
                                            ?>
                                            </div>
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
                        $_SESSION['experiencia'] = [];
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
                                        <input type="number" id="Duracionbtn" name="Duracionbtn" placeholder="Duración">

                                        <label for="AptitudLabel">Aptitudes:</label>
                                        <input type="text" id="AptitudBtn" name="AptitudBtn" placeholder="Aptitudes">

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



            <!-- Botones para abrir las modales -->
                <div class="botonesAbrirModal">
                    <button id="openModalBtn">INSERTAR EMPRESAS</button>

                    <button id="openModal">INSERTAR OFERTAS</button>

                    <button id="openBtn">INSERTAR ALUMNOS</button>
                </div>

            
            
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
                        <select name="Selectpoblacion" id="Selectpoblacion">
                            <?php
                                listarProvinciaypoblacion($conexion);
                            ?>
                        </select>

                        <label for="sectorlabel">Sector:</label>
                        <select name="sectorselect" id="sectorselect">
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
                            <input type="text" id="email_alumno" name="emailbtn" required placeholder="Email">

                            <label for="dni">DNI:</label>
                            <input type="text" id="dni" name="dni" required placeholder="DNI">
                
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre_alumno" name="nombre" required placeholder="Nombre">

                            <label for="Apellido">Apellidos:</label>
                            <input type="text" id="Apellido_alumno" name="Apellido" required placeholder="Apellidos">

                            <label for="NAC">Fecha Nacimiento:</label>
                            <input type="date" id="Fecha_nacimiento" name="Fecha_nacimiento" required placeholder="Fecha_nacimiento">

                            <label for="carnetConducirCheckbox">¿Tienes carnet de conducir?</label>
                            <input type="checkbox" id="carnetConducirCheckbox" name="carnetConducir" value="si">

                            <label for="aptitudes">Aptitudes:</label>
                            <input type="text" id="aptitudes" name="aptitudes"  placeholder="Aptitudes">

                            <label for="actitudes">Actitudes:</label>
                            <input type="text" id="actitudes" name="actitudes"  placeholder="Actitudes">
                                    
                            <label for="telefon1o">Teléfono:</label>
                            <input type="text" id="telefono_alumno" name="telefono"  placeholder="Teléfono">

                            <label for="poblacionlabel">Población:</label>
                            <select name="Selectpoblacion" id="">
                                <?php
                                    listarProvinciaypoblacion($conexion);
                                ?>
                            </select>
                            <input type="hidden" value="1" name="validado" id="validado">
                            <input type="hidden" value="alumno" name="tipo" id="tipo">

                            <button type="submit" name="insertalumno" id="insertalumno">Insertar Datos</button>
                        </form>
                    </div>
                </div>

            <div id="botones">
                <div id="empresa">
                    <a href="empresas-admin">
                        <button id="button" class="custom-button">
                            <i id="imgIconos" class="fa-solid fa-list fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafooIconos">EMPRESAS</p>
                        </button>
                    </a>
                </div>
                <div  id="ofertas">
                    <a  href="ofertas-admin">
                        <button id="button" class="custom-button">
                            <i id="imgIconos" class="fa-solid fa-bag-shopping fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafooIconos">OFERTAS</p>
                        </button>
                    </a>
                </div>
                <div id="Usuarios">
                    <a href="usuarios-admin">
                        <button id="button" class="custom-button" >
                            <i id="imgIconos" class="fa-solid fa-users fa-2xl"></i><p class="parrafooIconos">GESTIÓN</p><p class="parrafooIconos">ALUMNOS</p>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        <?php
            include "../includes/footer.php"
        ?>


    </body>
    
</html>


<!-- Función para abrir la ventana modal -->




