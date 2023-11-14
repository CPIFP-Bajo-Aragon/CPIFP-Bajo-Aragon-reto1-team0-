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
            include("../includes/cabecera_registrado.php");
         ?>
    </head>

    <body>
        <?php 
            if(isset($_POST['agregarestudio'])|| isset($_POST['agregarIdioma'])||isset($_POST['agregarExperiencia'])){             

                // Agregar estudios
                    if(isset($_POST['agregarestudio'])){
                        $_SESSION['Titulo']=$_POST['titulobtn'];
                        $_SESSION['Descripcion']=$_POST['Descripcionbtn'];
                        $_SESSION['Duracion']=$_POST['Duracionbtn'];
                        $_SESSION['Aptitudes']=$_POST['AptitudBtn'];
                        $_SESSION['Contrato']=$_POST['carnetConducir'];
                        $_SESSION['Poblacion']=$_POST['PoblacionSelect'];
                        $_SESSION['Empresa']=$_POST['EmpresaSelect'];
                        $selectedEstudio = $_POST['EstudiosSelect'];
                        if (!empty($selectedEstudio)) {
                            $estudios[] = $selectedEstudio;
                            foreach($estudios as $id_estudio){
                                echo($id_estudio);
                            }
                        }
                        if (!empty($idioma)){
                            $_SESSION['idiomas']=$idioma;
                        }
                        if (!empty($experiencia)){
                            $_SESSION['experiencias']= $experiencia;
                        }
                    }

                // Agregar idiomas
                    if(isset($_POST['agregarIdioma'])){
                        $_SESSION['Titulo']=$_POST['titulobtn'];
                        $_SESSION['Descripcion']=$_POST['Descripcionbtn'];
                        $_SESSION['Duracion']=$_POST['Duracionbtn'];
                        $_SESSION['Aptitudes']=$_POST['AptitudBtn'];
                        $_SESSION['Contrato']=$_POST['carnetConducir'];
                        $_SESSION['Poblacion']=$_POST['PoblacionSelect'];
                        $_SESSION['Empresa']=$_POST['EmpresaSelect'];
                        
                        $selectedIdioma = $_POST['IdiomaSelect'];
                        $selectedNivel = $_POST['NivelSelect'];
                        if (!empty($selectedIdioma) && !empty($selectedNivel)) {
                            $idioma[] = array('nombre' => $selectedIdioma, 'nivel' => $selectedNivel);
                        }
                        if (!empty($estudios)){
                        $_SESSION['estudios']=$estudios;
                            
                        }
                        if (!empty($experiencia)){
                            $_SESSION['experiencias']= $experiencia;
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
                        $selectedExperiencia = $_POST['ExperienciaSelect'];
                        if (!empty($selectedExperiencia)) {
                            $experiencia[] = $selectedExperiencia;
                        }
                        if (!empty($idioma)){
                            $_SESSION['idiomas']=$idioma;
                        }
                        if (!empty($estudios)){
                            $_SESSION['estudios']=$estudios;

                        }
                        $_SESSION['experiencias']= $experiencia;
                    }

                    if(isset($_POST['insertoferta'])){
                        $_SESSION['Titulo']="";
                        $_SESSION['Descripcion']="";
                        $_SESSION['Duracion']="";
                        $_SESSION['Aptitudes']="";
                        $_SESSION['Contrato']="";
                        $_SESSION['Poblacion']="";
                        $_SESSION['Empresa']="";
                        $estudios=$_SESSION['estudios'];
                        
                        $experiencia=$_SESSION['experiencias'];
                        
                        $idioma=$_SESSION['idiomas'];
                        insertarofertasadmin($conexion, $estudios, $idioma, $experiencia);
                        
                    }
                    ?>
                    <!-- Ventana Modal INSERTAR OFERTAS -->
                        <div id="myModalOfertas" class="modal" style="display: block;">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
                                <h2>Nueva oferta trabajo</h2>
                                <form id="insertForm" action="PaginaAdmin.php" method="POST">
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
                                            listarProvinciaypoblacion($conexion, "PoblacionSelect");
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

                if(isset($_POST['insertoferta'])){
                        $_SESSION['Titulo']="";
                        $_SESSION['Descripcion']="";
                        $_SESSION['Duracion']="";
                        $_SESSION['Aptitudes']="";
                        $_SESSION['Contrato']="";
                        $_SESSION['Poblacion']="";
                        $_SESSION['Empresa']="";
                        insertarofertasadmin($conexion, $estudios, $idioma, $experiencia);
                }
                        ?>
                        
                        <!-- Ventana Modal INSERTAR OFERTAS -->
                            <div id="myModalOfertas" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
                                <h2>Nueva oferta trabajo</h2>
                                <form id="insertForm" action="PaginaAdmin.php" method="POST">
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
                                            listarProvinciaypoblacion($conexion, "PoblacionSelect");
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
                                        <label for="ExperienciaSelect">Experiencia:</label>
                                        <select name="ExperienciaSelect" id="ExperienciaSelect" >
                                            <?php
                                                listaroficios($conexion);
                                            ?>
                                        </select>
                                        <button type="submit" name="agregarExperiencia" id="agregarExperiencia">Agregar Experiencia</button>

                                    <!-- Botón de Envío -->
                                        <button type="submit" name="insertoferta" id="insertoferta">Insertar Datos</button>
                                </form>
                            </div>
                        </div>
                <?php
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
                    <form id="insertForm" action="PaginaAdmin.php" method="POST">
                        <label for="nombre_usuario">Nombre Usuario:</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="Nombre de usuario">

                        <label for="contraseñalabel">Contraseña:</label>
                        <input type="password" id="contraseña" name="contraseña" required placeholder="Contraseña">

                        <label for="email">Email:</label>
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
                                listarProvinciaypoblacion($conexion, "Selectpoblacion");
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

                        <button type="button" id="insertempresa">Insertar Datos</button>
                    </form>
                </div>
            </div>


       
        <!-- Ventana Modal INSERTAR ALUMNOS -->
            <div id="myModalAlumnos" class="modal">
                <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Nuevo Alumno</h2>
                        <form id="insertForm" action="PaginaAdmin.php" method="POST">
                            <label for="nombre_usuario">Nombre Usuario:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="Nombre de usuario">

                            <label for="contraseñalabel">Contraseña:</label>
                            <input type="password" id="contraseña" name="contraseña" required placeholder="Contraseña">

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="emailbtn" required placeholder="Email">

                            <label for="dni">DNI:</label>
                            <input type="text" id="dni" name="dni" required placeholder="DNI">
                            
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Nombre">

                            <label for="Apellido">Apellidos:</label>
                            <input type="text" id="Apellido" name="Apellido"  placeholder="Apellidos">

                            <?php $fecha_actual = date("d/m/Y");?>

                            <input type="hidden" name="fecha" id="fecha" value="<?php $fecha_actual ?>">

                            <label for="carnetConducirCheckbox">¿Tienes carnet de conducir?</label>
                            <input type="checkbox" id="carnetConducirCheckbox" name="carnetConducir" value="si">

                            <label for="aptitudes">Aptitudes:</label>
                            <input type="text" id="aptitudes" name="aptitudes"  placeholder="Aptitudes">

                            <label for="actitudes">Actitudes:</label>
                            <input type="text" id="actitudes" name="actitudes"  placeholder="Actitudes">
                            
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono"  placeholder="Teléfono">

                            <label for="poblacionlabel">Población:</label>
                            <select name="Selectpoblacion" id="">
                                <?php
                                    listarProvinciaypoblacion($conexion, "Selectpoblacion");
                                ?>
                            </select>
                            <input type="hidden" value="1" name="validado" id="validado">
                            <input type="hidden" value="alumno" name="tipo" id="tipo">

                            <button type="button" id="insertalumno">Insertar Datos</button>
                        </form>
                </div>
            </div>

        <div id="botones">
            <div id="empresa">
                <button id="button" class="custom-button">
                    <a href="../tablas_admin/listarempresas.php">
                    <i id="imgIconos" class="fa-solid fa-list fa-2xl"></i><p class="parrafoIconos">LISTAR</p><p class="parrafoIconos">EMPRESAS</p>
                </button>   
            </div>

            <div  id="ofertas">
                <button id="button" class="custom-button">
                    <a href="../tablas_admin/listarofertas.php">
                    <i id="imgIconos" class="fa-solid fa-bag-shopping fa-2xl"></i><p class="parrafoIconos">OFERTAS</p>
                </button>   
            </div>
            <div id="Usuarios">
                <button id="button" class="custom-button">
                    <a href="../tablas_admin/listarusuarios.php">
                    <i id="imgIconos" class="fa-solid fa-users fa-2xl"></i><p class="parrafoIconos">ALUMNOS</p>
                </button>  
            </div>
        </div>

        <footer>
            <?php include "../includes/footer.php" ?>
        </footer>
    </body>
</html>
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
