<?php
    if (isset($_POST['Buscar'])) {
        validarbusquedaofertas($conexion);
    } else {
        echo '<div class="oferta"';
            mostrarOfertasInscritas($conexion, $id_usuario);
        echo '</div>';
    }
?>