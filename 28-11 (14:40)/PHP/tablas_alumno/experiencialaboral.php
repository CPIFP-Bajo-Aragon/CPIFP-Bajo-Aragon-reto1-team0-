<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesnombre_id.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");
include("../includes/links.php");


$resultados = obtenerExperienciaLaboral($conexion, $id_usuario);
?>

<!-- <?php
    include "../includes/isset/tablas_alumno/experiencialaboral.php";
?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencia Laboral</title>
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
                $id_oficio = $_POST['id_oficio'];
                $nombre_empresa = $_POST['nombre_empresa'];
                $poblacion = $_POST['poblacion'];
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];

                // Antes de la inserción, verificar duplicados
                $check_duplicate_sql = "SELECT COUNT(*) FROM poseer_experiencia WHERE id_usuario = ? AND id_oficio = ?";
                $check_stmt = $conexion->prepare($check_duplicate_sql);
                $check_stmt->execute([$id_usuario, $id_oficio]);
                $count = $check_stmt->fetchColumn();

                if ($count == 0) {
                    // No hay duplicados, proceder con la inserción
                    $insert_sql = "INSERT INTO poseer_experiencia (id_usuario, id_oficio, nombre_empresa, poblacion, fecha_inicio, fecha_fin)
                                VALUES (?, ?, ?, ?, ?, ?)";
                    $insert_stmt = $conexion->prepare($insert_sql);
                    $insert_stmt->execute([$id_usuario, $id_oficio, $nombre_empresa, $poblacion, $fecha_inicio, $fecha_fin]);

                    // Manejar errores o mostrar un mensaje de éxito
                    if ($insert_stmt->rowCount() > 0) {
                        echo "Experiencia laboral guardada con éxito.";
                        $resultados = obtenerExperienciaLaboral($conexion, $id_usuario); // Actualizar resultados
                    } else {
                        echo "Error al guardar la experiencia laboral.";
                    }
                } else {
                    echo "Ya existe una experiencia laboral con estos valores.";
                }
            }

            if (isset($_POST['eliminar'])) {
                // Obtener el id de usuario de la sesión actual
                $id_usuario = $_SESSION['id_usuario'];
                
            
                // Recoger los datos del formulario
                $id_oficio = $_POST['id_oficio'];
            
                // Eliminar la experiencia laboral
                $delete_sql = "DELETE FROM poseer_experiencia WHERE id_usuario = ? AND id_oficio = ?";
                $delete_stmt = $conexion->prepare($delete_sql);
                $delete_stmt->execute([$id_usuario, $id_oficio]);
            
                // Manejar errores o mostrar un mensaje de éxito
                if ($delete_stmt->rowCount() > 0) {
                    echo "Experiencia laboral eliminada.";
                    $resultados = obtenerExperienciaLaboral($conexion, $id_usuario); 
                } else {
                    echo "Error al eliminar la experiencia laboral.";
                }
            }

        ?>
     <main id="maindatosacademicos">
        <!-- Navegación de migas de pan -->
        <ul class="breadcrumb">
            <li><a href="pagina-alumno">Menú</a></li>
            <li><a href="datos-academicos-alumno">Datos Académicos</a></li>
            <li>Experiencia Laboral</li>
        </ul>

        <h1 class="titulo">Experiencia Laboral: </h1>
        <div class="botonesAbrirModal">
            <button id="openModalBtn" onclick="openModal('myModalExperiencia')"><i class="fa-solid fa-plus"></i></button>
        </div>

        
        <!-- Ventana Modal INSERTAR EXPERIENCIA -->
        <div id="myModalExperiencia" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('myModalExperiencia')">&times;</span>
                <h2>Añadir Experiencia</h2>

                <!-- Formulario para agregar nueva experiencia -->
                <form action="experiencia-laboral-alumno" method="post">
                    <label for="oficio">Oficio:</label>
                    <select id="id_oficio" name="id_oficio">
                        <?php listaroficios($conexion); ?>
                    </select>

                    <label for="nombre_empresa">Nombre de la Empresa:</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" required>

                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" required>

                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" >

                    <label for="poblacion">Poblacion:</label>
                    <input type="text" id="poblacion" name="poblacion" required>

                    <input type="submit" name="Guardar" value="Guardar">
                </form>
            </div>
        </div>

    <table class="tablasDatosacademicos">                
        <tr>
                    <th>Oficio</th>
                    <th>Nombre de la Empresa</th>
                    <th>Población</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Opciones</th>
                </tr>

                <?php foreach ($resultados as $resultado): ?>
                    <tr>
                        <td><?php echo $resultado['puesto_trabajo']; ?> </td>
                        <td><?php echo $resultado['nombre_empresa']; ?></td>
                        <td><?php echo $resultado['poblacion']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($resultado['fecha_inicio'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($resultado['fecha_fin'])); ?></td>
                        <td>
                            <form action="experiencia-laboral-alumno" method="post">
                                <input type="hidden" name="id_oficio" value="<?php echo $resultado['id_oficio']; ?>">
                                <input type="submit" name="eliminar" value="eliminar">
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
    </main>

    <?php include "../includes/footer.php" ?> 
    <script src="../../JS/tablas_alumno/experiencialaboral.js"></script>
  

</body>
</html>
