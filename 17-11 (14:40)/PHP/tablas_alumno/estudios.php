<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");

$resultados = obtenerEstudios($conexion, $id_usuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudios</title>
    <link rel="stylesheet" href="../../CSS/tabla.css">
    <link rel="stylesheet" href="../../CSS/index.css">
    <?php include("../includes/cabecera_registrado.php"); ?>
</head>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li><a href="datos-academicos-alumno">Datos Académicos</a></li>
        <li>Estudios</li>
    </ul>

    <h1 class="titulo">ESTUDIOS: </h1>
    <div class="botonesAbrirModal">
        <button id="openModalBtn" onclick="openModal('myModalExperiencia')"><i class="fa-solid fa-plus"></i></button>
    </div>

    <div id="myModalExperiencia" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModalExperiencia')">&times;</span>
            <h2>Añadir Estudio</h2>
            <!-- Formulario para agregar nuevo estudio -->
            <form action="estudios.php" method="post">
                <label for="id_estudio">Estudio:</label>
                <select id="id_estudio" name="id_estudio">
                <?php listarestudios($conexion); ?>
                </select>

                <label for="id_instituto">Instituto:</label>
                <select id="id_instituto" name="id_instituto">
                <?php listarinstitutos($conexion); ?>
                </select>

                <input type="submit" name="Guardar" value="Guardar">
            </form>
        </div>
    </div>
    <main id="main">
        <table class="tabla1">
            <tr>
                <th>Estudio</th>
                <th>Instituto</th>
            </tr>

            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo $resultado['nombre_estudio']; ?></td>
                    <td><?php echo $resultado['nombre_instituto']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <!-- Ventana Modal INSERTAR ESTUDIO -->
    
   

    <?php include "../includes/footer.php" ?>

    <script>
        // Función para abrir la ventana modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'block';
        }

        // Función para cerrar la ventana modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'none';
        }

        // Asigna la función closeModal al span de cerrar modal para estudio
        document.getElementById('myModalEstudio').getElementsByClassName('close')[0].addEventListener('click', function () {
            closeModal('myModalEstudio');
        });
    </script>

</body>

</html>