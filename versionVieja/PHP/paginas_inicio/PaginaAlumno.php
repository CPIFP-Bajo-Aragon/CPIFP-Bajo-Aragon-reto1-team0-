
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Alumno</title>
</head>
<body>
<?php include "../includes/cabecera_alumno.php" ?> 
    <main>
        <div id="botoness">
            <div id="ofertas">
                <button id="buttonn" class="custom-button">
                <a href="../tablas_alumno/listarofertas.php">
                    <i id="imggIconos" class="fa fa-magnifying-glass"></i><p class="parrafooIconos">BUSCAR</p><p class="parrafooIconos">OFERTAS</p>
                </button>   
            </div>

            <div  id="resumen">
                <button id="buttonn" class="custom-button">
                    <a href="../tablas_alumno/resumen.php">
                    <i id="imggIconos" class="fa fa-pen-to-square"></i><p class="parrafooIconos">RESUMEN</p>
                </button>   
            </div>

            <div id="curriculum">
                <button id="buttonn" class="custom-button">
                    <a href="../tablas_alumno/crearcurriculum.php">
                    <i id="imggIconos" class="fa-solid fa-file-pdf"></i><p class="parrafooIconos">CURRICULUM</p>
                </button>  
            </div>
        </div>
    </main>
</body>
<?php include "../includes/footer.php" ?>
</html>