<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-2zjzftqJpq2bFA0O4d0oPy/byYo8qz60YU5T1OnF5txU5n6Z7soMKs5d5oJbcFU3Y" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/cabecera.css">
    <style>

           
			
			
			ul, ol {
				list-style:none;
			}
			
			
			.nav li a {
				background-color:#000;
				color:#fff;
				text-decoration:none;
				padding:10px 12px;
				display:block;
			}
			
			.nav li a:hover {
				background-color:#434343;
			}
			
			.nav li ul {
				display:none;
				position:absolute;
				min-width:140px;
			}
			
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			
    </style>
</head>

<body>
<header>
    
    <a id="linkLogo" href="../../index.php"><h1><span class="naranja">BA</span>EMPLEA</h1></a>
    
    <?php
       include("../login/verificarLogin.php");
        echo "<p>HAS ACCEDIDO COMO: " . $_SESSION['tipoUsuario'] . "</p>";
        echo "<p>id: " . $_SESSION['id_usuario'] . "</p>";
        echo "<img src='../../img/usuario.png' alt='' width='30' height='30'>" . $_SESSION['nombre_usuario'];
    ?>
    <?php $_SESSION['nombre_usuario']; ?>
    <nav class="nav">
    <li><i id="logoUser" class="fa fa-circle-user fa-2xl"></i>
        <ul>
        <li><a href="../tablas_alumno/datospersonales.php">DATOS PERSONALES</a></li>
        <li><a href="">DATOS ACADEMICOS</a></li>
        <li><a href="">PERFIL</a></li>
        </ul>
   
    </li>

    </nav>
    
    <a href="../../index.php">
        <a href="../../index.php"><i class="fa fa-right-from-bracket fa-2xl" style="color: #ffffff;"></i></a>
    </a>
    </header>
</body>
</html>