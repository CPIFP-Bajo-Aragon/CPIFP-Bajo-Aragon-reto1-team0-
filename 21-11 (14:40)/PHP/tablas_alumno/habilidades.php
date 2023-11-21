<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Habilidades Alumno</title>
    <?php include("../includes/cabecera_registrado.php"); ?> 
</head>
<?php 
    include("../includes/conexion.php");
    include("../login/verificarLogin.php");
    include("../includes/funciones.php");

    editarHabilidades($conexion);
?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Habilidades</li>
    </ul> 

    <!-- <button onclick="guardarActitudes()" class="btnSaveHabilidades"><i class="fa-regular fa-floppy-disk"></i></button> -->

    <div>
        <h1 class="titulo">Añadir o modificar datos: </h1>  
            <form action="habilidades-alumno" method="post" class="formulariodatos">
               
                

                <label for="carnet">Carnet de Conducir:</label>
                    <select name="carnet">
                        <?php if ($mostrar['carnet_conducir'] == 1): ?>
                            <option value="1" selected>Sí</option>
                            <option value="0">No</option>
                        <?php else: ?>
                            <option value="1">Sí</option>
                            <option value="0" selected>No</option>
                        <?php endif; ?>
                    </select>
                <label for="carnet">Actitudes:</label>
                <input type="text" name="actitud" placeholder="Actitud" value="<?php echo $mostrar['actitudes'] ?>">
                <label for="carnet">Aptitudes:</label>
                <input type="text" name="aptitud" placeholder="Aptitud" value="<?php echo $mostrar['aptitudes'] ?>">
                
               

                <input type="submit" name="Guardar" value="Guardar Cambios">
            </form>
  
</body>

<?php include("../includes/footer.php");  ?>
<script src="../../JS/tablas_alumno/habilidades.js"></script>
</html>

