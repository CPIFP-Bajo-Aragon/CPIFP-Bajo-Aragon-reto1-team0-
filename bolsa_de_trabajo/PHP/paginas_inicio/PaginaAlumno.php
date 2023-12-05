<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Alumno</title>
    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

                #resumen{
                    margin-top: 20px;
                    margin-bottom: 20px;
                }

                #mainpaginaalumno{
                    width: 400px;
                    margin-left: 20px; 
                }

                #curriculum{
                    margin-bottom: 20px;
                }
            }
    </style>
</head>

<body >

    <?php include("../includes/cabecera_registrado.php"); ?>

    <!-- ISSET -->
    <?php
        if ($_SESSION['tipoUsuario'] != "alumno") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
        }
    ?>
    

    <main id="mainpaginaalumno">
        <div id="botones">

            <div id="ofertas">
                <a href="ofertas-alumno">
                    <button id="buttonn" class="custom-button">
                    <p class="parrafoIconos">BUSCAR OFERTAS</p>

                    </button>

                </a>

            </div>

            <div id="resumen">
                <a href="resumen-alumno">
                    <button id="buttonn" class="custom-button">
                        <!--<i id="imggIconos" class="fa fa-pen-to-square"></i>-->
                        <p class="parrafoIconos">RESUMEN</p>
                    </button>
                </a>
                
            </div>

            <div id="curriculum">
                <a href="curriculum-alumno">
                    <button id="buttonn" class="custom-button">
                       <!-- <i id="imggIconos" class="fa-solid fa-file-pdf"></i>-->
                        <p class="parrafoIconos">CURRICULUM</p>
                    </button>
                </a>
            </div>
        </div>
    </main>

    <?php include "../includes/footer.php" ?>

    <script src="../../JS/paginas_inicio/PaginaAlumno.js"></script>
</body>

</html>