<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");
include("../includes/links.php");


$resultados = obtenerIdiomas($conexion, $id_usuario);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idiomas</title>
    <link rel="stylesheet" href="../../CSS/tabla.css">
    <link rel="stylesheet" href="../../CSS/index.css">
    <?php include("../includes/cabecera_registrado.php"); ?>
</head>

<body>
<?php if ($_SESSION['tipoUsuario']!="alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>

    <!-- ISSET -->
        <?php
            if (isset($_POST['Guardar'])) {
                // Obtener el id de usuario de la sesión actual
                $id_usuario = $_SESSION['id_usuario'];
            
                // Recoger los datos del formulario
                $id_idioma = $_POST['id_idioma'];
                $id_nivel = $_POST['id_nivel'];
            
                // Verificar si ya existe un registro con los mismos valores
                $check_duplicate_sql = "SELECT COUNT(*) FROM habla_idioma WHERE id_usuario = ? AND id_idioma = ? AND id_nivel = ?";
                $check_stmt = $conexion->prepare($check_duplicate_sql);
                $check_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
                $count = $check_stmt->fetchColumn();
            
                if ($count == 0) {
                    // No hay duplicados, proceder con la inserción
                    $insert_sql = "INSERT INTO habla_idioma (id_usuario, id_idioma, id_nivel)
                    VALUES (?, ?, ?)";
                    $insert_stmt = $conexion->prepare($insert_sql);
                    $insert_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
            
                    // Manejar errores o mostrar un mensaje de éxito
                    if ($insert_stmt->rowCount() > 0) {
                        echo "Idioma guardado con éxito.";
            
                        // Obtener los idiomas actualizados después de la inserción
                        $resultados = obtenerIdiomas($conexion, $id_usuario);
                    } else {
                        echo "Error al guardar el idioma.";
                    }
                } else {
                    echo "El idioma ya existe.";
                }
            }

            if (isset($_POST['eliminar'])) {
                // Obtener el id de usuario de la sesión actual
                $id_usuario = $_SESSION['id_usuario'];
                
            
                // Recoger los datos del formulario
                $id_idioma = $_POST['id_idioma'];
                $id_nivel = $_POST['id_nivel'];
            
                // Eliminar Estudio
                $delete_sql = "DELETE FROM habla_idioma WHERE id_usuario = ? AND id_idioma = ? AND id_nivel = ?";
                $delete_stmt = $conexion->prepare($delete_sql);
                $delete_stmt->execute([$id_usuario, $id_idioma, $id_nivel]);
            
                // Manejar errores o mostrar un mensaje de éxito
                if ($delete_stmt->rowCount() > 0) {
                    echo "Idioma eliminado.";
                    $resultados = obtenerIdiomas($conexion, $id_usuario);
                } else {
                    echo "Error al eliminar Idioma.";
                }
            }
        ?>

<main id="maindatosacademicos">
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li><a href="datos-academicos-alumno">Datos Académicos</a></li>
        <li>Idiomas</li>
    </ul> 
    
    <h1 class="titulo">Idiomas: </h1>
    <div class="botonesAbrirModal">
        <button id="openModalBtn" onclick="openModal('myModalExperiencia')"><i class="fa-solid fa-plus"></i></button>
    </div>

    <div id="myModalExperiencia" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModalExperiencia')">&times;</span>
            <h2>Añadir Idioma</h2>

            <!-- Formulario para agregar nuevo idioma -->
            <form action="idiomas-alumno" method="post">
                <label for="id_idioma">Idioma:</label>
                <select id="id_idioma" name="id_idioma">
                    <?php listaridioma($conexion); ?>
                </select>

                <label for="id_nivel">Nivel:</label>
                <select id="id_nivel" name="id_nivel">
                    <?php listarnivel($conexion); ?>
                </select>

                <input type="submit" name="Guardar" value="Guardar">
            </form>
        </div>
    </div>
    
  
    <table class="tablasDatosacademicos">
            <tr>
                <th>Idioma</th>
                <th>Nivel</th>
                <th>Opciones</th>

            </tr>
            
            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo $resultado['nombre']; ?></td>
                    <td><?php echo $resultado['nivel']; ?></td>

                    <td>
                        <form action="idiomas-alumno" method="post">
                            <input type="hidden" name="id_idioma" value="<?php echo $resultado['id_idioma']; ?>">
                            <input type="hidden" name="id_nivel" value="<?php echo $resultado['id_nivel']; ?>">
                            <input type="submit" name="eliminar" value="eliminar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <!-- Ventana Modal INSERTAR EXPERIENCIA -->
    
    <?php include "../includes/footer.php" ?> 
    <script src="../../JS/tablas_alumno/idiomas.js"></script>

</body>
</html>
