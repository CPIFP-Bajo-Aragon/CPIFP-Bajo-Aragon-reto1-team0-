<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Configuración del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include("../includes/links.php")
    ?>
    <!-- Enlace a la hoja de estilo local -->
    <link rel="stylesheet" href="../../CSS/index.css">
    <style>

    </style>
    <!-- Título de la página -->
    <title>Recuperar Contraseña</title>
</head>

<!-- Inclusión del encabezado y conexión a la base de datos -->
    <?php 
        include "../includes/conexion.php";
    ?>

<!-- Inclusión del script de validación de recuperación de contraseña -->
<script src="../../JS/validaciones/login/recuperarPassword.js"></script>

<body>
    <?php
        include "../includes/cabecera.php";
    ?>
    <main id="mainrecuperarcontra">
        <div>
            <!-- ISSET: Comprobación de si el formulario ha sido enviado -->
            <?php
                if (isset($_POST['cambiarPassword'])) {
                    // Obtener valores del formulario
                    $email = $_POST['correo'];
                    $usuario = $_POST['usuario']; 
                    $contra = $_POST['NewPasword'];
                    $contra2 = $_POST['OtraVezNP'];
                    
                    // Consulta para verificar la existencia del usuario y correo
                    $sqlCheckUser = "SELECT * FROM `usuario` WHERE correo=:email AND nombre_usuario=:usuario";
                    $consultaCheckUser = $conexion->prepare($sqlCheckUser);
                    $consultaCheckUser->bindParam(':email', $email);
                    $consultaCheckUser->bindParam(':usuario', $usuario);
                    $consultaCheckUser->execute();
                    
                    // Verificar si el usuario y correo existen en la base de datos
                    if ($consultaCheckUser->rowCount() > 0) {
                        // Verificar si las contraseñas coinciden
                        if ($contra === $contra2) {
                            // Hash de la nueva contraseña
                            $hashed_password = password_hash($contra, PASSWORD_DEFAULT);
                            
                            // Actualizar la contraseña en la base de datos
                            $sql = "UPDATE `usuario` SET `password`=:contra WHERE correo=:email";
                            $consulta = $conexion->prepare($sql);
                            $consulta->bindParam(':contra', $hashed_password);
                            $consulta->bindParam(':email', $email);
                            
                            // Ejecutar la consulta y verificar si se realizó con éxito
                            if ($consulta->execute()) {
                                echo "Contraseña cambiada exitosamente.";
                            } else {
                                echo "Error al cambiar la contraseña.";
                            }
                        } else {
                            echo "Las contraseñas no coinciden.";
                        }
                    } else {
                        echo "Nombre de usuario y/o correo electrónico no encontrados.";
                    }
                }
            ?>

            <!-- Breadcrumb: Muestra la ruta de navegación -->
            <ul class="breadcrumb">
                <li><a href="inicio-sesion">Iniciar Sesión</a></li>
                <li>Recuperar Contraseña</li>
            </ul> 

            <!-- Contenedor para recuperar la contraseña -->
            <div class="recuperarPassword">
                <!-- Logo de la empresa -->
                <div class="logo">
                    <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
                </div>

                <!-- Título de la sección -->
                <h2 id="h2RecuperarPassword">Recuperar Contraseña</h2>

                <!-- Formulario para recuperar la contraseña -->
                <form action="" id="formulariorecuperar" method="POST" onsubmit="return validarRecuperarContraseña(event)">
                    <div>
                        <label class="labelRecuperarPassword" for="usuario">Nombre de usuario:</label>
                        <input class="inputRecuperarPassword" type="text" name="usuario" id="usuario">
                    </div>
                    <div>
                        <label class="labelRecuperarPassword" for="correo">Correo electrónico:</label>
                        <input class="inputRecuperarPassword" type="email" name="correo" id="correo">
                    </div>
                    <div>
                        <label class="labelRecuperarPassword" for="NewPasword">Nueva Contraseña:</label>
                        <input class="inputRecuperarPassword" type="password" name="NewPasword" id="NewPasword">
                    </div>
                    <div>
                    <label class="labelRecuperarPassword" for="OtraVezNP">Confirma la nueva contraseña:</label>
                        <input class="inputRecuperarPassword"type="password" name="OtraVezNP" id="OtraVezNP">
                    </div>
                    <input class="cambiarPassword" type="submit" name="cambiarPassword" value="Cambiar Contraseña">
                </form>
            </div>
        </div>
    </main>
<!-- Inclusión del pie de página -->
<?php include "../includes/footer.php"?>
</body>

</html>
