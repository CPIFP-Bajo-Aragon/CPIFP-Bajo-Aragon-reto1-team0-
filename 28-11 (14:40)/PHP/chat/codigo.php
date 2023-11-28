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
    <link rel="stylesheet" href="../../CSS/index.css">

    <link rel="stylesheet" href="../../CSS/index.css">
    <style>
        /* Estilos para la ventana modal */
            .modalchat {
                display: none; /* Inicialmente oculta la ventana modal */
                position: fixed; /* Fija la posición de la ventana modal en relación con la ventana del navegador */
                top: 0; /* Coloca la ventana modal en la parte superior del viewport */
                left: 0; /* Coloca la ventana modal en la parte izquierda del viewport */
                width: 100%; /* Ocupa el 100% del ancho del viewport */
                height: 100%; /* Ocupa el 100% de la altura del viewport */
                background-color: rgba(0, 0, 0, 0.7); /* Fondo oscuro semitransparente */
                /* El valor 'rgba(0, 0, 0, 0.7)' representa un color negro con una opacidad del 70% */
            }


            .modal-contentchat {
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

            

    </style>
</head>
<body>
    <?php
        include("../includes/cabecera_registrado.php");
    ?>
    <main>
        <?php
            $tipo=$_SESSION['tipoUsuario'];
        ?>
                <ul class="breadcrumb">
                    <?php
                        if($tipo==="alumno"){
                    ?>
                            <li><a href="pagina-alumno">Menú Alumno</a></li>
                    <?php
                        }else if($tipo==="administrador"){
                    ?>
                
                            <li><a href="pagina-admin">Menú Admin</a></li>
                    <?php
                        }else{
                    ?>            
                            <li><a href="pagina-empresa">Menú Empresa</a></li>
                    <?php
                        }
                    ?>

                    <li>Menú chat</li>
                </ul>

                


        <!-- BOTONES PARA LAS VENTANAS MODALES -->
        <div id="empresachat">
            <!-- Botón para abrir la ventana modal de empresas -->
            <button onclick="AbrirModal('myModalchatempresa')">Abrir Empresa</button>
        </div>
        <br>
        <div id="alumnochat">
            <!-- Botón para abrir la ventana modal de alumnos -->
            <button onclick="AbrirModal('myModalchatalumno')">Abrir Alumno</button>
        </div>

        <!-- VENTANAS MODALES -->
        <!-- Ventana modal de empresas -->
        <div id="myModalchatempresa" class="modalchat">
            <div class="modal-contentchat">
                <!-- Botón de cerrar la ventana modal -->
                <button class="close" onclick="CerrarModal('myModalchatempresa')">&times;</button>
                <!-- Tabla para mostrar información de empresas -->
                <table id="tablaempesachat">
                    <?php listarempresachat($conexion); ?>
                </table>
            </div>
        </div>

        <!-- Ventana modal de alumnos -->
        <div id="myModalchatalumno" class="modalchat">
            <div class="modal-contentchat">
                <!-- Botón de cerrar la ventana modal -->
                <button class="close" onclick="CerrarModal('myModalchatalumno')">&times;</button>
                <!-- Tabla para mostrar información de alumnos -->
                <table id="tablaalumnochat">
                    <?php listaralumnochat($conexion); ?>
                </table>
            </div>
        </div>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
</body>
<script>
    function AbrirModal(modal) {
        // Obtener el elemento de la ventana modal de alumnos y establecer su estilo para mostrarlo
        document.getElementById(modal).style.display = 'block';
    }
    function CerrarModal(modal) {
        // Obtener el elemento de la ventana modal de alumnos y establecer su estilo para mostrarlo
        document.getElementById(modal).style.display = 'none';
    }
</script>
</html>
