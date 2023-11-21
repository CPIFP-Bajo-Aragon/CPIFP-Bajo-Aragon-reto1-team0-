
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Alumno</title>
    <link rel="stylesheet" href="../../CSS/index.css">
</head>
    <?php 
        include("../includes/cabecera_registrado.php"); 
        include "../includes/isset/paginas_inicio/PaginaAlumno.php";
    ?>
<!-- php include ("../includes/cabecera_alumno.php"); ?>    -->
<body>
    <main>
        <div id="botoness">
            <div id="ofertas">
                <a href="ofertas-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-magnifying-glass"></i><p class="parrafooIconos">BUSCAR</p><p class="parrafooIconos">OFERTAS</p>
                    </button>  
                </a> 
            </div>

            <div  id="resumen">
                <a href="resumen-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-pen-to-square"></i><p class="parrafooIconos">RESUMEN</p>
                    </button>   
                </a>
            </div>

            <div id="curriculum">
                <a href="curriculum-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa-solid fa-file-pdf"></i><p class="parrafooIconos">CURRICULUM</p>
                    </button>  
                </a>
            </div>
        </div>
    </main>
</body>
<?php include "../includes/footer.php" ?>
</html>
<script src="../../JS/paginas_inicio/PaginaAlumno.js"></script>