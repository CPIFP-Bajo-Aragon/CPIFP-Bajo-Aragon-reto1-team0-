<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Oferta</title>
    <link rel="stylesheet" href="../../CSS/index.css">
</head>

    
    <?php include("../includes/cabecera_registrado.php"); ?> 
    <?php include("../includes/conexion.php"); ?>
    <?php include("../includes/funciones/funcionselects.php"); ?>

<body>
    <?php if ($_SESSION['tipoUsuario']!="empresa") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
    }?>
    
    <!-- Navegación de migas de pan -->

    <h1 class="titulo">Formulario de Oferta de Trabajo</h1>
    <div class="todo">
        <div id="myModalOfertas" class="modal" style="display: block;">
        <div class="modal-content">
        <span class="close" onclick="closeModal('myModalAlumnos')">&times;</span>        
        <h2>Nueva oferta trabajo</h2>
        <form action="formulario-oferta" method="POST" class="form">

            <label>INFORMACIÓN DE LA OFERTA</label>

            <label class="label" for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br><br>

            <label for="puesto">Puesto:</label>
            <select id="puesto" name="puesto">
            <?php listaroficios($conexion); ?>
            </select><br><br>

            <label for="poblacion">Población:</label>
            <select id="id_poblacion" name="id_poblacion">
            <?php listarProvinciaypoblacion($conexion, "id_poblacion"); ?>
            </select><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion_oferta" name="descripcion_oferta" rows="10" cols="50"></textarea><br><br> 

            <label for="duracion_contrato">Duración del Contrato:</label>
            <input type="text" id="duracion_contrato" name="duracion_contrato"><br><br>

            <label>REQUISITOS DEL ALUMNO</label>

            <label for="aptitudes">Aptitudes:</label>
            <textarea id="aptitud" name="aptitud" rows="10" cols="50"></textarea><br><br>
            
            <label for="estudios">Estudios Requeridos:</label>
            <select id="estudios" name="estudios">
            <?php listarestudios($conexion); ?>
            </select><br><br>
    

            <label for="experiencia">Experiencia Requerida:</label>
            <input type="text" id="experiencia" name="experiencia" ><br><br>
            
            <div id="idiomas">
                <div class="idioma">
                    <label for="idioma">Idioma Requerido:</label>
                    <select name="idiomas[]">
                        <?php listaridioma($conexion); ?>
                    </select>
                    <label for="nivel_idioma">Nivel de Idioma:</label>
                    <select name="niveles_idioma[]">
                        <?php listarnivel($conexion); ?>
                    </select>
                    <button type="button" onclick="eliminarElemento('idioma')">Eliminar Idioma</button>
                </div>
            </div>

            <button type="button" onclick="agregarElemento('idiomas')">Agregar Idioma</button>

            <label for="poblacion">Población:</label>
            <select id="id_poblacion" name="id_poblacion">
            <?php listarProvinciaypoblacion($conexion, "id_poblacion"); ?>
            </select><br><br>

            <label>¿Carnet de Conducir?</label>
            <input type="radio" id="carnet_si" name="carnet_conducir" value="1"> Sí
            <input type="radio" id="carnet_no" name="carnet_conducir" value="0"> No<br><br>

            <input type="submit" value="Enviar" name="Enviar" id="publicarOferta" >
        </form>
        </div>
        </div>
    </div>
</body>

<?php include("../includes/footer.php");  ?>

</html>
<script src="../../JS/tablasempresa/publicaroferta.js"></script>