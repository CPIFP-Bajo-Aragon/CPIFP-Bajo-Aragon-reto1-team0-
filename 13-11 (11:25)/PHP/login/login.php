<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/login.css">
    <title>Inicio de Sesión</title>

</head>
<body>
<?php 


include "../includes/cabecera.php" ?>
    <main>
        <div class="login-container">
            <div class="logo">
                <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
            </div>
            <div class="inicio_sesion" >
                <h2>Iniciar Sesión</h2>
                <form action="verificarLogin.php" method="POST">
                    
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                    <br>
            
                    <input type="password" name="clave" id="password" placeholder="password">
                    <br>
                    <input type="submit" name="Acceder" value="Acceder">
                </form>
                
            </div>
            <div class="crear_cuenta">
                <a href="../registrar/crearusuario.php"><h5>¿No tienes cuenta? Regístrate</h5></a>
                <a href="recuperarPassword.php"><h5>¿Has olvidado tu contraseña? Recupérala</h5></a>
            </div>
        </div>
        <?php

    ?>
    </main>

<?php include "../includes/footer.php" ?>

</body>
</html>
