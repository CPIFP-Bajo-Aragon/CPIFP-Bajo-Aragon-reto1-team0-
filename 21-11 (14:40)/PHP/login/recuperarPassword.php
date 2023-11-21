<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Recuperar Contraseña</title>

</head>
<?php 
include "../includes/cabecera.php";
include "../includes/conexion.php";
?>
<script src="../../JS/validaciones/login/recuperarPassword.js"></script>
<body>
<?php

?>
    <ul class="breadcrumb">
        <li><a href="inicio-sesion">Iniciar Sesión</a></li>
        <li>Recuperar Contraseña</li>
    </ul> 
    

    <div class="recuperarPassword">
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
        </div>

        <h2>Recuperar Contraseña</h2>

        <form action="" method="POST" onsubmit="return validarRecuperarContraseña(event)">
            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="usuario" id="usuario">

            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" id="correo">
            <br>
            <label for="NewPasword">Nueva Contraseña</label>
            <input type="password" name="NewPasword" id="NewPasword">
            <br>
            <label for="OtraVezNP">Confirma la nueva contraseña</label>
            <input type="password" name="OtraVezNP" id="OtraVezNP">
            <br>
            <input type="submit" name="cambiarPassword" value="Cambiar Contraseña">
        </form>
    </div>

</body>
<?php include "../includes/footer.php"?>

</html>

<?php
      include("../includes/isset/login/recuperarPassword.php");
        
?>