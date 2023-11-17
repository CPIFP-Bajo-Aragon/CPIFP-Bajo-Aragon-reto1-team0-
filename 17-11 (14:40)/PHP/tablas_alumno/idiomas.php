<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");

include("../includes/funciones/funcionselects.php");

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
                <label for="id_estudio">Idioma:</label>
                <select id="id_estudio" name="id_idioma">
                    <?php listaridioma($conexion); ?>
                </select>

                <label for="id_instituto">Nivel:</label>
                <select id="id_instituto" name="id_nivel">
                    <?php listarnivel($conexion); ?>
                </select>

                <input type="submit" name="Guardar" value="Guardar">
            </form>
        </div>
    </div>
    <main id="main"> 
        <table class="tabla1">
            <tr>
                
                <th>Idioma</th>
                <th>Nivel</th>
                
            </tr>
            
            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo $resultado['nombre']; ?></td>
                    <td><?php echo $resultado['nivel']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <!-- Ventana Modal INSERTAR EXPERIENCIA -->
    

    <?php include "../includes/footer.php" ?> 
    <?php
    if (isset($_POST['Guardar'])) {
        // Obtener el id de usuario de la sesión actual
        $id_usuario = $_SESSION['id_usuario'];
    
        // Recoger los datos del formulario
       
        $id_idioma= $_POST['id_idioma'];
        $id_usuario= $_POST['id_usuario'];
        $id_nivel = $_POST['id_nivel'];
    
        // Insertar datos en la tabla "hablar_idioma"
        $insert_sql = "INSERT INTO habla_idioma (id_idioma, id_usuario, id_nivel)
                       VALUES (?, ?, ?)";
        $insert_stmt = $conexion->prepare($insert_sql);
        $insert_stmt->execute([$id_idioma, $id_nivel]);
    
        // Manejar errores o mostrar un mensaje de éxito
        if ($insert_stmt->rowCount() > 0) {
            echo "Experiencia laboral guardada con éxito.";
        } else {
            echo "Error al guardar la experiencia laboral.";
        }
    } ?>

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
        document.getElementById('myModalIdioma').getElementsByClassName('close')[0].addEventListener('click', function() {
            closeModal('myModalIdioma');
        });
    </script>

</body>
</html>