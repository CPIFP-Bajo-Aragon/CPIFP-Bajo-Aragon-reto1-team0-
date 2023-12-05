<?php
// Comprobación y inicio de la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}

// Inclusión del archivo de conexión a la base de datos
include "../includes/conexion.php";

// Mensaje de error inicializado
$mensaje = "";

/* ISSET: Comprobación de la existencia de variables o formularios enviados */
if (isset($_POST['Acceder'])) {
    // Obtención de datos del formulario
    $nombre_usuario = $_POST['usuario'];
    $password = $_POST['clave'];

    // Consulta para obtener la información del usuario por nombre de usuario
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?"; 
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $nombre_usuario);
    $consulta->execute();
    $numFilas = $consulta->rowCount();

    // Verificación del resultado de la consulta
    if ($numFilas == 1) {
        $fila = $consulta->fetch(PDO::FETCH_OBJ);
        $hashed_password = $fila->password;
        $validado = $fila->validado;

        // Verificar la contraseña ingresada con la contraseña almacenada en forma segura
        if (password_verify($password, $hashed_password)) {
            // Obtener información del usuario y almacenarla en variables de sesión
            if($validado==1){
                $tipoUsuario = $fila->tipo;
                $id_usuario = $fila->id_usuario;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['tipoUsuario'] = $tipoUsuario;
                $_SESSION['usuario'] = $id_usuario;

                // Redireccionar según el tipo de usuario
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
            }else {
                $mensaje = "NO ESTAS VALIDADO!";
                $_SESSION['mensaje'] = $mensaje;
                header("location: inicio-sesion");
                }
        } else {
        $mensaje = "ERROR DE AUTENTIFICACIÓN!";
        $_SESSION['mensaje'] = $mensaje;
        header("location: inicio-sesion");
        }
        
    }
    else {
        $mensaje = "ERROR DE AUTENTIFICACIÓN!";
        $_SESSION['mensaje'] = $mensaje;
        header("location: inicio-sesion");
        }
}

// Proceso de logout
if (isset($_POST['logout'])) {
    // Destruir la sesión y redirigir a la página de inicio
    session_destroy();
    header('Location: inicio');
    exit();
}
?>
