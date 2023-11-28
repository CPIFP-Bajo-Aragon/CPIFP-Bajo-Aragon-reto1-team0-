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
                display: flex;
                flex-direction: column;
                align-items: center;
              
            }

            #ofertas,
            #resumen,
            #curriculum,
            #usuario,
            #chat {
                flex: 1;
            }

            #buttonn {
                width: 10px;
                height: 10px;
            }

            #botones button {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            #botones button p {
                font-size: 1em;
            }

            #botones i {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }

        }
    </style>
</head>

<body class="paginasInicio">
    <?php include("../includes/cabecera_registrado.php"); ?>

    <!-- ISSET -->
    <?php
    if ($_SESSION['tipoUsuario'] != "alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }
    ?>

    <main id="mainpaginaalumno" class="inicio">
        <div id="botones">

            <div id="ofertas">
                <a href="ofertas-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-magnifying-glass"></i>
                        <p class="parrafooIconos">BUSCAR</p>
                        <p class="parrafooIconos">OFERTAS</p>
                    </button>
                </a>
            </div>

            <div id="resumen">
                <a href="resumen-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa fa-pen-to-square"></i>
                        <p class="parrafooIconos">RESUMEN</p>
                    </button>
                </a>
            </div>

            <div id="curriculum">
                <a href="curriculum-alumno">
                    <button id="buttonn" class="custom-button">
                        <i id="imggIconos" class="fa-solid fa-file-pdf"></i>
                        <p class="parrafooIconos">CURRICULUM</p>
                    </button>
                </a>
            </div>
        </div>
    </main>

    <?php include "../includes/footer.php" ?>

    <script src="../../JS/paginas_inicio/PaginaAlumno.js"></script>
</body>

</html>
