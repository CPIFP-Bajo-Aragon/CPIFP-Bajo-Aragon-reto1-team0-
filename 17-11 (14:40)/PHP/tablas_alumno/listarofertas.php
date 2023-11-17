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
     <!-- <link rel="stylesheet" href="../../CSS/listados.css">  -->
     

     <style>

    </style> 
</head>



<?php include ("../includes/cabecera_registrado.php"); ?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul> 
    
    <div id="filtros">
       
        <div id="fpoblacion">
            <select name="poblacionSelect" id="poblacionSelect">
                    <?php
                    listarProvinciaypoblacion($conexion, $select_name)
                    ?>
                    </select>
            
       
 

   
    <article class="article">
        <form action="ofertas-alumno" method="POST">
            <input type="text" name="Busqueda" placeholder="Ingrese su búsqueda">
            <input type="submit" value="Buscar" name="Buscar" >
        </form><br>
        <!-- <a href="listarofertas.php"><input type="submit" value="Recargar" id="Registrar_empesa"></a>
         -->
        <?php
            if (isset($_POST['Buscar'])) {
                validarbusquedaofertas($conexion);
            } else {
                echo '<div id="divoferta">';
                listarOfertasDesdeAlumno($conexion);                   
                echo '</div>';
            }
        ?>
    </article>
</body>

<?php include ("../includes/footer.php"); ?>

<script>
    
        
        
        // Filtrador por población
      
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');

// Añade un evento de cambio al menú desplegable de población
filtroPoblacionSelect.addEventListener('change', function () {
    // Obtiene la población seleccionada del menú desplegable
    const poblacionSeleccionada = filtroPoblacionSelect.value;
    // Obtiene todas las filas de la tabla excepto la primera (encabezados)
    const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

    // Itera sobre cada fila para aplicar el filtro por población
    filas.forEach(function (fila) {
        // Obtiene el ID de población de la columna "Población"
        const columnaIdPoblacion = fila.querySelector('td:nth-child(6)').getAttribute('id');

        // Muestra la fila si coincide con el filtro, oculta si no coincide
        if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});


</script>

</html>