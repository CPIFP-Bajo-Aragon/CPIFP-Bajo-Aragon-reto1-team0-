<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">

    <title>Menu Empresa</title>
</head>
<?php
include("../includes/funciones.php");
include("../includes/cabecera_registrado.php");
 if ($_SESSION['tipoUsuario']!="empresa") {
    // No ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: inicio");
    exit();
}

?>

<body>  
    <main>
        <div id="botoness">
            <div id="buscar">
                <a href="buscar-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-magnifying-glass"></i><p class="parrafooIconos">BUSCAR</p><p class="parrafooIconos">ALUMNOS</p>
                    </button>  
                </a> 
            </div>

            <div  id="publicar">
                <a href="publicar-oferta">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-pen-to-square"></i><p class="parrafooIconos">PUBLICAR </p><p class="parrafooIconos">OFERTAS</p>
                    </button>   
                </a>
            </div>

            <div id="resumen">
                <a href="resumen-empresa">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa-regular fa-rectangle-list"></i><p class="parrafooIconos">RESUMEN</p>
                    </button>  
                </a>
                 <!-- <button>
                    <a href="perfil-empresa">
                        Perfil</a>
                </button>  -->
            </div>
        </div>
    </main>
    
    <?php include "../includes/footer.php" ?>
</body>
</html>