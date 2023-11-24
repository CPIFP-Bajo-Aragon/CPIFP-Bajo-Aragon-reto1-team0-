<?php
function insertalumnoadmin($conexion){

        $nombre_usuario = $_POST["nombre_usuario"];
        $password = $_POST["contraseña"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $correo = $_POST["emailbtn"];
        $validado = $_POST["validado"];
        $tipo = $_POST["tipo"];

        // Insert data into 'usuario' table
        $sql = "INSERT INTO `usuario`(`nombre_usuario`, `password`, `correo`, `validado`, `tipo`) VALUES ('$nombre_usuario', '$hashed_password', '$correo', '$validado', '$tipo')";
        $consulta = $conexion->prepare($sql);
        
        if($consulta->execute()){}
    
        $dni = $_POST["dni"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["Apellido"];
        $telefono = $_POST["telefono"];
        $fecha_nacim=$_POST["Fecha_nacimiento"];
        $carnet_conducir = isset($_POST["carnetConducir"]) ? 1 : 0;
        $actitudes = $_POST["actitudes"];
        $aptitudes = $_POST["aptitudes"];
        $id_poblacion = $_POST["Selectpoblacion"];
    
        
        $id_insertado = $conexion->lastInsertId();
        // Insert data into 'alumno' table
        $sql = "INSERT INTO `alumno`(`id_usuario`, `dni`, `nombre`, `apellidos`, `fecha_nacim`, `telefono`, `carnet_conducir`, `actitudes`, `aptitudes`, `id_poblacion`) VALUES ('$id_insertado', '$dni', '$nombre', '$apellidos', '$fecha_nacim', '$telefono', '$carnet_conducir', '$actitudes', '$aptitudes', '$id_poblacion')";
        $consulta = $conexion->prepare($sql);
        if($consulta->execute()){}
}
?>