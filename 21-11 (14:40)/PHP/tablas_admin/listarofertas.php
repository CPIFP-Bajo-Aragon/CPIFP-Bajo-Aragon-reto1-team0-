<?php
// Inclusión de archivos PHP con funciones y conexión a la base de datos
include("../includes/conexion.php");
include("../includes/funciones.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Configuración del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  link="../CSS/index.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezjwMz0OJnFLFfNf3e1oA00ZHYj7aJ/N62g1R9bcuU/PU4F2KsR2qro1Q8AzNlAa" crossorigin="anonymous">


    <title>Ofertas de Trabajo</title>
    <style>

    </style>
</head>

<?php
    // Inclusión de la cabecera de la página desde otro archivo PHP
    include("../includes/cabecera_registrado.php");
    include ("../includes/isset/tablas_admin/listarofertas.php");
?>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-admin">Menú</a></li>
        <li>Gestión Ofertas</li>
    </ul> 

    <div>
        <h1 class="titulo">GESTION DE OFERTAS</h1>
    </div>

    <!-- Filtros para búsqueda y filtrado -->
    <?php $max_filas_por_pagina = 4; ?>

    <?php
        include "../includes/filtros/tablas_admin/listarofertas.php"
    ?>
    
    <!-- Tabla que muestra la información de las ofertas de trabajo -->
    <div id="tabla">
        <table>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha de Publicación</th>
                <th>Duración del Contrato (meses)</th>
                <th>Requiere Carnet de Conducir</th>
                <th>Población</th>
                <th>Empresa</th>
                <th>Opciones</th>
            </tr>
            <?php listarofertas($conexion, $max_filas_por_pagina); ?>
            <!-- Elemento div extra no válido dentro de la tabla -->
            <div id="midiv"></div>
        </table>
    </div>
    
    <!-- Inclusión del pie de página desde otro archivo PHP -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>

<script src="../../JS/tablas_admin/listarofertas.js"></script>

