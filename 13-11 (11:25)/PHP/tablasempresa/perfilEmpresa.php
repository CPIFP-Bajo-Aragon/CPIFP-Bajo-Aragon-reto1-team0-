<?php
    session_start();
    include("../includes/conexion.php");
    include("../includes/funciones.php");
    $id_usuario=$_SESSION['id_usuario'];

    $sqlEmpresa="SELECT * FROM empresa WHERE id_usuario=$id_usuario";
    $stmt = $conexion->prepare($sqlEmpresa);
    
        // Ejecuta la consulta
    if ($stmt->execute()) {

        // Itera a través de las empresas y genera opciones HTML
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $nombre = $fila->nombre_empresa;
            $direccion = $fila->direccion;
            $descripcion = $fila->descripcion;
            $telefono= $fila->telefono;
            $id_poblacion=$fila->id_poblacion;
            $id_sector=$fila->id_sector;
        }

        echo($id_poblacion);
    }

    // Guarda el nombre de la población 
    $sqlPoblacion="SELECT nombre FROM poblacion as p JOIN empresa as e ON e.id_poblacion=p.id_poblacion WHERE e.id_usuario=$id_usuario";
    $consultaPoblacion = $conexion->prepare($sqlPoblacion);
    $consultaPoblacion->execute();
    $nombrePoblacion = $consultaPoblacion->fetchColumn();

    // Guarda el nombre del sector 
    $sqlSector="SELECT nombre_sector FROM sector as s JOIN empresa as e ON e.id_sector=s.id_sector WHERE e.id_usuario=$id_usuario";
    $consultaSector = $conexion->prepare($sqlSector);
    $consultaSector->execute();
    $nombreSector = $consultaSector->fetchColumn();
    echo($nombreSector);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <STYle>
   

    

        form {
            max-width: 700px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
           
        }

        h1 {
            text-align: center;
            color: #3498db; 
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9; 
        }

    

    
    </STYle>
</head>
<body>
    <header>
        <?php include "../includes/cabecera_alumno.php" ?> 
        <h3>EDITAR PERFIL </h3>
    </header>

    <div>

    <h1>MODIFICAR DATOS: </h1>  
        <form action="datospersonales.php" method="post">
   
            <input type="text" name="id_usuario" placeholder="ID" value="<?php echo $nombre ?>">
            <!-- <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" value="<?php echo $mostrar['nombre_usuario'] ?>">
            <input type="text" name="password" placeholder="Contraseña" value="<?php echo $mostrar['password'] ?>">
            <input type="text" name="correo" placeholder="Correo Electrónico" value="<?php echo $mostrar['correo'] ?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $mostrar['nombre'] ?>">


            <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $mostrar['apellidos'] ?>">
            <input type="text" name="DNI" placeholder="DNI" value="<?php echo $mostrar['dni'] ?>">
            <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo $mostrar['telefono'] ?>">
            <input type="text" name="carnet" placeholder="Carnet" value="<?php echo $mostrar['carnet_conducir'] ?>">
            <input type="text" name="actitud" placeholder="Actitud" value="<?php echo $mostrar['actitudes'] ?>">
            <input type="text" name="aptitud" placeholder="Aptitud" value="<?php echo $mostrar['aptitudes'] ?>">
            <input type="text" name="poblacion" placeholder="Población" value="<?php echo $mostrar['id_poblacion'] ?>"> -->

            <input type="submit" name="Guardar" value="Guardar">
        </form>
    </div>
</body>
</html>