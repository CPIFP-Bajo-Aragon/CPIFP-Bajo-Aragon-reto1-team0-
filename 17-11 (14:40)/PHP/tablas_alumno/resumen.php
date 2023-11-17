<?php
    include("../includes/conexion.php");
    include("../includes/funciones.php");
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
    <link rel="stylesheet" href="../../CSS/listados.css"> 
</head>



<?php include ("../includes/cabecera_registrado.php"); ?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Resumen</li>
    </ul> 
    <h3>OFERTAS EN LAS QUE ESTAS INSCRITO: </h3>
    <aside class="filtros">
        <div id="divfiltros">
            <div id="foblacion">
                <form action="resumen.php" method="post" id="filtrarpoblacion">
                <select name="poblacion" id="poblacion">
                <?php    
                listarProvinciaypoblacion($conexion, "poblacion")
                ?>    
                </select>
                    <input type="hidden" id="poblacionHidden" name="poblacionHidden" value="">
                    <input type="submit" name="filtrarporpoblacion" value="Filtrar">
                </form>
            </div>
            <div id="fsector">
                <form action="resumen.php" method="post">
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
        <form action="resumen.php" method="POST">
            <input type="text" name="Busqueda" placeholder="Ingrese su búsqueda">
            <input type="submit" value="Buscar" name="Buscar" >
        </form><br>
      
        
        <?php
            if (isset($_POST['Buscar'])) {
                validarbusquedaofertas($conexion);
            } else {
                echo '<div class="oferta">';

                mostrarOfertasInscritas($conexion, $id_usuario);

                echo '</div>';
            }
        ?>
    </article>



    <?php include ("../includes/footer.php"); ?>

</body>



</html>