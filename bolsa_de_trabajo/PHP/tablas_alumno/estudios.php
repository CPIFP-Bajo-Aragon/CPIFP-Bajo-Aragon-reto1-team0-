<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");
include("../includes/links.php");


// Obtener el id de usuario de la sesión actual
$id_usuario = $_SESSION['id_usuario'];

// Obtener los estudios del usuario
$resultados = obtenerEstudios($conexion, $id_usuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudios</title>
    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-xj5db7sm9hRH59F79L/D9b2bpzePLB6+LwH8QKOz7O1l51x1+iq0znMmU+2HWraB" crossorigin="anonymous">
 
</head>

<body>
<?php include("../includes/cabecera_registrado.php"); ?>

<main id="maindatosacademicos">
<?php if ($_SESSION['tipoUsuario']!="alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>

    <!-- ISSET -->
        <?php

            // Verificar si se envió el formulario para agregar un nuevo estudio
            if (isset($_POST['Guardar'])) {
                // Recoger los datos del formulario
                $id_estudio = $_POST['id_estudio'];
                $id_instituto = $_POST['id_instituto'];

                // Verificar si ya existe un registro con los mismos valores
                $check_duplicate_sql = "SELECT COUNT(*) FROM tener_estudio WHERE id_estudio = ? AND id_instituto = ? AND  id_usuario = ?";
                $check_stmt = $conexion->prepare($check_duplicate_sql);
                $check_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);
                $count = $check_stmt->fetchColumn();

                if ($count == 0) {
                    // No hay duplicados, proceder con la inserción
                    $insert_sql = "INSERT INTO tener_estudio (id_estudio, id_instituto, id_usuario)
                                VALUES (?, ?, ?)";
                    $insert_stmt = $conexion->prepare($insert_sql);
                    $insert_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);

                    // Manejar errores o mostrar un mensaje de éxito
                    if ($insert_stmt->rowCount() > 0) {

                        // Obtener los estudios actualizados después de la inserción
                        $resultados = obtenerEstudios($conexion, $id_usuario);
                    } 
                } 
            }

            if (isset($_POST['eliminar'])) {
                // Obtener el id de usuario de la sesión actual
                $id_usuario = $_SESSION['id_usuario'];
                

                // Recoger los datos del formulario
                $id_estudio = $_POST['id_estudio'];
                $id_instituto = $_POST['id_instituto'];


                // Eliminar Estudio
                $delete_sql = "DELETE FROM tener_estudio WHERE id_estudio = ? AND id_instituto = ? AND id_usuario = ?";
                $delete_stmt = $conexion->prepare($delete_sql);
                $delete_stmt->execute([$id_estudio, $id_instituto, $id_usuario]);

                // Manejar errores o mostrar un mensaje de éxito
                if ($delete_stmt->rowCount() > 0) {
                    $resultados = obtenerEstudios($conexion, $id_usuario);
                } 
            }
        ?>


    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li><a href="datos-academicos-alumno">Datos Académicos</a></li>
        <li>Estudios</li>
    </ul>

   
    <h1 class="titulo">ESTUDIOS </h1>
    <div class="botonesAbrirModal">
        <button id="openModalBtn" onclick="openModal('myModalExperiencia')"><i class="fa-solid fa-plus"></i></button>
    </div>

    <div id="myModalExperiencia" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModalExperiencia')">&times;</span>
            <h2>Añadir Estudio</h2>
            <!-- Formulario para agregar nuevo estudio -->
            <form action="estudios-alumno" method="post">
                <label for="id_estudio">Estudio:</label>
                <select id="id_estudio" name="id_estudio">
                <?php listarestudios($conexion); ?>
                </select>

                <label for="id_instituto">Instituto:</label>
                <select id="id_instituto" name="id_instituto">
                <?php listarinstitutos($conexion); ?>
                </select>

                <input type="submit" class="btnmodal" name="Guardar" value="Guardar">
            </form>
        </div>
    </div>
    
    <div class="tabla-contenedorEstudios">
        <table class="tablasEstudios" id="tablasalumnos">
            <tr>
                <th>Estudio</th>
                <th>Instituto</th>
                <th>Opciones</th>

            </tr>

            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo $resultado['nombre_estudio']; ?></td>
                    <td><?php echo $resultado['nombre_instituto']; ?> </td>

                    <td>
                        <form action="estudios-alumno" method="post">
                            <input type="hidden" name="id_estudio" value="<?php echo $resultado['id_estudio']; ?>">
                            <input type="hidden" name="id_instituto" value="<?php echo $resultado['id_instituto']; ?>">
                            <!-- <input type="submit" name="eliminar" class="eliminardedealumno" value="eliminar"> -->
                            <button type="submit" name="eliminar" class="eliminardedealumno">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>

    <!-- Ventana Modal INSERTAR ESTUDIO -->
    
   

    <?php include "../includes/footer.php" ?>

  <script src="../../JS/tablas_alumno/estudios.js"></script>

</body>

</html>
