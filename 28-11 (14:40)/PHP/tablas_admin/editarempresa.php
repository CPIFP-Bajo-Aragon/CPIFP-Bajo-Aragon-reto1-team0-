<?php
    include("../includes/conexion.php");

    // Verifica si se ha proporcionado el parámetro 'id_usuario' en la URL
    if(isset($_GET['id_usuario'])){
        $resultado = array(); // Array para almacenar los valores
        $id=$_GET['id_usuario'];

        // Consulta los datos de la empresa a editar mediante una JOIN
        $sql = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario WHERE usuario.id_usuario = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecuta la consulta y almacena los valores en el array
        if ($consulta->execute()) {
            // Recorre los resultados y almacena la información en el array
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $resultado['id_usuario'] = $id;
                $resultado['nombre_usuario'] = $fila->nombre_usuario;
                $resultado['nombre_empresa'] = $fila->nombre_empresa;
                $resultado['cif'] = $fila->cif;
                $resultado['direccion'] = $fila->direccion;
                $resultado['correo'] = $fila->correo;
                $resultado['telefono'] = $fila->telefono;
                $resultado['id_poblacion'] = $fila->id_poblacion;
                $resultado['id_sector'] = $fila->id_sector;

            }

            // Convierte el array a formato JSON y lo muestra
            echo json_encode($resultado);
        } else {
            // Muestra un mensaje de error si no se pudieron obtener los datos
            echo json_encode(array('error' => 'No se pudieron obtener los datos.'));
        }
    }
?>
