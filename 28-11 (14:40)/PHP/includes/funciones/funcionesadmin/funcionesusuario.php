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
        $coche = isset($_POST['cochepropio']) ? $_POST['cochepropio'] : 0; // Asumiendo 0 si no está marcada
        $carnet_conducir = isset($_POST['carnetConducir']) ? $_POST['carnetConducir'] : 0;
        $actitudes = $_POST["actitudes"];
        $aptitudes = $_POST["aptitudes"];
        $id_poblacion = $_POST["Selectpoblacion"];
    
        if($carnet_conducir==="si"){
                $carnet_conducir=1;
        }else{
                $carnet_conducir=0;
        }
        if($coche==="si"){
                $coche=1;
        }else{
                $coche=0;
        }
        $fecha_nacim = strtotime($fecha_nacim);
        $fecha_nacim = date("Y-m-d", $fecha_nacim);
        $id_insertado = $conexion->lastInsertId();
        // Insert data into 'alumno' table
        $sql = "INSERT INTO `alumno`(`id_usuario`, `dni`, `nombre`, `apellidos`, `fecha_nacim`, `telefono`, `carnet_conducir`, `actitudes`, `aptitudes`, `id_poblacion`, vehiculo_propio) VALUES ('$id_insertado', '$dni', '$nombre', '$apellidos', '$fecha_nacim', '$telefono', '$carnet_conducir', '$actitudes', '$aptitudes', '$id_poblacion', $coche)";
        $consulta = $conexion->prepare($sql);
        if($consulta->execute()){}
}
?>