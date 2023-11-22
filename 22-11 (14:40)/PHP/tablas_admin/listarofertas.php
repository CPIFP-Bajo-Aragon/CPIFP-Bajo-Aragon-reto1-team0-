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
    <div id='modalOfertas' class='modal' style='display: none;'>
        <div id='modal-content' class='modal-content'></div>
    </div>
    <!-- Inclusión del pie de página desde otro archivo PHP -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>

<!--<script src="../../JS/tablas_admin/listarofertas.js"></script>-->
<script>
    
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Función para cerrar la ventana modal
function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

    
    function crearInput(type, name, value) {
        var input = document.createElement('input');
        input.type = type;
        input.name = name;

        // Cambiar value por su valor real
        input.value = "hola";
        return input;
    }

    var modalContent = document.getElementById('modal-content');
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[name="editar"]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            var close = document.createElement('span');
            close.className = 'close';
            close.textContent = '\u00D7';
            close.onclick = function () {
                cerrarModal('modalOfertas');
            };

            var idOferta = button.getAttribute('id').replace('editar_', '');

            var modalContent = document.getElementById('modal-content');

            modalContent.innerHTML = '';

            var h2 = document.createElement('h2');
            h2.textContent = 'Editar oferta';

            var form = document.createElement('form');
            form.action = 'ofertas-admin';
            form.method = 'POST';
    
            var inputTitulo = crearInput('text', 'titulo', idOferta);
            var inputDescripcion = crearInput('text', 'descripcion', idOferta);
            var inputDuracionContrato = crearInput('text', 'duracion_contrato', idOferta);
            var inputCarnet = crearInput('text', 'carnet', idOferta);
            var inputPoblacion = crearInput('text', 'poblacion', idOferta);
            var inputAptitud = crearInput('text', 'aptitud', idOferta);
            var inputIdOferta = crearInput('hidden', 'id_oferta', idOferta);
            var inputSubmit = document.createElement('input');
            inputSubmit.type = 'submit';
            inputSubmit.name = 'Guardar';
            inputSubmit.value = 'Guardar';
    
            inputTitulo.id = 'inputTitulo';
            inputDescripcion.id = 'inputDescripcion';
            inputDuracionContrato.id = 'inputDuracionContrato';
            inputCarnet.id = 'inputCarnet';
            inputPoblacion.id = 'inputPoblacion';
            inputAptitud.id = 'inputAptitud';
            inputIdOferta.id = 'inputIdOferta';
    
            form.appendChild(inputTitulo);
            form.appendChild(inputDescripcion);
            form.appendChild(inputDuracionContrato);
            form.appendChild(inputCarnet);
            form.appendChild(inputPoblacion);
            form.appendChild(inputAptitud);
            form.appendChild(inputIdOferta);
            form.appendChild(inputSubmit);
    
            modalContent.appendChild(close);
            modalContent.appendChild(h2);
            modalContent.appendChild(form);

            llenarDatosDesdePHP(); // Pass datosOferta as a parameter

            openModal('modalOfertas');
        });
    });

    // Función para llenar datos desde PHP
    function llenarDatosDesdePHP() {
        // Asignar valores a los inputs (reemplaza esto con tus datos reales)
        if (typeof datosOferta !== 'undefined') {
        document.getElementById('inputTitulo').value = datosOferta.titulo;

        document.getElementById('inputDescripcion').value = datosOferta.descripcion;
        document.getElementById('inputDuracionContrato').value = datosOferta.duracion_contrato;
        document.getElementById('inputCarnet').value = datosOferta.carnet;
        document.getElementById('inputPoblacion').value = datosOferta.poblacion;
        document.getElementById('inputAptitud').value = datosOferta.aptitud;
        document.getElementById('inputIdOferta').value = datosOferta.id_oferta;
        }
    }
});
</script>

