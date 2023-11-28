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
    <link rel="stylesheet" href="../../CSS/index.css">
    <?php
    include("../includes/links.php")
    ?>
</head>

<body>
    <?php
        include("../includes/cabecera_registrado.php");

        // Verificar el tipo de usuario
        if ($_SESSION['tipoUsuario'] != "alumno") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
        }
    ?>
    <main id="listarofertasalumno">
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

            <div id="fpoblacion">
                <select name="poblacionSelect" id="poblacionSelect">
                    <option value="poblacionSelect" selected disabled>Seleccione una población</option>
                    <?php listarProvinciaypoblacion($conexion, $select_name)?>
                </select>
            </div>

            <div id="fsector">
                <select name="sectorSelect" id="sectorSelect">
                <option value="sectorSelect" selected disabled>Seleccione un sector</option>
                    <?php listarsectores($conexion, $select_name) ?>
                </select>    
            </div>

            <div id="meses">
                <!-- Filtro para la duración del contrato -->
                <label for="">Duración del Contrato:</label>
                <input type="range" id="filtroDuracionContrato" min="0" max="24" step="1" value="0">
                <span id="duracionContratoLabel">Cualquier duración</span>
            </div>  
        </div>
    
        <div id="tabla" class="datosTabla">
            <?php
                echo '<div id="oferta" class="oferta">';
                listarOfertasDesdeAlumno($conexion);                   
                echo '</div>';
            ?>
        </div>
    </main>
    <?php include ("../includes/footer.php"); ?>
</body>

<script>
    // Espera a que el contenido del documento HTML esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        // Obtiene la tabla de ofertas de trabajo
        const tablaOfertas = document.querySelector('#tabla');

        // Actualizar página 
        document.addEventListener('DOMContentLoaded', function () {
            // Obtiene el formulario y el botón de inscripción
            const formInscribir = document.getElementById('formInscribir');
            const btnInscribirme = document.getElementById('inscribirme');

            // Agrega un evento de escucha al formulario
            formInscribir.addEventListener('submit', function (event) {
                // Evita la recarga de la página por defecto
                event.preventDefault(); 

                // Envía el formulario de manera síncrona
                formInscribir.submit();

                // Redirige a la misma página después de enviar el formulario
                // window.location.href = window.location.href;
            });
        });

        // Filtro sector
        const filtroSectorSelect = document.getElementById('sectorSelect');

        // Añade un evento de cambio al menú desplegable de población
        filtroSectorSelect.addEventListener('change', function () {
            // Obtiene el sector seleccionado del menú desplegable
            const sectorSeleccionado = filtroSectorSelect.value;
            // Obtiene todas las ofertas (divs) dentro del contenedor
            const ofertas = document.querySelectorAll('.oferta');

            // Itera sobre cada oferta para aplicar el filtro por sector
            ofertas.forEach(function (oferta) {
                // Obtiene el ID de sector de la oferta
                const columnaIdsector = oferta.querySelector('.sector').getAttribute('id');

                // Muestra la oferta si coincide con el filtro, oculta si no coincide
                if (sectorSeleccionado === "" || columnaIdsector === sectorSeleccionado) {
                    oferta.style.display = '';
                } else {
                    oferta.style.display = 'none';
                }
            });
        });

        // Filtrado por población
        const filtroPoblacionSelect = document.getElementById('poblacionSelect');

        // Añade un evento de cambio al menú desplegable de población
        filtroPoblacionSelect.addEventListener('change', function () {
            // Obtiene la población seleccionada del menú desplegable
            const poblacionSeleccionada = filtroPoblacionSelect.value;
            console.log("Población seleccionada:", poblacionSeleccionada);

            // Obtiene todas las ofertas (divs) dentro del contenedor
            const ofertas = document.querySelectorAll('.oferta');

            // Itera sobre cada oferta para aplicar el filtro por población
            ofertas.forEach(function (oferta) {
                // Obtiene el ID de población de la oferta
                const columnaIdPoblacion = oferta.querySelector('.poblacion').getAttribute('id');

                // Muestra la oferta si coincide con el filtro, oculta si no coincide
                if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                    oferta.style.display = '';
                } else {
                    oferta.style.display = 'none';
                }
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



 const inputDuracionContrato = document.getElementById('filtroDuracionContrato');
const duracionContratoLabel = document.getElementById('duracionContratoLabel');

inputDuracionContrato.addEventListener('input', function () {
    const duracionSeleccionada = parseInt(this.value, 10);
    duracionContratoLabel.textContent = duracionSeleccionada === 0 ? "Cualquier duración" : `Menos de ${duracionSeleccionada} meses`;

    const ofertas = document.querySelectorAll('.oferta');

    ofertas.forEach(function (oferta) {
        let columnaDuracion = parseInt(oferta.querySelector('.duracion-contrato').textContent);

        if (duracionSeleccionada === 0 || columnaDuracion <= duracionSeleccionada) {
    oferta.style.display = ''; 
} else {
    oferta.style.display = 'none'; 
}
    });
});




//paginar


</script>
</html>