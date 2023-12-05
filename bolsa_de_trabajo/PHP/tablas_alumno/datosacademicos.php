
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Academicos</title>
    <link rel="stylesheet" href="../../CSS/index.css">

    <style>
        @media (max-width: 700px) {
            #botones {
                flex-direction: column; 
                justify-content: space-around;
            }

            #button {
                width: 150px;
                height: 150px; 
                margin: 10px 8px;
            }

            button.custom-button {
                width: 300px; 
                height: 150px;
            }

            #estudios{
                margin-top: 20px;
                margin-bottom: 20px;
            }

            #maindatosacademicos{
                width: 400px;
                margin-left: 20px; 
            }

            #idiomas{
                margin-bottom: 20px;
            }
        }
    </style>
 
   
</head>
<body class="paginasInicio">

<?php include("../includes/cabecera_registrado.php"); 
include("../includes/links.php");
?>
<?php if ($_SESSION['tipoUsuario']!="alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>
    <main class="maindatosacademicos">

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Datos Académicos</li>
    </ul> 
    
        <div id="botoness">
            <div id="experiencia">
                <a href="experiencia-laboral-alumno">
                    <button id="buttonn" class="custom-button">
                       <p class="parrafooIconos">EXPERIENCIA LABORAL</p>
                    </button>  
                </a> 
            </div>

            <div  id="estudios">
                <a href="estudios-alumno">
                    <button id="buttonn" class="custom-button">
                        <p class="parrafooIconos">ESTUDIOS</p>
                    </button>   
                </a>
            </div>

            <div id="idiomas">
                <a href="idiomas-alumno">
                    <button id="buttonn" class="custom-button">
                        <p class="parrafooIconos">IDIOMAS</p>
                    </button>  
                </a>
            </div>
        </div>
    </main>
    <?php include "../includes/footer.php" ?>
</body>

</html>
<script src="../../JS/tablas_alumno/datosacademicos.js"></script>