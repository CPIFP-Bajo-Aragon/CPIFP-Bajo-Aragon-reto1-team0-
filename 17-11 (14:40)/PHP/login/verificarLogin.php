

<?php

//Comprobar si ya hay una sesion abierta
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include "../includes/conexion.php";

$mensaje = "";

if (isset($_POST['Acceder'])) {
    $nombre_usuario = $_POST['usuario'];
    $password = $_POST['clave']; 
    

    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ? and password = ?"; 
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $nombre_usuario);
    $consulta->bindParam(2, $password);
    $consulta->execute();
    $numFilas = $consulta->rowCount();

    if ($numFilas == 1) {
        $fila = $consulta->fetch(PDO::FETCH_OBJ);
        $tipoUsuario = $fila->tipo;
        $id_usuario = $fila->id_usuario;
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['tipoUsuario'] = $tipoUsuario;
        $_SESSION['usuario'] = $id_usuario;
      
        if ($tipoUsuario === "administrador") {
            header("location: pagina-admin");


        } elseif ($tipoUsuario === "alumno") {
            header("location: pagina-alumno");


        } elseif ($tipoUsuario === "empresa") {
            header("location: pagina-empresa");

        } else {
            echo "Tipo de usuario no reconocido";
        }

    } else {
        $mensaje = "ERROR DE AUTENTIFICACIÓN";
        echo $mensaje;
    }
}


if (isset($_POST['logout'])) {

session_destroy();
header('Location: inicio');
exit(); 
}


?>
