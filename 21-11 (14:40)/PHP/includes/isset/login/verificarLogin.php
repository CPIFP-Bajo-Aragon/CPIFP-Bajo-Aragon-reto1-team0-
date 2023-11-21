<?php
if (isset($_POST['Acceder']) ) {
    $nombre_usuario = $_POST['usuario'];
    $password = $_POST['clave'];

    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?"; 
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $nombre_usuario);
    $consulta->execute();
    $numFilas = $consulta->rowCount();

    if ($numFilas == 1) {
        $fila = $consulta->fetch(PDO::FETCH_OBJ);
        $hashed_password = $fila->password;

        // Verificar la contraseña ingresada con la contraseña almacenada
        if (password_verify($password, $hashed_password)) {
            $tipoUsuario = $fila->tipo;
            $id_usuario = $fila->id_usuario;
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            $_SESSION['usuario'] = $id_usuario;

            switch ($tipoUsuario) {
                case "administrador":
                    header("location: pagina-admin");
                    break;

                case "alumno":
                    header("location: pagina-alumno");
                    break;

                case "empresa":
                    header("location: pagina-empresa");
                    break;

                default:
                    echo "Tipo de usuario no reconocido";
            }
        } else {
            $mensaje = "ERROR DE AUTENTIFICACIÓN";
            echo $mensaje;
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