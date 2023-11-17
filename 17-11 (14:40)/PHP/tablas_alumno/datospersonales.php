<?php 
    include("../includes/conexion.php");
    include("../login/verificarLogin.php");
    include("../includes/funciones/funcionesalumnos.php");


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
    <script>

</script>
</head>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Datos Personales</li>
    </ul> 


    <div>
        <h1 class="titulo">MODIFICAR DATOS: </h1>  
            <form action="datos-personales-alumno" method="post" class="formulariodatos">
    
                <input type="text" name="id_usuario" placeholder="ID" value="<?php echo $mostrar['id_usuario'] ?>" hidden>
                <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" value="<?php echo $mostrar['nombre_usuario'] ?>">
                <input type="text" name="password" placeholder="Contraseña" value="<?php echo $mostrar['password'] ?>">
                <input type="text" name="correo" placeholder="Correo Electrónico" value="<?php echo $mostrar['correo'] ?>">
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $mostrar['nombre'] ?>">


                <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $mostrar['apellidos'] ?>">
                <input type="text" name="DNI" placeholder="DNI" value="<?php echo $mostrar['dni'] ?>">
                <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo $mostrar['telefono'] ?>">

                
                <input type="text" name="carnet" placeholder="Carnet" value="<?php echo $mostrar['carnet_conducir'] ?>">
                <input type="text" name="actitud" placeholder="Actitud" value="<?php echo $mostrar['actitudes'] ?>">
                <input type="text" name="aptitud" placeholder="Aptitud" value="<?php echo $mostrar['aptitudes'] ?>">
                <input type="text" name="poblacion" placeholder="Población" value="<?php echo $mostrar['id_poblacion'] ?>">

                <input type="submit" name="Guardar" value="Guardar Cambios">
            </form>
    </div>
    

    <?php include "../includes/footer.php" ?> 

</body>
</html>