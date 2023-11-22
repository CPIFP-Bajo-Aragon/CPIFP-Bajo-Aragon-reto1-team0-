<?php
    include("../includes/conexion.php");


    if(isset($_GET['id_usuario'])){
    $resultado = array(); // Array para almacenar los valores
    $id=$_GET['id_usuario'];
    // Consulta los datos de la empresa a editar
    $sql = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario WHERE usuario.id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            
            $resultado['id_usuario'] = $id;
            $resultado['nombre_usuario'] = $fila->nombre_usuario;
            $resultado['nombre_empresa'] = $fila->nombre_empresa;
            $resultado['cif'] = $fila->cif;
            $resultado['direccion'] = $fila->direccion;
            $resultado['correo'] = $fila->correo;
            $resultado['telefono'] = $fila->telefono;
            
        }
         echo json_encode($resultado);
        
    }else{
        echo json_encode(array('error' => 'No se pudieron obtener los datos.'));
    }
    }
?>