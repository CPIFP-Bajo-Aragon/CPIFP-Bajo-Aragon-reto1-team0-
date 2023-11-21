<?php
    if (isset($_POST['Buscar'])) {
        validarbusquedaofertas($conexion);
    } else {
        echo '<div id="oferta">';
        listarOfertasDesdeAlumno($conexion);                   
        echo '</div>';
    }
?>