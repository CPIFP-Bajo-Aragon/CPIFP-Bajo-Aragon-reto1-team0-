<?php
    // Incluye los archivos de conexión y funciones
    include("../includes/conexion.php");
    include("../includes/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos para la ventana modal */
            .modal {
                display: none; /* Inicialmente oculta la ventana modal */
                position: fixed; /* Fija la posición de la ventana modal en relación con la ventana del navegador */
                top: 0; /* Coloca la ventana modal en la parte superior del viewport */
                left: 0; /* Coloca la ventana modal en la parte izquierda del viewport */
                width: 100%; /* Ocupa el 100% del ancho del viewport */
                height: 100%; /* Ocupa el 100% de la altura del viewport */
                background-color: rgba(0, 0, 0, 0.7); /* Fondo oscuro semitransparente */
                /* El valor 'rgba(0, 0, 0, 0.7)' representa un color negro con una opacidad del 70% */
            }


            .modal-content {
                position: absolute; /* Posición absoluta dentro de la ventana modal */
                top: 50%; /* Coloca la ventana modal en el centro vertical */
                left: 50%; /* Coloca la ventana modal en el centro horizontal */
                transform: translate(-50%, -50%); /* Centra la ventana modal */
                padding: 20px; /* Añade espacio interno al contenido de la ventana modal */
                background-color: #fff; /* Fondo blanco para el contenido de la ventana modal */
                border: 1px solid #ccc; /* Borde delgado alrededor de la ventana modal */
                border-radius: 5px; /* Bordes redondeados */
                width: 60%; /* Ancho de la ventana modal */
            }

            /* Estilo para el botón de cerrar */
            .close {
                cursor: pointer; /* Cambia el cursor a una mano cuando pasa sobre el botón de cerrar */
                position: absolute; /* Posición absoluta dentro de la ventana modal */
                top: 10px; /* Coloca el botón de cerrar 10px desde la parte superior de la ventana modal */
                right: 15px; /* Coloca el botón de cerrar 15px desde el borde derecho de la ventana modal */
                font-size: 20px; /* Tamaño de fuente del botón de cerrar */
                color: #333; /* Color del texto del botón de cerrar */
            }

    </style>
</head>
<body>
    <!-- ISSET -->
    <?php
    ?>

    <!-- BOTONES PARA LAS VENTANAS MODALES -->
    <div id="empresachat">
        <!-- Botón para abrir la ventana modal de empresas -->
        <button onclick="Abrirmodal('myModal')">Abrir Empresa</button>
    </div>
    <br>
    <div id="alumnochat">
        <!-- Botón para abrir la ventana modal de alumnos -->
        <button onclick="Abrirmodal('myModalA')">Abrir Alumno</button>
    </div>

    <!-- VENTANAS MODALES -->
    <!-- Ventana modal de empresas -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- Botón de cerrar la ventana modal -->
            <span class="close" onclick="cerrarModal()">&times;</span>
            <!-- Tabla para mostrar información de empresas -->
            <table id="tablaempesachat">
                <?php listarempresachat($conexion); ?>
            </table>
        </div>
    </div>

    <!-- Ventana modal de alumnos -->
    <div id="myModalA" class="modal">
        <div class="modal-content">
            <!-- Botón de cerrar la ventana modal -->
            <span class="close" onclick="cerrarModalA()">&times;</span>
            <!-- Tabla para mostrar información de alumnos -->
            <table id="tablaalumnochat">
                <?php listaralumnochat($conexion); ?>
            </table>
        </div>
    </div>
</body>
</html>
<script src="../../JS/chat/codigo.js"></script>
