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
                <a href="../tablas_admin/listarusuarios.php">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-magnifying-glass"></i><p class="parrafooIconos">BUSCAR</p><p class="parrafooIconos">ALUMNOS</p>
                    </button>  
                </a> 
            </div>

            <div  id="publicar">
                <a href="../tablasempresa/publicaroferta.php">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-pen-to-square"></i><p class="parrafooIconos">PUBLICAR </p><p class="parrafooIconos">OFERTAS</p>
                    </button>   
                </a>
            </div>

            <div id="resumen">
                <a href="../tablasempresa/resumen.php">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa-regular fa-rectangle-list"></i><p class="parrafooIconos">RESUMEN</p>
                    </button>  
                </a>
                <!-- <button>
                    <a href="../tablasempresa/perfilEmpresa.php">
                        Perfil</a>
                </button>   -->
            </div>
        </div>
    </main>
    
    <?php include "../includes/footer.php" ?>
</body>
</html>