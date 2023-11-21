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
    <link rel="stylesheet" href="../CSS/alumno.css">
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezjwMz0OJnFLFfNf3e1oA00ZHYj7aJ/N62g1R9bcuU/PU4F2KsR2qro1Q8AzNlAa" crossorigin="anonymous">

</head>



<?php include ("../includes/cabecera_registrado.php"); ?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul> 
    
    <div id="filtros">
        <div id="fbusqueda">
            <!-- Input para buscar por título -->
            <input type="text" id="filtroTitulo" placeholder="Buscador por Título">
        </div>

       
    </div>
   
    <div id="tabla" class="datosTabla">
        <?php
           
                echo '<div id="oferta">';
                mostrarOfertasInscritas($conexion, $id_usuario);                   
                echo '</div>';
        
        ?>
    </div>

    <?php include ("../includes/footer.php"); ?>
</body>
</html>

<script>
    // Espera a que el contenido del documento HTML esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        // Obtiene la tabla de ofertas de trabajo
        const tablaOfertas = document.querySelector('#tabla');

    //actualizar pagina 
    document.addEventListener('DOMContentLoaded', function () {
        // Obtiene el formulario y el botón de inscripción
        const formInscribir = document.getElementById('formInscribir');
        const btnInscribirme = document.getElementById('anular');

        // Agrega un evento de escucha al formulario
        formInscribir.addEventListener('submit', function (event) {
            event.preventDefault(); // Evita la recarga de la página por defecto

            // Envía el formulario de manera síncrona
            formInscribir.submit();

            // Redirige a la misma página después de enviar el formulario
           window.location.href = window.location.href;
        });
    });

    // Filtrado por título mediante entrada de texto
    const filtroTituloInput = document.getElementById('filtroTitulo');

    // Añade un evento de entrada al campo de entrada de texto para el filtro por título
    filtroTituloInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas
        const filtroTexto = this.value.toLowerCase();
        // Obtiene todas las ofertas (divs) dentro del contenedor
        const ofertas = document.querySelectorAll('.oferta');

        // Itera sobre cada oferta para aplicar el filtro por título
        ofertas.forEach(function (oferta) {
            // Obtiene el contenido del h2 dentro de la oferta
            const tituloOferta = oferta.querySelector('h2').textContent.toLowerCase();

            // Muestra la oferta si coincide con el filtro, oculta si no coincide
            if (tituloOferta.includes(filtroTexto)) {
                oferta.style.display = ''; // Muestra la oferta si coincide con el filtro.
            } else {
                oferta.style.display = 'none'; // Oculta la oferta si no coincide con el filtro.
            }
        });
    });
    });

    

</script>