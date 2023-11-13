<?php 
    include("../includes/conexion.php");
    include("../login/verificarLogin.php");

    // Obtener el id de usuario de la sesión actual
    $id_usuario = $_SESSION['id_usuario'];

    // Consultar la base de datos para obtener los datos del usuario y del alumno mediante un JOIN
    $sql = "SELECT usuario.*, alumno.* 
            FROM usuario 
            LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
            WHERE usuario.id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Manejar errores si la consulta no es exitosa
        echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
    }

    // Verificar si el formulario se ha enviado
    if (isset($_POST['Guardar'])) {
        // Recoger los datos del formulario
        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['DNI'];
        $telefono = $_POST['telefono'];
        $carnet_conducir = $_POST['carnet'];
        $actitudes = $_POST['actitud'];
        $aptitudes = $_POST['aptitud'];
        $id_poblacion = $_POST['poblacion'];

        // Actualizar los datos en la base de datos
        $update_sql = "UPDATE usuario 
                       SET nombre_usuario = ?, password = ?, correo = ?, nombre = ? 
                       WHERE id_usuario = ?";
        $update_stmt = $conexion->prepare($update_sql);
        $update_stmt->execute([$nombre_usuario, $password, $correo, $nombre, $id_usuario]);

        $update_alumno_sql = "UPDATE alumno 
                              SET apellidos = ?, dni = ?,  nombre = ? ,telefono = ?, carnet_conducir = ?, 
                                  actitudes = ?, aptitudes = ?, id_poblacion = ? 
                              WHERE id_usuario = ?";
        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
        $update_alumno_stmt->execute([$apellidos, $dni, $nombre, $telefono, $carnet_conducir, $actitudes, $aptitudes, $id_poblacion, $id_usuario]);

        // Manejar errores o mostrar un mensaje de éxito
        if ($update_stmt->rowCount() > 0 || $update_alumno_stmt->rowCount() > 0) {
            echo "Actualización exitosa";
            header("location: datospersonales.php");
        } else {
            echo "Error en la actualización";
        }
    }
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

            <input type="submit" name="Guardar" value="Guardar">
        </form>
    </div>
</body>
</html>