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
    <?php $max_filas_por_pagina = 4; ?> <!-- Definición de una variable PHP -->

    <?php
        // Manejo de formularios POST y llamadas a funciones PHP según acciones
        if (isset($_POST["validar"])) {
            $id = $_POST["id_usuario"];
            validarregistroempresa($conexion, $id);
        }
        if (isset($_POST["borrar"])) {
            $id = $_POST["id_usuario"];
            borrarregistroempresa($conexion, $id);
        }
        if (isset($_POST["editar"])) {
            $id = $_POST["id_usuario"];
            editarregistroempresa($conexion, $id);
        }
    ?>

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="../paginas_inicio/PaginaAdmin.php">Menú</a></li>
        <li>Gestión Empresas</li>
    </ul> 

    <div>
        <h1 class="titulo">Gestión de Empresas</h1>
    </div>
  
    <!-- Filtros para buscar y filtrar información -->
    <div id="divfiltros">
        <div id="fbuscador">
            <!-- Formulario de búsqueda por nombre de empresas -->
            <form method="POST" action="listarempresas.php">
                <input type="text" name="termino_busqueda" id="buscador" placeholder="Buscar empresas">
                <input type="submit" value="Buscar">
            </form>
        </div>
        <div id="foblacion">
            <!-- Formulario de filtrado por población -->
            <form action="listarempresas.php" method="post" id="filtrarpoblacion">
                <?php
                include("../includes/provincia.php")
                ?>
                <input type="hidden" id="poblacionHidden" name="poblacionHidden" value="">
                <input type="submit" name="filtrarporpoblacion" value="Filtrar">
            </form>
        </div>
        <div id="fsector">
            <!-- Formulario de filtrado por sector -->
            <form action="listarempresas.php" method="post">
                <select id="sectorSelect" name="sectorSelect">
                    <?php listarsectores($conexion) ?>
                </select>
                <input type="hidden" id="sectorHidden" name="sectorHidden" value="">
                <input type="submit" name="filtrarsector" value="Filtrar">
            </form>
        </div>
        <div id="fvalidar">
            <!-- Formulario de filtrado por validación -->
            <form action="listarempresas.php" method="post" id="filtrarValidacion">
                Validado<input type="radio" name="filtrovalidar" value="validado" id="validado">
                <br>
                Sin validar<input type="radio" name="filtrovalidar" value="sinvalidar" id="sinvalidar">
                <br>
                Todos<input type="radio" name="filtrovalidar" value="todos" id="todos">
            </form>
        </div>
    </div>

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

<script>
       document.addEventListener('DOMContentLoaded', function () {
        // Almacena la tabla
        const tablaEmpresa = document.querySelector('#tabla');

        // Filtrador de validado
        const radioButtons = document.querySelectorAll('input[name="filtrovalidar"]');

        radioButtons.forEach(function (radio) {
            radio.addEventListener('change', function () {
                const filtro = this.value;

                // Obtén todas las filas de la tabla excepto la primera (encabezados).
                const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

                filas.forEach(function (fila) {
                    const columnaValidado = fila.querySelector('td:nth-child(9)').textContent.trim();

                    if (filtro === 'todos' || columnaValidado === (filtro === 'validado' ? 'validado' : 'novalidado')) {
                        fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                    } else {
                        fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                    }
                });
            });
        });

        // Filtrador por población
        const filtroPoblacionSelect = document.getElementById('filtrarpoblacion');
        filtroPoblacionSelect.addEventListener('submit', function (event) {
            event.preventDefault();

            const poblacionSeleccionada = document.getElementById('poblacionSelect').value;

            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

            // Recorre las filas y filtra según la población seleccionada.
            filas.forEach(function (fila) {
                const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');

                if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });

        // Buscador
        const buscadorForm = document.getElementById('fbuscador');
        buscadorForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const terminoBusqueda = document.getElementById('buscador').value.toLowerCase();

            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

            // Recorre las filas y filtra según el término de búsqueda.
            filas.forEach(function (fila) {
                var columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();

                if (columnaNombre.includes(terminoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
                var columnaNombre = fila.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (columnaNombre.includes(terminoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
                var columnaNombre = fila.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (columnaNombre.includes(terminoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    // Filtrador por sector
    const filtroSectorSelect = document.getElementById('fsector');
    filtroSectorSelect.addEventListener('submit', function (event) {
        event.preventDefault();

        const sectorSeleccionado = document.getElementById('sectorSelect').value;

        console.log('Sector seleccionado:', sectorSeleccionado);

        // Obtén todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Recorre las filas y filtra según el sector seleccionado.
        filas.forEach(function (fila) {
            const columnaIdSector = fila.querySelector('td:nth-child(10)').getAttribute('id');

            console.log('Sector en la fila:', columnaIdSector);

            if (sectorSeleccionado === "" || columnaIdSector === sectorSeleccionado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });

    });
    });

     // Función para abrir la ventana modal
//  function openModal(modalId) {
//     var modal = document.getElementById(modalId);
//     modal.style.display = 'block';
// }

// Asigna la función openModal al botón de abrir modal para empresas
// document.getElementById('editar').addEventListener('click', function() {
//     openModal('modalEmpresa');
// });

// // Función para cerrar la ventana modal
// function cerrarModal(modalId) {
//     var modal = document.getElementById(modalId);
//     modal.style.display = 'none';
// }

// // Asigna la función closeModal al span de cerrar modal para empresas
// document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
//     closeModal('modalEmpresa');
// });
</script>
</html>
