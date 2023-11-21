<?php
    if(isset($_POST['insertarempresa'])){
        crearempresacliente($conexion);
    }
    if(isset($_POST['insertaralumno'])){
        insertaralumnocliente($conexion);
    }
?>