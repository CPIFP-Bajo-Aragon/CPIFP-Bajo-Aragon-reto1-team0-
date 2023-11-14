<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Recuperar Contraseña</title>

</head>
<?php include "../includes/cabecera.php"?>

<body>

    <ul class="breadcrumb">
        <li><a href="login.php">Iniciar Sesión</a></li>
        <li>Recuperar Contraseña</li>
    </ul> 
    

    <div class="recuperarPassword">
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo de la empresa" width="150px">
        </div>

        <h2>Recuperar Contraseña</h2>

        <form action="" method="POST">
            <label for="correo">Correo electrónico</label>
            <input type="text" name="correo" id="correo">
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($_POST['correo'])) {
                $errors[] = "El correo electrónico es obligatorio para poder recuperar la contraseña";
            } elseif (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El correo electrónico es inválido";
            }

            if (empty($_POST['password'])) {
                $errors[] = "La contraseña es obligatoria";
            }
        }
    ?>