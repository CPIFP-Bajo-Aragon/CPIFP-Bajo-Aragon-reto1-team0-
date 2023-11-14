<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
    <!-- <link rel="stylesheet" href="../../CSS/index.css"> -->

     <style>
       

/*
aside.filtros {
    float: left;
    width: 25%;
    padding: 20px;
    box-sizing: border-box;
    background-color: white; 
} */

/* article.article {
    float: right;
    width: 75%;
    padding: 20px;
    box-sizing: border-box;
    background-color: white; 
}

form {
    margin-bottom: 10px;
}

input[type="text"], select {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #568c98;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
} */

/*
    .oferta {
       width: 50%; 
         margin: 10px;
        border: 1px solid #ccc; 
        padding: 10px;
       text-align: center;
    }
    */
/*
    .oferta {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; 
} 

.oferta article {
    width: calc(25% - 10px); 
    margin-bottom: 20px; 
    box-sizing: border-box;
}
*/

.oferta {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Distribuir el espacio entre los elementos en la fila */
        }

        /* Estilo para cada oferta individual */
        .oferta article {
            width: calc(25% - 10px); /* Ancho del 25% con un pequeño espacio entre las ofertas */
            margin-bottom: 20px; /* Espacio entre las filas */
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Estilo para el título de la oferta */
        .oferta article h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Estilo para los datos de la oferta */
        .oferta article p {
            font-size: 14px;
            margin-bottom: 8px;
        }
    </style> 
</head>

<?php
    include("../includes/conexion.php");
    include("../includes/funciones.php");
?> 

<?php include ("../includes/cabecera_registrado.php"); ?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="../paginas_inicio/PaginaAlumno.php">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul> 
    <aside class="filtros">
        <div id="divfiltros">
            <div id="foblacion">
                <form action="listarempresas.php" method="post" id="filtrarpoblacion">
                    <?php
                    include("../includes/provincia.php")
                    ?>
                    <input type="hidden" id="poblacionHidden" name="poblacionHidden" value="">
                    <input type="submit" name="filtrarporpoblacion" value="Filtrar">
                </form>
            </div>
            <div id="fsector">
                <form action="listarempresas.php" method="post">
                    <select id="sectorSelect" name="sectorSelect">
                        <?php listarsectores($conexion) ?>
                    </select>
                    <input type="hidden" id="sectorHidden" name="sectorHidden" value="">
                    <input type="submit" name="filtrarsector" value="Filtrar">
                </form>
            </div>
        </div>
    </aside>

   
    <article class="article">
        <form action="listarofertas.php" method="POST">
            <input type="text" name="Busqueda" placeholder="Ingrese su búsqueda">
            <input type="submit" value="Buscar" name="Buscar" >
        </form><br>
        <a href="listarofertas.php"><input type="submit" value="Recargar" id="Registrar_empesa"></a>
        
        <?php
            if (isset($_POST['Buscar'])) {
                validarbusquedaofertas($conexion);
            } else {
                echo '<div class="oferta">';
                    listarOfertasDesdeAlumno($conexion);
                echo '</div>';
            }
        ?>
    </article>



</body>

<?php include ("../includes/footer.php"); ?>

</html>