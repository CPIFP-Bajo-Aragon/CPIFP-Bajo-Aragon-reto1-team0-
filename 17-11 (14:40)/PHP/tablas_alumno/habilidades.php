<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Habilidades Alumno</title>
</head>
<?php 
    include("../includes/funciones/funcionesalumnos.php"); 
    include("../includes/cabecera_registrado.php"); 
?>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Habilidades</li>
    </ul> 

    <!-- <button onclick="guardarActitudes()" class="btnSaveHabilidades"><i class="fa-regular fa-floppy-disk"></i></button> -->

    <div class="habilidades">
        <h2 class="titulosHabilidades">ACTITUDES</h2>
        <div>
            <textarea id="actitudes" name="actitudes" rows="6" style="width: 100%; border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['actitudes']; ?></textarea>
        </div>
    
        <h2 class="titulosHabilidades">APTITUDES</h2>
        <div>
            <textarea id="aptitudes" name="aptitudes" rows="6" style="width: 100%; border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['aptitudes']; ?></textarea>

        </div>

        <h2 class="titulosHabilidades">Carnet Conducir</h2>
        <div>
            <input type="checkbox" id="carnet" name="carnet" <?php echo ($mostrar['carnet_conducir'] == 1) ? 'checked' : ''; ?>>
            <label for="carnet">
                <p class="parrafoHabilidades"><?php echo ($mostrar['carnet_conducir'] == 1) ? 'Posee Carnet de Conducir' : 'No Posee Carnet de Conducir'; ?></p>
            </label>
        </div>
        
    </div>

 
</body>

<?php include("../includes/footer.php");  ?>
</html>

<script>
    function guardarHabilidades(){}
</script>