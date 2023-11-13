<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">

    <title>Menu Empresa</title>
</head>
<?php include("../includes/cabecera_registrado.php"); ?>

<body>  
    <main>
        <div id="botoness">
            <div id="buscar">
                <button id="buttonn" class="custom-button">
                    <a href="../tablasempresa/buscaralumno.php">
                    <i id="imggIconos" class="fa fa-magnifying-glass"></i><p class="parrafooIconos">BUSCAR</p><p class="parrafooIconos">ALUMNOS</p>
                </button>   
            </div>

            <div  id="publicar">
                <button id="buttonn" class="custom-button">
                    <a href="../tablasempresa/publicaroferta.php">
                    <i id="imggIconos" class="fa fa-pen-to-square"></i><p class="parrafooIconos">PUBLICAR </p><p class="parrafooIconos">OFERTAS</p>
                </button>   
            </div>

            <div id="resumen">
                <button id="buttonn" class="custom-button">
                    <a href="../tablasempresa/resumen.php">
                    <i id="imggIconos" class="fa-regular fa-rectangle-list"></i><p class="parrafooIconos">RESUMEN</p>
                </button>  
                <button>
                    <a href="../tablasempresa/perfilEmpresa.php">
                        Perfil
                </button>  
            </div>
        </div>
    </main>
    
    <?php include "../includes/footer.php" ?>
</body>
</html>