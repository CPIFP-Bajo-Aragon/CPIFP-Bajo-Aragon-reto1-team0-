<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Listado Empresas</title>
    <?php
    include("../includes/links.php");
        include("../includes/conexion.php");
        include("../includes/funciones.php");        
    ?>
    <style>
            @media only screen and (max-width: 700px) {
                /* Centrar el breadcrumb */
                .breadcrumb {
                    text-align: center;
                }
              
                /* Estilos para el desplegable que incluye todos los filtros */
                 #divfiltros select {
                    display: block;
                    margin: 10px auto; 
                } 

                /* Estilos para la tabla */
                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                td, th {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                } 

                #divfiltros {
                    display: none; 
                }

                /* Ocultar filtros */
                /* #fbuscador, #filtrarpoblacion, #fsector, #filtrarValidacion {
                    display: none;
                } */
        }
    </style>
            
    <?php if ($_SESSION['tipoUsuario']!="administrador") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>


</head>


<body>
    <?php
        include("../includes/cabecera_registrado.php"); 
    ?> <!-- Inclusión de un archivo PHP para la cabecera -->

    <div>
        <?php 
            $max_filas_por_pagina = 4; 
            
        ?>
        <!-- ISSET -->
            <?php
                // Manejo de formularios POST y llamadas a funciones PHP según acciones
                if (isset($_POST["validar"])) {
                    $id = $_POST["id_usuario"];
                    validarregistro($conexion, $id);
                }
                if (isset($_POST["borrar"])) {
                    $id = $_POST["id_usuario"];
                    // confirmar borrado
                    ?>
                    <div id="confirmar">
                        <form action="" method="POST">
                            <label for="">¿Seguro que quieres borrar la empresa?</label>
                            <input type="hidden" name="id_usuario" value="<?php echo $id ?>">
                            <input type="submit" value="no">
                            <input type="submit" value="si" name="si">
                        </form>
                    </div>
                    <?php
                }
                if (isset($_POST["si"])) {
                    $id = $_POST["id_usuario"];
                    borrarregistroempresa($conexion, $id);
                }
                if (isset($_POST["guardar"])) {
                    // Obtén el ID del usuario de la solicitud POST
                    $id = $_POST["id_usuario"];
                    
                    // Obtiene los datos del formulario de edición
                    $id_usuario = $_POST['id_usuario'];
                    $nombre_usuario = $_POST['nombre_usuario'];
                    $nombre_empresa = $_POST['nombre'];
                    $cif = $_POST['cif'];
                    $direccion = $_POST['direccion'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];
                    
                    // Actualiza los datos de la empresa en la base de datos
                    $sqlEmpresa = "UPDATE empresa
                                    SET 
                                    nombre_empresa = :nombre_empresa,
                                    cif = :cif,
                                    direccion = :direccion,
                                    telefono = :telefono
                                    WHERE id_usuario = :id_usuario";
                    $consultaEmpresa = $conexion->prepare($sqlEmpresa);
                    $consultaEmpresa->bindParam(':nombre_empresa', $nombre_empresa);
                    $consultaEmpresa->bindParam(':cif', $cif);
                    $consultaEmpresa->bindParam(':direccion', $direccion);
                    $consultaEmpresa->bindParam(':telefono', $telefono);
                    $consultaEmpresa->bindParam(':id_usuario', $id_usuario);
                    $consultaEmpresa->execute();
                    
                    // Actualiza los datos del usuario en la base de datos
                    $sqlUsuario = "UPDATE usuario
                                    SET 
                                    nombre_usuario = :nombre_usuario,
                                    correo = :correo
                                    WHERE id_usuario = :id_usuario";
                    $consultaUsuario = $conexion->prepare($sqlUsuario);
                    $consultaUsuario->bindParam(':nombre_usuario', $nombre_usuario);
                    $consultaUsuario->bindParam(':correo', $correo);
                    $consultaUsuario->bindParam(':id_usuario', $id_usuario);
                    $consultaUsuario->execute();
                }
            ?>
        <main id="mainlistarempresasadmin">
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
                                <label id="fvlabel">Buscador</label>    
                                <input type="text" name="buscador" id="buscador" placeholder="Buscar empresas">
                            </form>
                        </div>
                    
                        <div id="foblacion">
                            <!-- Formulario de filtrado por población -->
                            <form action="empresas-admin" method="post" id="filtrarpoblacion">
                            
                                <label id="fvlabel"> Filtro de poblacion</label> 
                                <select name="poblacionSelect" id="poblacionSelect">
                                <?php
                                listarProvinciaypoblacion($conexion, "poblacionSelect")
                                ?>
                                </select>
                            </form>
                        </div>

                        <div id="fsector">
                            <label id="fvlabel">Filtro de sector</label> 
                            <!-- Formulario de filtrado por sector -->
                            <form action="empresas-admin" method="post">
                                <select id="sectorSelect" name="sectorSelect">
                                    <?php listarsectores($conexion) ?>
                                </select>
                            </form>
                        </div>

                        <div id="fvalidar">
                            <!-- <label id="fvlabel">Filtro de validacion</label>  -->
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
                    <tr id="encabezado">
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
        </div>
    </main>
    <?php
        include("../includes/footer.php"); 
    ?> <!-- Inclusión de un archivo PHP para el pie de página -->

</body>

<script>
 // Función para abrir un modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Función para cerrar un modal
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

// Obtener el contenedor del modal por su ID
var modalContent = document.getElementById('modal-content');

// Asigna la función openModal al botón de abrir modal para empresas
document.querySelectorAll('[name="editar"]').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Evitar la recarga de la página por defecto
        modalContent.innerHTML = ''; // Limpiar el contenido del modal

        // Crear el botón de cerrar
        var close = document.createElement('span');
        close.className = 'close';
        close.textContent = '\u00D7';  // Código Unicode para la 'x'
        close.onclick = function() {
            cerrarModal('modalEmpresa');
        };

        // Obtener el ID de usuario desde el botón de editar
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
        var inputTelefono = crearInput('text', 'telefono', idUsuario);
        var inputIdUsuario = crearInput('hidden', 'id_usuario', idUsuario);
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

        // Cargar datos en el modal usando la función cargarVentanaModal
        cargarVentanaModal(idUsuario);

        // Mostrar el modal
        openModal('modalEmpresa');
    });
});

// Función para llenar los datos en el modal
function llenarDatosEnModal(datosEmpresa) {
    document.getElementById('inputNombreUsuario').value = datosEmpresa.nombre_usuario;
    document.getElementById('inputNombre').value = datosEmpresa.nombre_empresa;
    document.getElementById('inputCIF').value = datosEmpresa.cif;
    document.getElementById('inputDireccion').value = datosEmpresa.direccion;
    document.getElementById('inputCorreo').value = datosEmpresa.correo;
    document.getElementById('inputTelefono').value = datosEmpresa.telefono;
    document.getElementById('inputIdUsuario').value = datosEmpresa.id_usuario;
}

// Función para cargar datos en el modal
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
