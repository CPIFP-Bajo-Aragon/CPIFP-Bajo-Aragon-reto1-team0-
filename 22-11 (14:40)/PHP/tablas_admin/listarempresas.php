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
                listarempresas($conexion,  $max_filas_por_pagina);
                
            ?>
        </table>
    </div>
    <div id='modalEmpresa' class='modal' style='display: none;'>
        <div id='modal-content' class='modal-content'></div>
    </div>

</body>

<?php include("../includes/footer.php"); ?> <!-- Inclusión de un archivo PHP para el pie de página -->
<script> 
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

    // Función para crear un elemento de entrada
    function crearInput(type, name, value) {
        var input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.value = value;
        return input;
    }

    var modalContent = document.getElementById('modal-content');

   // Asigna la función openModal al botón de abrir modal para empresas
document.querySelectorAll('[name="editar"]').forEach(function (button) {
    button.addEventListener('click', function (event) {
        
        
           event.preventDefault(); // Evitar la recarga de la página por defecto
           modalContent.innerHTML='';
        // Crear el botón de cerrar
        var close = document.createElement('span');
        close.className = 'close';
           close.textContent = '\u00D7';  // Código Unicode para la 'x'
        close.onclick = function() {
            cerrarModal('modalEmpresa');
        };


        var idUsuario = this.getAttribute('id').replace('editar_', '');

        


           // Crear el título del modal
        var h2 = document.createElement('h2');
        h2.textContent = 'Editar empresa';

           // Crear el formulario
        var form = document.createElement('form');
        form.action = 'empresas-admin';
        form.method = 'POST';

           // Crear e insertar los elementos de entrada en el formulario
        var inputNombreUsuario = crearInput('text', 'nombre_usuario', idUsuario);
        var inputNombre = crearInput('text', 'nombre', idUsuario);
        var inputCIF = crearInput('text', 'cif', idUsuario);
        var inputDireccion = crearInput('text', 'direccion', idUsuario);
        var inputCorreo = crearInput('text', 'correo', idUsuario);   
               // Crear el input para teléfono
        var inputTelefono = crearInput('text', 'telefono', idUsuario);
               // Crear el input oculto para el id_usuario
        var inputIdUsuario = crearInput('hidden', 'id_usuario', idUsuario);
               // Crear el botón de submit
        var inputSubmit = document.createElement('input');
        inputSubmit.type = 'submit';
        inputSubmit.name = 'guardar';
        inputSubmit.value = 'Guardar';

        // Asignar identificadores únicos a los elementos
        inputNombreUsuario.id = 'inputNombreUsuario';
        inputNombre.id = 'inputNombre';
        inputCIF.id = 'inputCIF';
        inputDireccion.id = 'inputDireccion';
        inputCorreo.id = 'inputCorreo';
        inputTelefono.id = 'inputTelefono';
        inputIdUsuario.id = 'inputIdUsuario';
        
        
        cargarVentanaModal(idUsuario);


       
        // Agregar elementos al formulario
        form.appendChild(inputNombreUsuario);
        form.appendChild(inputNombre);
        form.appendChild(inputCIF);
        form.appendChild(inputDireccion);
        form.appendChild(inputCorreo);
        form.appendChild(inputTelefono);
        form.appendChild(inputIdUsuario);
        form.appendChild(inputSubmit);

        // Agregar elementos al contenedor del modal
        modalContent.appendChild(close);
        modalContent.appendChild(h2);
        modalContent.appendChild(form);
        

        
        
        llenarDatosEnModal(modalEmpresa);

        openModal('modalEmpresa');
});

});
   
function llenarDatosEnModal(datosEmpresa) {
    document.getElementById('inputNombreUsuario').value = datosEmpresa.nombre_usuario;
    document.getElementById('inputNombre').value = datosEmpresa.nombre_empresa;
    document.getElementById('inputCIF').value = datosEmpresa.cif;
    document.getElementById('inputDireccion').value = datosEmpresa.direccion;
    document.getElementById('inputCorreo').value = datosEmpresa.correo;
    document.getElementById('inputTelefono').value = datosEmpresa.telefono;
    document.getElementById('inputIdUsuario').value = datosEmpresa.id_usuario;
}

function cargarVentanaModal(idUsuario) {
    // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
    fetch('/PHP/tablas_admin/editarempresa.php?id_usuario=' + idUsuario)
        .then(response => response.json())
        .then(modalEmpresa => {
            // Pinta los datos en la modal
            llenarDatosEnModal(modalEmpresa);

            // Muestra la modal
            openModal('modalEmpresa');
        });
}
</script>
<script src="../../JS/tablas_admin/listarempresas.js"></script>
</html>
