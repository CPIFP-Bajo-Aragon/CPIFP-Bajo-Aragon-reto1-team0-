<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Formulario de Registro de Usuario</title>
</head>
<?php
    include("../includes/conexion.php");
    include("../includes/funciones.php");
    include("../includes/cabecera.php" );
?>
<body>
    <ul class="breadcrumb">
        <li><a href="../login/login.php">Iniciar Sesión</a></li>
        <li>Crear Nuevo Usuario</li>
    </ul> 

    <!-- <div class="crearUsuarioDIV"> 
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
        </div>
        <h2>Registro de Usuario</h2>
        <form action="procesarregistro.php" method="POST"  class="form-container">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" maxlength="50" required placeholder="Nombre Usuario">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" maxlength="50" required placeholder="Contraseña">

                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" maxlength="100" required placeholder="Correo electrónico">

                <label for="">¿Quién eres?</label>
                <input type="radio" name="usu" id="empresa" value="empresa">Empresa
                <input type="radio" name="usu" id="alumno" value="alumno">Alumno
            <br>
            <br>
            <div id="campos_empresa" class="hidden">
                <label for="nombre_empresa">Nombre de la Empresa:</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa" placeholder="Nombre empresa">
                <label for="cif">CIF:</label>
                <input type="text" id="cif" name="cif" placeholder="CIF">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" placeholder="Dirección">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" cols="0" placeholder="Descripción Empresa"></textarea>
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Teléfono">
                <label for="sector">Sector:</label>
                    <select name="sector_empresa" id="sector_empresa">
                        <?php listarsectores($conexion) ?>
                    </select>
                <label for="poblacion">Poblacion:</label>
                <select name="provincia_empresa" id="provincia_empresa">
                    <?php listarProvinciaypoblacion($conexion); ?>
                </select>
                <input type="submit" value="Registrar" id="Registrar_empresa">
            </div>

            <div id="campos_alumno" class="hidden">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="50" placeholder="Nombre Alumno">
                <label for="Apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" maxlength="50" placeholder="Apellidos">
                <label for="dni">DNI:</label>
                <input type="text" id="DNI" name="DNI" maxlength="9" placeholder="DNI">
                <label for="fecha_nac">Fecha nacimiento:</label>
                <input type="date" id="fecha_naci" name="fecha_naci" maxlength="50" placeholder="Fecha Nacimiento">
                <label for="Telefono">Telefono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="9" placeholder="Teléfono">
                <label for="carnet">Carnet:</label>
                <input type="checkbox" id="carnet" name="carnet">
                <label for="actitud">Actitudes:</label>
                <input type="text" id="actitud" name="actitud" maxlength="50">
                <label for="aptitud">Aptitudes:</label>
                <input type="text" id="aptitud" name="aptitud" maxlength="50">
                <label for="poblacion">Poblacion:</label>
                    <select name="provincia" id="">
                        <?php listarProvinciaypoblacion($conexion); ?>
                    </select>
                <input type="submit" value="Registrar" id="Registrar_empesa">
            </div>
        </form>
    </div>
        <br>  -->
 


<!--
        <form action="procesarregistro.php" method="POST" class="form-container">
    <div class="column">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" maxlength="50" required placeholder="Nombre Usuario">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" maxlength="50" required placeholder="Contraseña">

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" maxlength="100" required placeholder="Correo electrónico">

        <label for="">¿Quién eres?</label>
        <input type="radio" name="usu" id="empresa" value="empresa" onchange="mostrarCampos('empresa')">Empresa
        <input type="radio" name="usu" id="alumno" value="alumno" onchange="mostrarCampos('alumno')">Alumno
    </div>

    <div class="column" id="campos_empresa" style="display: none;">
         Primera columna de campos de empresa (hasta Teléfono) 
        <label for="nombre_empresa">Nombre de la Empresa:</label>
        <input type="text" id="nombre_empresa" name="nombre_empresa" placeholder="Nombre empresa">
        
        <label for="cif">CIF:</label>
        <input type="text" id="cif" name="cif" placeholder="CIF">
        
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" placeholder="Dirección">
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" cols="0" placeholder="Descripción Empresa"></textarea>
        
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Teléfono">
    

    <div class="column" id="campos_empresa2" style="display: none;">
        Segunda columna de campos de empresa (después de Teléfono) 
        <label for="sector">Sector:</label>
        <select name="sector_empresa" id="sector_empresa">
            <?php listarsectores($conexion) ?>
        </select>
        
        <label for="poblacion">Poblacion:</label>
        <select name="provincia_empresa" id="provincia_empresa">
            <?php listarProvinciaypoblacion($conexion); ?>
        </select>
        <input type="submit" value="Registrar" id="Registrar_empresa">
    </div>

</div>

    <div class="column" id="campos_alumno" style="display: none;">
        <! Campos de alumno 
        
        <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="50" placeholder="Nombre Alumno">
                <label for="Apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" maxlength="50" placeholder="Apellidos">
                <label for="dni">DNI:</label>
                <input type="text" id="DNI" name="DNI" maxlength="9" placeholder="DNI">
                <label for="fecha_nac">Fecha nacimiento:</label>
                <input type="date" id="fecha_naci" name="fecha_naci" maxlength="50" placeholder="Fecha Nacimiento">
                <label for="Telefono">Telefono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="9" placeholder="Teléfono">
</div>
<div class="column" id="campos_alumno2" style="display: none;">

                <label for="carnet">Carnet:</label>
                <input type="checkbox" id="carnet" name="carnet">
                <label for="actitud">Actitudes:</label>
                <input type="text" id="actitud" name="actitud" maxlength="50">
                <label for="aptitud">Aptitudes:</label>
                <input type="text" id="aptitud" name="aptitud" maxlength="50">
                <label for="poblacion">Poblacion:</label>
                    <select name="provincia" id="">
                        <?php listarProvinciaypoblacion($conexion); ?>
                    </select>
                <input type="submit" value="Registrar" id="Registrar_empesa">
    </div>
</div>
</form> -->





































<!-- 


        <script>
    function mostrarCampos(tipo) {
        var camposEmpresa = document.getElementById('campos_empresa');
        var camposAlumno = document.getElementById('campos_alumno');

        if (tipo === 'empresa') {
            camposEmpresa.style.display = 'block';
            camposAlumno.style.display = 'none';
        } else if (tipo === 'alumno') {
            camposEmpresa.style.display = 'none';
            camposAlumno.style.display = 'block';
        }
    }
</script>

 


    <script>
         // JavaScript code for showing/hiding registration fields based on radio button selection
         const radioEmpresa = document.getElementById("empresa");
        const radioAlumno = document.getElementById("alumno");
        const camposEmpresa = document.getElementById("campos_empresa");
        const camposAlumno = document.getElementById("campos_alumno");

        radioEmpresa.addEventListener("change", function () {
            if (radioEmpresa.checked) {
                camposEmpresa.classList.remove("hidden");
                camposAlumno.classList.add("hidden");
            }
        });

        radioAlumno.addEventListener("change", function () {
            if (radioAlumno.checked) {
                camposAlumno.classList.remove("hidden");
                camposEmpresa.classList.add("hidden");
            }
        });

    </script> -->

<?php include "../includes/footer.php" ?>

</body>

</html>