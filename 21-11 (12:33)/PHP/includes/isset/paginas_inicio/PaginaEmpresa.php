<?php
    if ($_SESSION['tipoUsuario']!="empresa") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }
?>