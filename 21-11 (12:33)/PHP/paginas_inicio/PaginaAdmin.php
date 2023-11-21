
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
         <?php 
            include "../includes/isset/paginas_inicio/PaginaAdmin.php";
        ?>    
    </head>

    <body>
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
                <form id="insertForm" action="pagina-admin" method="POST">
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
                    <form id="insertForm" action="pagina-admin" method="POST">
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

                        <label for="Apellido">Apellidos:</label>
                        <input type="text" id="Apellido" name="Apellido"  placeholder="Apellidos">

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
            <div id="empresa">
                <a href="empresas-admin">
                    <button id="button" class="custom-button">
                        <i id="imgIconos" class="fa-solid fa-list fa-2xl"></i><p class="parrafoIconos">GESTIÓN</p><p class="parrafoIconos">EMPRESAS</p>
                    </button>
                </a>
            </div>
            <div  id="ofertas">
                <a  href="ofertas-admin">
                    <button id="button" class="custom-button">
                        <i id="imgIconos" class="fa-solid fa-bag-shopping fa-2xl"></i><p class="parrafoIconos">GESTIÓN</p><p class="parrafoIconos">OFERTAS</p>
                    </button>
                </a>
            </div>
            <div id="Usuarios">
                <a href="usuarios-admin">
                    <button id="button" class="custom-button" >
                        <i id="imgIconos" class="fa-solid fa-users fa-2xl"></i><p class="parrafoIconos">GESTIÓN</p><p class="parrafoIconos">ALUMNOS</p>
                    </button>
                </a>
            </div>
            <div id="chat">
                <a href="chat">
                    <button id="button" class="openChatBtn" class="custom-button" >
                        <i id="imgIconos" class="fa-solid fa-users fa-2xl"></i><p class="parrafoIconos">chat</p><p class="parrafoIconos"></p>
                    </button>
                </a>
            </div>
        </div>

        <?php include "../includes/footer.php" ?>
         <!-- Ventana modal -->


    </body>
</html>



<!-- Función para abrir la ventana modal -->

<script src="../../JS/paginas_inicio/PaginaAdmin.js"></script>



