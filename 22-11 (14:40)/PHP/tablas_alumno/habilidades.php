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

                    <?php
                        // Coge el texto que hay va a mostar en los textArea
                        $longitud_texto = strlen($mostrar['actitudes']);
                        $longitud_text = strlen($mostrar['aptitudes']);

                        // Longitud de texto por línea que va a mostrar
                        $longitud_promedio_linea = 50;

                        // Calcula la cantidad aproximada de filas necesarias para mostrar el código
                        $filas = ceil($longitud_texto / $longitud_promedio_linea);
                        $filass = ceil($longitud_text / $longitud_promedio_linea);
                    ?>

                <label for="carnet">Actitudes:</label>
                <textarea name="actitud" placeholder="Actitud" rows="<?php echo $filas; ?>"><?php echo $mostrar['actitudes'] ?></textarea>
                <label for="carnet">Aptitudes:</label>
                <textarea name="aptitud" placeholder="Aptitud" rows="<?php echo $filass; ?>"><?php echo $mostrar['aptitudes'] ?></textarea>
                
                <input type="submit" name="Guardar" value="Guardar Cambios" style="margin-top: 20px;">
            </form>
  
</body>

<?php include("../includes/footer.php");  ?>
<script src="../../JS/tablas_alumno/habilidades.js"></script>
</html>

