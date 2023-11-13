<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Oferta</title>
</head>
<body>
    
    <?php include("../includes/cabecera_registrado.php"); ?> 
    <?php include("../includes/conexion.php"); ?>
    <?php include("../includes/funciones.php"); ?>



    <h2>Formulario de Oferta de Trabajo</h2>
    <form action="procesarFormularioOferta.php" method="POST">

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="puesto">Puesto:</label>
        <select id="puesto" name="puesto">
        <?php listaroficios($conexion); ?>
        </select><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion_oferta" name="descripcion_oferta" rows="10" cols="50"></textarea><br><br>

        <label for="aptitudes">Aptitudes:</label>
        <textarea id="aptitud" name="aptitud" rows="10" cols="50"></textarea><br><br>
        
        <label for="estudios">Estudios Requeridos:</label>
        <select id="estudios" name="estudios">
        <?php listarestudios($conexion); ?>
        </select><br><br>

        <label for="experiencia">Experiencia Requerida:</label>
        <input type="text" id="experiencia" name="experiencia" required><br><br>
        

        <label for="idioma">Idioma Requerido:</label>
        <select id="idioma" name="idioma">
        <?php listaridioma($conexion); ?>
        </select><br><br>

        <label for="nivel_idioma">Nivel de Idioma:</label>
        <select id="nivel_idioma" name="nivel_idioma">
        <?php listarnivel($conexion); ?>
        </select><br><br>

        <label for="duracion_contrato">Duración del Contrato:</label>
        <input type="text" id="duracion_contrato" name="duracion_contrato"><br><br>

        <label for="poblacion">Población:</label>
       
        <select id="id_poblacion" name="id_poblacion">
        <?php listarProvinciaypoblacion($conexion, "id_poblacion"); ?>
        </select><br><br>

        <label>¿Carnet de Conducir?</label>
        <input type="radio" id="carnet_si" name="carnet_conducir" value="1"> Sí
        <input type="radio" id="carnet_no" name="carnet_conducir" value="0"> No<br><br>

        <label for="oferta">Insertar Oferta:</label>
        <input type="submit" value="Enviar" name="Enviar">

    </form>

</body>


</html>