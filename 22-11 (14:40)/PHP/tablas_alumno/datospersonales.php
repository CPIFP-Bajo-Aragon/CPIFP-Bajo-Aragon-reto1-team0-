<?php 
    include("../includes/conexion.php");
    include("../login/verificarLogin.php");
    include("../includes/funciones.php");

    editarDatosPersonales($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="../../CSS/alumno.css">
    
    <?php include("../includes/cabecera_registrado.php"); ?> 
</head>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Datos Personales</li>
    </ul> 

    <h1 class="titulo">MODIFICAR DATOS: </h1>  

    <div class="todo">
            <form action="datos-personales-alumno" method="post" class="formulariodatos">
               
                <input type="text" name="id_usuario" placeholder="ID" value="<?php echo $mostrar['id_usuario'] ?>" hidden>
                <label for="carnet">Nombre de usuario:</label>
                <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" value="<?php echo $mostrar['nombre_usuario'] ?>">
                
                <label for="carnet">Correo:</label>
                <input type="text" name="correo" placeholder="Correo Electrónico" value="<?php echo $mostrar['correo'] ?>">

                <label for="carnet">Nombre:</label>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $mostrar['nombre'] ?>">

                <label for="carnet">Apellidos:</label>
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $mostrar['apellidos'] ?>">

                <label for="carnet">DNI/NIE:</label>
                <input type="text" name="DNI" placeholder="DNI" value="<?php echo $mostrar['dni'] ?>">
                
                <label for="carnet">Telefono:</label>
                <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo $mostrar['telefono'] ?>">
<!-- 
                <label for="carnet">Fecha Nacimiento:</label>
                <input type="date" name="fecha_nacim" placeholder="Fecha Nacimiento" value="<?php echo $mostrar['fecha_nacim'] ?>"> -->

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
                <!-- <input type="text" name="actitud" placeholder="Actitud" value="<?php echo $mostrar['actitudes'] ?>"> -->
                <textarea name="actitud" placeholder="Actitud" rows="<?php echo $filas; ?>"><?php echo $mostrar['actitudes'] ?></textarea>
                <label for="carnet">Aptitudes:</label>
                <!-- <input type="text" name="aptitud" placeholder="Aptitud" value="<?php echo $mostrar['aptitudes'] ?>"> -->
                <textarea name="aptitud" placeholder="Aptitud" rows="<?php echo $filass; ?>"><?php echo $mostrar['aptitudes'] ?></textarea>
                
                <label for='poblacion'>Población</label>
                <select name="poblacionSelect" id="poblacionSelect">
                <?php
                    $id_poblacion= $mostrar['id_poblacion'];
                    $nombre_poblacion=mostrarPoblacion($conexion, $id_poblacion);
                    echo ("<option value='$id_poblacion'> $nombre_poblacion</option>");
                    
                    listarProvinciaypoblacion($conexion, 'poblacionSelect');
                ?>
                </select>
                
               

                <input type="submit" name="Guardar" value="Guardar Cambios">
            </form>
    </div>
    

    <?php include "../includes/footer.php" ?> 

</body>
</html>
<script src="../../JS/tablas_alumno/datospersonales.js"></script>