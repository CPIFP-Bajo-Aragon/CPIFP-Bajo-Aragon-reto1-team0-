<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-2zjzftqJpq2bFA0O4d0oPy/byYo8qz60YU5T1OnF5txU5n6Z7soMKs5d5oJbcFU3Y" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/index.css">
</head>

<body>
    <header>
        <div class="logoEmpresa">
            <a id="linkLogo" href="../../index.php"><h1><span class="naranja">BA</span>EMPLEA</h1></a>
        </div>
        <?php
            session_start();
            // echo "<p>HAS ACCEDIDO COMO: " . $_SESSION['tipoUsuario'] . "</p>";
            // echo "<img src='../../img/usuario.png' alt='' width='30' height='30'>" . $_SESSION['nombre_usuario'];
        ?>
        <!-- <?php $_SESSION['nombre_usuario']; ?> -->

        <div class="iconosSesion">
            <i id="logoUser" class="fa fa-circle-user fa-2xl"></i>

            <form action='../login/destruir_sesion.php'>
                <input type="submit" name="sesionDestroy" value="Cerrar"/>
            </form>
        
        </div>
    </header>
</body>
</html>