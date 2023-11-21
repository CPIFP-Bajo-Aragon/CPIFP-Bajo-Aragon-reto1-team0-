<?php
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
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 60%;
        }

        /* Estilo para el botón de cerrar */
        .close {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- BOTONES PARA LAS VENTANAS MODALES -->
    <div id="empresachat">
        <button onclick="abrirModal()">Abrir Empresa</button>
    </div>
    <br>
    <div id="alumnochat">
        <button onclick="abrirModalA()">Abrir Alumno</button>
    </div>
    
    <!-- VENTANAS MODALES -->
        <!-- Ventana modal de empresas -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal()">&times;</span>
                    <table id="tablaempesachat">
                        <?php listarempresachat($conexion); ?>
                    </table>
                </div>
            </div>

        <!-- Ventana modal de alumnos -->
            <div id="myModalA" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModalA()">&times;</span>
                    <table id="tablaalumnochat">
                        <?php listaralumnochat($conexion); ?>
                    </table>
                </div>
            </div>

</body>
</html>

<script src="../../JS/chat/codigo.js"></script>