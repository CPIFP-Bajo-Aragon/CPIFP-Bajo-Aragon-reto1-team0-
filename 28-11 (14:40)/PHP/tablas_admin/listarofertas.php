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
    <link rel="stylesheet" href="../../CSS/index.css">
<?php
include ("../includes/links.php")
?>
    <title>Ofertas de Trabajo</title>

    <style>
        @media only screen and (max-width: 700px) {
            /* Estilos para el breadcrumb */
            .breadcrumb {
                text-align: center;
            }

            /* Estilos para el título en dispositivos pequeños */
            .tituloOFERTAadmin {
                text-align: center;
            }

            /* Estilos para los filtros */
            #filtros {
                display: flex;
                flex-direction: column;
                width: 80vw;
            }

            /* Ajuste del espacio entre los elementos de los filtros */
            #filtros > div {
                margin-bottom: 10px; /* Puedes ajustar este valor según tus necesidades */
            }

            /* Estilos para la tabla */
            /* #tabla table {
                width: 100%;
                overflow-x: auto;
            }

            #tabla table th {
                display: none;
            }

            #tabla table td {
                display: block;
                text-align: left;
            } */
        }

    </style>
    
<script src="../../JS/tablas_admin/listarofertas.js"></script>
</head>



<body>
    <?php
        // Inclusión de la cabecera de la página desde otro archivo PHP
        include("../includes/cabecera_registrado.php");
    ?>
    <div>
        <?php if ($_SESSION['tipoUsuario']!="administrador") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
        }?>
        <!-- ISSET -->
            <?php
                // Manejo de formularios POST para borrar y editar registros de ofertas de trabajo
                if (isset($_POST["activar"])) {
                    $id = $_POST["id_oferta"];
                    // Prepara la conofertas-adminsulta SQL para actualizar el campo 'validado' a 1
                    $sql = "UPDATE oferta_trabajo SET activa = 1 WHERE id_oferta = :id_oferta";


                    // Prepara la consulta utilizando la conexión proporcionada
                    $consulta = $conexion->prepare($sql);


                    // Asocia el valor de :id_usuario con el parámetro proporcionado
                    $consulta->bindParam(':id_oferta', $id);


                    // Ejecuta la consulta para actualizar el estado de validación
                    $consulta->execute();
                }
                if (isset($_POST["desactivar"])) {
                    $id = $_POST["id_oferta"];
                    // Prepara la consulta SQL para actualizar el campo 'validado' a 1
                    $sql = "UPDATE oferta_trabajo SET activa = 0 WHERE id_oferta = :id_oferta";


                    // Prepara la consulta utilizando la conexión proporcionada
                    $consulta = $conexion->prepare($sql);


                    // Asocia el valor de :id_usuario con el parámetro proporcionado
                    $consulta->bindParam(':id_oferta', $id);


                    // Ejecuta la consulta para actualizar el estado de validación
                    $consulta->execute();
                }
                if (isset($_POST["validar"])) {
                    $id = $_POST["id_oferta"];
                    // Prepara la consulta SQL para actualizar el campo 'validado' a 1
                    $sql = "UPDATE oferta_trabajo SET validada = 1 WHERE id_oferta = :id_oferta";


                    // Prepara la consulta utilizando la conexión proporcionada
                    $consulta = $conexion->prepare($sql);


                    // Asocia el valor de :id_usuario con el parámetro proporcionado
                    $consulta->bindParam(':id_oferta', $id);


                    // Ejecuta la consulta para actualizar el estado de validación
                    $consulta->execute();
                }
                
                // Verificar si el formulario se ha enviado
                if (isset($_POST['guardar'])) {
                        // Recoger los datos del formulario
                        $titulo = $_POST['titulo'];
                        $descripcion = $_POST['descripcion'];
                        $duracion_contrato = $_POST['duracion'];
                        
                        if(isset($_POST['carnet'])){
                            $carnet = $_POST['carnet'];
                        }else{
                            $carnet=0;
                        }
                        $id_oferta = $_POST['id_oferta'];

                        // Actualizar los datos en la base de datos
                        $update_empresa_sql = "UPDATE oferta_trabajo 
                                                SET titulo = ?, descripcion_oferta = ?,  duracion_contrato = ? ,carnet_conducir = ?
                                                WHERE id_oferta = ?";
                        $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
                        $update_empresa_stmt->bindValue(1, $titulo);
                        $update_empresa_stmt->bindValue(2, $descripcion);
                        $update_empresa_stmt->bindValue(3, $duracion_contrato);
                        $update_empresa_stmt->bindValue(4, $carnet);
                        $update_empresa_stmt->bindValue(5, $id_oferta);

                        $update_empresa_stmt->execute();
                }  
            ?>
        

        <main id="listarofertasadmin">
                
        <!-- Navegación de migas de pan -->
        <ul class="breadcrumb">
                <li><a href="pagina-admin">Menú</a></li>
                <li>Gestión Ofertas</li>
            </ul> 



            <div>
                <h1 class="tituloOFERTAadmin">GESTIÓN DE OFERTAS</h1>
            </div>

            <!-- Filtros para búsqueda y filtrado -->
                <?php $max_filas_por_pagina = 4; ?>

                <div id="filtros">
                    <div id="fbusqueda">
                        <!-- Input para buscar por título -->
                        <input type="text" id="filtroTitulo" placeholder="Buscador por Título">
                    </div>
                    <div id="fpoblacion">
                        <select name="poblacionSelect" id="poblacionSelect">
                                <?php
                                listarProvinciaypoblacion($conexion, $select_name)
                                ?>
                                </select>
                    </div>
                    <div id="meses">
                        <!-- Filtro para la duración del contrato -->
                        <label for="">Duración del Contrato:</label>
                        <input type="range" id="filtroDuracionContrato" min="0" max="24" step="1" value="0">
                        <span id="duracionContratoLabel">Cualquier duración</span>
                    </div>  
                    <div id="conducir">
                        <!-- Filtros para requerir carnet de conducir -->
                        Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
                        <br>
                        Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
                        <br>
                        Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
                    </div>
                </div>
            
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
            
        </main>
    </div>
    <!-- Inclusión del pie de página desde otro archivo PHP -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>

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
            cerrarModal('modalOfertas');
        };

        // Obtener el ID de usuario desde el botón de editar
        var idUsuario = this.getAttribute('id').replace('editar_', '');

        // Crear el título del modal
        var h2 = document.createElement('h2');
        h2.textContent = 'Editar oferta';

        // Crear el formulario
        var form = document.createElement('form');
        form.action = 'ofertas-admin';
        form.method = 'POST';

        // Crear e insertar los elementos de entrada en el formulario
        var inputTitulo = crearInput('text', 'titulo', idUsuario);
        var inputDescripccion = crearInput('text', 'descripcion', idUsuario);
        var inputDuracion = crearInput('text', 'duracion', idUsuario);
        var inputCarnet = crearInput('checkbox', 'carnet', idUsuario);
        var inputID = crearInput('hidden', 'id_oferta', idUsuario);
        var inputSubmit = document.createElement('input');
        inputSubmit.type = 'submit';
        inputSubmit.name = 'guardar';
        inputSubmit.value = 'Guardar';

        // Asignar identificadores únicos a los elementos
        inputTitulo.id = 'inputTitulo';
        inputDescripccion.id = 'inputDescripccion';
        inputDuracion.id = 'inputDuracion';
        inputCarnet.id = 'inputCarnet';

        // Agregar elementos al formulario
        form.appendChild(inputTitulo);
        form.appendChild(inputDescripccion);
        form.appendChild(inputDuracion);
        form.appendChild(inputCarnet);
        form.appendChild(inputID);
        form.appendChild(inputSubmit);

        // Agregar elementos al contenedor del modal
        modalContent.appendChild(close);
        modalContent.appendChild(h2);
        modalContent.appendChild(form);

        // Cargar datos en el modal usando la función cargarVentanaModal
        cargarVentanaModal(idUsuario);

        // Mostrar el modal
        openModal('modalOfertas');
    });
});

// Función para llenar los datos en el modal
function llenarDatosEnModal(modalOfertas) {
    document.getElementById('inputTitulo').value = modalOfertas.titulo;
    document.getElementById('inputDescripccion').value = modalOfertas.descripcion_oferta;
    document.getElementById('inputDuracion').value = modalOfertas.duracion_contrato;
    if (modalOfertas.carnet_conducir == 0) {
        // Si carnet_conducir es 0, el checkbox no está marcado
        document.getElementById('inputCarnet').checked = false;
    } else {
        // Si carnet_conducir no es 0, el checkbox está marcado
        document.getElementById('inputCarnet').checked = true;
    }
}

// Función para cargar datos en el modal
function cargarVentanaModal(idUsuario) {
    // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
    fetch('/PHP/tablas_admin/editarofertas.php?id_oferta=' + idUsuario)
        .then(response => response.json())
        .then(modalOfertas => {
            // Pinta los datos en la modal
            llenarDatosEnModal(modalOfertas);

            // Muestra la modal
            openModal('modalOfertas');
        });
}
</script>

