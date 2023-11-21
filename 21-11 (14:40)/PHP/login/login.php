<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Inicio de Sesión</title>
    <script src="../../JS/validaciones/login/verificarlogin.js"></script>
</head>
<?php include("../includes/cabecera.php"); ?>
<body>
    <main>
        <div class="login-container">
            <div class="logo">
                <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
            </div>
            <div class="inicio_sesion" >
                <h2>Iniciar Sesión</h2>
                <form action="verificar" method="POST" onsubmit="return validarLogin()">
                    
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" require>
                    <br>
            
                    <input type="password" name="clave" id="password" placeholder="password" require>
                    <br>
                    <input type="submit" name="Acceder" value="Acceder">
                </form>
                <!-- <?php echo "<p class= 'bad'> $mensaje; </p>"?> -->
            </div>
            <div class="crear_cuenta">
                <a href="registrar"><h5>¿No tienes cuenta? Regístrate</h5></a>
                <a href="recuperacion"><h5>¿Has olvidado tu contraseña? Recupérala</h5></a>
            </div>
        </div>
    </main>
</body>

</html>

<?php include "../includes/footer.php" ?>

