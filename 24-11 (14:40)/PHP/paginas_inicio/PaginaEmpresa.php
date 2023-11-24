<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">

    <title>Menu Empresa</title>
    <style>
         <style>

@media (max-width: 700px) {
    body {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 7fr 4fr;
        height: 100vh;
    }
    #botoness{
        
        display: flex;
        flex-direction: column;

    }
    #botoness button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    #botoness button p{
      
        font-size: 1em; /* Oculta el texto */
    }

    #botoness i {
        font-size: 2rem;  /* Ajusta el tamaño del icono según tus necesidades */
        margin-bottom: 0.5rem; /* Ajusta el margen inferior según tus necesidades */
    }
    footer {
        position: fixed;
        width: 100vw;
        height: 10vh;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto auto auto;
        background-color: rgba(26, 154, 182, 0.3);
        color: #fff;
    }
}
        </style>
    </style>
</head>
<?php
include("../includes/funciones.php");
include("../includes/cabecera_registrado.php");


?>

<body>  
    <!-- ISSET -->
        <?php
            if ($_SESSION['tipoUsuario']!="empresa") {
                // No ha iniciado sesión, redirige a la página de inicio de sesión
                header("Location: inicio");
                exit();
            }
        ?>
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
<script src="../../JS/paginas_inicio/PagomaEmpresa.js"></script>