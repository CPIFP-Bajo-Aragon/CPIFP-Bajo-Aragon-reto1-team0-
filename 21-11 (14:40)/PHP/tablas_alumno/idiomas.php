<?php
include("../includes/conexion.php");
include("../login/verificarLogin.php");
include("../includes/funciones/funcionesalumnos.php");
include("../includes/funciones/funcionselects.php");

$resultados = obtenerIdiomas($conexion, $id_usuario);
?>

<?php
    include "../includes/isset/tablas_alumno/idiomas.php";
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
                <select id="id_idioma" name="id_idioma">
                    <?php listaridioma($conexion); ?>
                </select>

                <label for="id_instituto">Nivel:</label>
                <select id="id_nivel" name="id_nivel">
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
    <script src="../../JS/tablas_alumno/idiomas.js"></script>

</body>
</html>
