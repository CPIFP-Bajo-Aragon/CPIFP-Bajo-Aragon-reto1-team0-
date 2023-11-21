<?php
 if (isset($_POST['mensaje_send'])) {
    $mensaje = $_POST['mensaje'];
    $id_usuario = $_SESSION['id_usuario'];
    $id_receptor = $_POST['id_receptor'];
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    $sql = "INSERT INTO `mensaje`(`id_usuario`, `receptor`, `mensaje`, `fecha`, `hora`) VALUES (:id_usuario, :id_receptor, :mensaje, :fecha, :hora)";

    $consulta = $conexion->prepare($sql);

    // Bind de los parámetros
    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $consulta->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
    $consulta->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
    $consulta->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $consulta->bindParam(':hora', $hora, PDO::PARAM_STR);

    // Ejecuta la consulta
    $consulta->execute();
}
?>