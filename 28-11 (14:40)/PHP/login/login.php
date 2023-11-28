<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
include("../includes/links.php");
?>
    <!-- Enlace a la hoja de estilo local -->
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Inicio de Sesión</title>

    <!-- Inclusión del script de verificación de inicio de sesión -->
    <script src="../../JS/validaciones/login/verificarlogin.js"></script>
</head>

<?php include("verificarLogin.php"); ?>
<?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje']; 
    unset($_SESSION['mensaje']); 
}
?>

<body>
    
    <!-- Inclusión del encabezado -->
    <?php include("../includes/cabecera.php"); ?>

    <!-- ISSET: Comprobación de si una variable está definida -->
    <?php
    ?>

    <!-- MAIN: Contenido principal de la página -->
    <main id="mainlogin">
        <!-- Contenedor del formulario de inicio de sesión -->
        <div class="login-container">
            <!-- Logo de la empresa -->
            <div class="logo">
                <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
            </div>
            
            <!-- Sección de inicio de sesión -->
            <div class="inicio_sesion">
                <h2>Iniciar Sesión</h2>

                <!-- Formulario de inicio de sesión -->
                <form action="verificar" method="POST" onsubmit="return validarLogin()">
                    <!-- Campo de usuario -->
                    <input type="text" class="inputlogin" name="usuario" id="usuario" placeholder="Usuario" require>
                    <br>
            
                    <!-- Campo de contraseña -->
                    <input type="password" class="inputlogin" name="clave" id="password" placeholder="contraseña" require>
                    <br>

                    <!-- Botón de enviar el formulario -->
                    <input type="submit" class="accederlogin" name="Acceder" value="Acceder">
                </form>
                
                <!-- Mensaje de error -->
                <?php if (!empty($mensaje)): ?>
                 <p class="bad"><?php echo $mensaje; ?></p>
                <?php endif; ?>
            </div>

            <!-- Enlaces para crear cuenta y recuperar contraseña -->
            <div class="crear_cuenta">
                <a href="registrar"><h5>¿No tienes cuenta? Regístrate</h5></a>
                <a href="recuperacion"><h5>¿Has olvidado tu contraseña? Recupérala</h5></a>
            </div>
        </div>
    </main>
    <!-- Inclusión del pie de página -->
<?php include "../includes/footer.php" ?>
</body>

</html>


