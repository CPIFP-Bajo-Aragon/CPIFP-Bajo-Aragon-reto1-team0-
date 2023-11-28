<?php  include("../includes/links.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Academicos</title>
    <link rel="stylesheet" href="../../CSS/index.css">
</head>
<body>
    
<?php include("../includes/cabecera_registrado.php"); ?> 


<?php if ($_SESSION['tipoUsuario']!="alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Datos Académicos</li>
    </ul> 
    


    <main id="maindatosacademicos">
        <div id="botones">
            <div id="ofertas">
                <a href="experiencia-laboral-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" ></i><p class="parrafooIconos">EXPERIENCIA LABORAL</p>
                    </button>  
                </a> 
            </div>

            <div  id="resumen">
                <a href="estudios-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" ></i><p class="parrafooIconos">ESTUDIOS</p>
                    </button>   
                </a>
            </div>

            <div id="curriculum">
                <a href="idiomas-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" ></i><p class="parrafooIconos">IDIOMAS</p>
                    </button>  
                </a>
            </div>
        </div>
    </main>
</body>
<?php include "../includes/footer.php" ?>
</html>
<script src="../../JS/tablas_alumno/datosacademicos.js"></script>