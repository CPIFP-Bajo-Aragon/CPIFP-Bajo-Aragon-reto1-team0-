<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilo para ocultar la ventana modal inicialmente */
        #myModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Contenido de tu página -->
    

    <!-- Ventana modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeChatModal()">&times;</span>
            <div id="modal-content">
                <div id="filtroadminchat">
                    <div id="opcionesadminchat">
                        <div id="empresachat">
                            <table id="tablaempesachat" border="1">
                                <tr>
                                    <td>Nombre</td>
                                    <td>Direccion</td>
                                    <td>Correo</td>
                                    <td>Telefono</td>
                                    <td>Poblacion</td>
                                    <td>Sector</td>
                                </tr>
                                <?php
                                    listarempresachat($conexion);
                                ?>
                            </table>
                        </div>
                        <div id="alumnochat">
                            <table id="tablachatalumno">
                            <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Teléfono</th>
                                            <th>Carnet de Conducir</th>
                                            <th>Actitudes</th>
                                            <th>Aptitudes</th>
                                            <th>Población</th>
                                            <th>Opciones</th>
                                        </tr>
                                        <?php
                                           listaralumnochat($conexion);
                                        ?>
                            </table>
                        </div>
                        <div id="adminchat">
                            <table id="tablachatadmin">
                                <tr>
                                                <th>Nombre</th>
                                                <th>Apellidos</th>
                                                <th>Fecha de Nacimiento</th>
                                                <th>Teléfono</th>
                                                <th>Carnet de Conducir</th>
                                                <th>Actitudes</th>
                                                <th>Aptitudes</th>
                                                <th>Población</th>
                                                <th>Opciones</th>
                                            </tr>
                                            <?php
                                            listaradminchat($conexion);
                                            ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Añade este script al final de tu archivo HTML -->
    <script>
        // Función para abrir la ventana modal
        function openChatModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        }

        // Función para cerrar la ventana modal
        function closeChatModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
