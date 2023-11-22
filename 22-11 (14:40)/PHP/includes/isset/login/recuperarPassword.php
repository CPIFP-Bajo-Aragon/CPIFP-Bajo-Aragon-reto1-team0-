<?php
if (isset($_POST['cambiarPassword'])) {
    $email = $_POST['correo'];
    $usuario = $_POST['usuario']; 
    $contra = $_POST['NewPasword'];
    $contra2 = $_POST['OtraVezNP'];

   
    $sqlCheckUser = "SELECT * FROM `usuario` WHERE correo=:email AND nombre_usuario=:usuario";
    $consultaCheckUser = $conexion->prepare($sqlCheckUser);
    $consultaCheckUser->bindParam(':email', $email);
    $consultaCheckUser->bindParam(':usuario', $usuario);
    $consultaCheckUser->execute();
    
    if ($consultaCheckUser->rowCount() > 0) {
    
        if ($contra === $contra2) {
            $hashed_password = password_hash($contra, PASSWORD_DEFAULT);
            $sql = "UPDATE `usuario` SET `password`=:contra WHERE correo=:email";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':contra', $hashed_password);
            $consulta->bindParam(':email', $email);

            if ($consulta->execute()) {
                echo "Contraseña cambiada exitosamente.";
            } else {
                echo "Error al cambiar la contraseña.";
            }
        } else {
            echo "Las contraseñas no coinciden.";
        }
    } else {
        echo "Nombre de usuario y/o correo electrónico no encontrados.";
    }
}

?>