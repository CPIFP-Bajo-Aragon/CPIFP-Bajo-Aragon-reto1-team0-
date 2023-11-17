<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");

$resultados = obtenerExperienciaLaboral($conexion, $id_usuario);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencia Laboral</title>
    <link rel="stylesheet" href="../../CSS/tabla.css">
    <link rel="stylesheet" href="../../CSS/index.css">
    <?php include("../includes/cabecera_registrado.php"); ?>
</head>

<body>

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li><a href="datos-academicos-alumno">Datos Académicos</a></li>
        <li>Experiencia Laboral</li>
    </ul> 
    
    <h1 class="titulo">EXPERIENCIA LABORAL: </h1>  
    <div class="botonesAbrirModal">
        <button id="openModalBtn" onclick="openModal('myModalExperiencia')"><i class="fa-solid fa-plus"></i></button>
    </div>

    <main id="main"> 
        <table class="tabla1">
            <tr>
                <th>Oficio</th>
                <th>Nombre de la Empresa</th>
                <th>Población</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
            </tr>
            
            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo $resultado['puesto_trabajo']; ?></td>
                    <td><?php echo $resultado['nombre_empresa']; ?></td> 
                    <td><?php echo $resultado['nombre_poblacion']; ?></td>
                    <td><?php echo $resultado['fecha_inicio']; ?></td>
                    <td><?php echo $resultado['fecha_fin']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <!-- Ventana Modal INSERTAR EXPERIENCIA -->
    <div id="myModalExperiencia" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModalExperiencia')">&times;</span>
            <h2>Añadir Experiencia</h2>

            <!-- Formulario para agregar nueva experiencia -->
            <form action="experiencialaboral.php" method="post">
            <label for="oficio">Oficio:</label>
            <select id="id_estudio" name="id_estudio">
                <?php listaroficios($conexion); ?>
            </select>

                <label for="nombre_empresa">Nombre de la Empresa:</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa" required>

                <label for="poblacion">Población:</label>
                <form action="listarofertas.php" method="post" id="filtrarpoblacion">
                    <select name="poblacion" id="poblacion">
                    <?php    
                    listarProvinciaypoblacion($conexion, "poblacion")
                    ?>    
                    </select>
                    <input type="hidden" id="poblacionHidden" name="poblacionHidden" value="">
                  
                </form>

                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>

                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>

                <input type="submit" name="Guardar" value="Guardar">

            </form>
        </div>
    </div>
<?php 
if (isset($_POST['Guardar'])) {
    // Obtener el id de usuario de la sesión actual
    $id_usuario = $_SESSION['id_usuario'];

    // Recoger los datos del formulario
    $id_estudio = $_POST['id_estudio'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $poblacion = $_POST['poblacionHidden'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Insertar datos en la tabla "poseer_experiencia"
    $insert_sql = "INSERT INTO poseer_experiencia (id_usuario, id_estudio, nombre_empresa, poblacion, fecha_inicio, fecha_fin)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conexion->prepare($insert_sql);
    $insert_stmt->execute([$id_usuario, $id_estudio, $nombre_empresa, $poblacion, $fecha_inicio, $fecha_fin]);

    // Manejar errores o mostrar un mensaje de éxito
    if ($insert_stmt->rowCount() > 0) {
        echo "Experiencia laboral guardada con éxito.";
    } else {
        echo "Error al guardar la experiencia laboral.";
    }
} ?>
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

        // Asigna la función closeModal al span de cerrar modal para experiencia
        document.getElementById('myModalExperiencia').getElementsByClassName('close')[0].addEventListener('click', function() {
            closeModal('myModalExperiencia');
        });
    </script>

</body>
</html>