<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
    <link rel="stylesheet" href="../../CSS/index.css">

    <!-- <style>
       
h1{
    color: black;
}
aside.filtros {
    float: left;
    width: 25%;
    padding: 20px;
    box-sizing: border-box;
    background-color: white; 
}



article.article {
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
}

.oferta {
    border: 1px solid #ddd;
    padding: 10px;
    margin: 10px 0;
 
   
}
    </style> -->
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