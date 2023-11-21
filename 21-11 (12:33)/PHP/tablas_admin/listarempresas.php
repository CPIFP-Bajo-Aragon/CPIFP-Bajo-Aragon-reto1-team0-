<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css"> <!-- Enlace a una hoja de estilo CSS externa -->
    <title>Listado Empresas</title>
    <?php
        // Inclusión de archivos PHP con funciones y conexión a la base de datos
        include("../includes/conexion.php");
        include("../includes/funciones.php");
    ?>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            width: 70%;
            max-width: 700px; 
            max-height: 80vh; 
            overflow-y: auto; 
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            text-align: center;
        }

        .modal-content input {
            width: calc(100% - 5px); 
            padding: 10px; 
            margin-bottom: 10px; 
            box-sizing: border-box;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        label{
            color: rgba(0, 0, 0, 0.5);
        }

    </style>
</head>

<?php include("../includes/cabecera_registrado.php"); ?> <!-- Inclusión de un archivo PHP para la cabecera -->

<body>
    <?php 
        $max_filas_por_pagina = 4; 
        include "../includes/isset/tablas_admin/listarempresas.php";
    ?>

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-admin">Menú</a></li>
        <li>Gestión Empresas</li>
    </ul> 

    <div>
        <h1 class="titulo">Gestión de Empresas</h1>
    </div>
  
    <!-- Filtros para buscar y filtrar información -->
    <?php
        include "../includes/filtros/tablas_admin/listarempresas.php";
    ?>

    <!-- Tabla que muestra la información de las empresas -->
    <div id="tabla">
        <table>
            <!-- Encabezados de la tabla -->
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Nombre de Usuario</td>
                <td>Dirección</td>
                <td>Correo</td>
                <td>Teléfono</td>
                <td>CIF</td>
                <td>Población</td>
                <td>Validado</td>
                <td>Sector</td>
                <td>Opciones</td>
            </tr>
            <?php 
                listarempresas($conexion,  $max_filas_por_pagina)
            ?>
        </table>
    </div>
</body>

<?php include("../includes/footer.php"); ?> <!-- Inclusión de un archivo PHP para el pie de página -->

<script src="../../JS/tablas_admin/listarempresas.js"></script>
</html>
