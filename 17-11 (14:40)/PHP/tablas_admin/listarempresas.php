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
            validarregistro($conexion, $id);
        }
        if (isset($_POST["borrar"])) {
            echo "entra";
            $id = $_POST["id_usuario"];
            borrarregistroempresa($conexion, $id);
        }

        if (isset($_POST["guardar"])) {
                
                $id = $_POST["id_usuario"];
                // Obtiene los datos del formulario
                $id_usuario = $_POST['id_usuario'];
                $nombre_usuario = $_POST['nombre_usuario'];
                $nombre_empresa = $_POST['nombre'];
                $cif = $_POST['cif'];
                $direccion = $_POST['direccion'];
                $correo = $_POST['correo'];
                $telefono = $_POST['telefono'];
                $poblacion = $_POST['poblacionSelect'];
                $sector = $_POST['id_sector'];
                
                
                // Actualiza los datos en la base de datos
                $sql = "UPDATE empresa
                        SET 
                        nombre_empresa= :nombre_empresa,
                        cif=:cif,
                        id_poblacion=:id_poblacion,
                        direccion=:direccion,
                        telefono=:telefono,
                        id_sector=:sector
                        WHERE id_usuario = :id_usuario";
                $consulta = $conexion->prepare($sql);
                $consulta->bindParam(':nombre_empresa', $nombre_empresa);
                $consulta->bindParam(':cif', $cif);
                $consulta->bindParam(':direccion', $direccion);
                $consulta->bindParam(':telefono', $telefono);
                $consulta->bindParam(':id_poblacion', $poblacion );
                $consulta->bindParam(':sector', $sector );
                $consulta->bindParam(':id_usuario', $id_usuario);
                $consulta->execute();


                $sqlUsuario = "UPDATE usuario
                        SET 
                        nombre_usuario=:nombre_usuario,
                        correo=:correo
                        WHERE id_usuario = :id_usuario";
                $consulta = $conexion->prepare($sqlUsuario);
                $consulta->bindParam(':nombre_usuario', $nombre_usuario);
                $consulta->bindParam(':correo', $correo);
                $consulta->bindParam(':id_usuario', $id_usuario);
                $consulta->execute();

            
            
            
                
        }
        if (isset($_POST["editar"])) {
            $id = $_POST["id_usuario"];
            editarregistroempresa($conexion, $id);
        }
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
    <div id="divfiltros">
        <div id="fbuscador">
            <!-- Formulario de búsqueda por nombre de empresas -->
            <form method="POST" action="empresas-admin">
                <input type="text" name="buscador" id="buscador" placeholder="Buscar empresas">
            </form>
        </div>
        <div id="foblacion">
            <!-- Formulario de filtrado por población -->
            <form action="empresas-admin" method="post" id="filtrarpoblacion">
                <select name="poblacionSelect" id="poblacionSelect">
                <?php
                listarProvinciaypoblacion($conexion, "poblacionSelect")
                ?>
                </select>
            </form>
        </div>
        <div id="fsector">
            <!-- Formulario de filtrado por sector -->
            <form action="empresas-admin" method="post">
                <select id="sectorSelect" name="sectorSelect">
                    <?php listarsectores($conexion) ?>
                </select>
            </form>
        </div>
        <div id="fvalidar">
            <!-- Formulario de filtrado por validación -->
            <form action="empresas-admin" method="post" id="filtrarValidacion">
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
        const filtroPoblacionSelect = document.getElementById('poblacionSelect');
        filtroPoblacionSelect.addEventListener('change', function () {
           
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

        const filtroNombreInput = document.getElementById('buscador');

        filtroNombreInput.addEventListener('input', function () {
            const filtroTexto = this.value.toLowerCase();
            const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

            filas.forEach(function (fila) {
                const columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Cambié el índice a 3 para obtener el nombre de usuario

                if (columnaNombre.includes(filtroTexto)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });

        // const buscadorForm = document.getElementById('fbuscador');
        // buscadorForm.addEventListener('submit', function (event) {
        //     event.preventDefault();


        //     // Obtén todas las filas de la tabla excepto la primera (encabezados).
        //     const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        //     const terminoBusqueda = document.getElementById('buscador').value.toLowerCase();
        //     // Recorre las filas y filtra según el término de búsqueda.
        //     filas.forEach(function (fila) {

        //         filas.forEach(function (fila) {
        //             var columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
        //             var columnaDireccion = fila.querySelector('td:nth-child(4)').textContent.toLowerCase();
        //             var columnaNombreUsu = fila.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    
        //             if (columnaNombre.includes(terminoBusqueda) || columnaNombreUsu.includes(terminoBusqueda) || columnaDireccion.includes(terminoBusqueda)) {
        //                 fila.style.display = '';
        //             } else {
        //                 fila.style.display = 'none';
        //             }
        //         });

                

                
        //     });
        // });
    // Filtrador por sector
    const filtroSectorSelect = document.getElementById('sectorSelect');
    filtroSectorSelect.addEventListener('change', function () {
        event.preventDefault();

        const sectorSeleccionado = document.getElementById('sectorSelect').value;


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
  function openModal(modalId) {
     var modal = document.getElementById(modalId);
     modal.style.display = 'block';
 }

// Asigna la función openModal al botón de abrir modal para empresas
 document.getElementById('editar').addEventListener('click', function() {
     openModal('modalEmpresa');
});

// // Función para cerrar la ventana modal
function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Asigna la función cerrarModal al span de cerrar modal para empresas
document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
    cerrarModal('modalEmpresa');
});

</script>
</html>
