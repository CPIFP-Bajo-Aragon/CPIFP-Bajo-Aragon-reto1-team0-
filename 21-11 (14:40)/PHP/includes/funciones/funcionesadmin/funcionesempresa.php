<?php

//Empresas para el admin
    // Función para listar empresas paginadas
    function listarempresas($conexion, $max_filas_por_pagina) {
        $pagina = 1; // Página por defecto.
        if (isset($_POST['pagina'])) {
            $pagina = $_POST['pagina'];
        }
        $inicio = ($pagina - 1) * $max_filas_por_pagina;

        // Consulta para obtener el total de filas
        $sql_total_filas = "SELECT COUNT(*) as total_filas FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario";
        $consulta_total_filas = $conexion->prepare($sql_total_filas);
        $consulta_total_filas->execute();
        $total_filas = $consulta_total_filas->fetchColumn();

        // Consulta paginada para obtener los datos de las empresas
        $sql_empresas = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario LIMIT $inicio, $max_filas_por_pagina;";
        $consulta_empresas = $conexion->prepare($sql_empresas);

        // Ejecuta la consulta paginada
        if ($consulta_empresas->execute()) {
            while ($fila = $consulta_empresas->fetch(PDO::FETCH_OBJ)) {
                // Extrae la información de la empresa
                $id_usuario = $fila->id_usuario;
                $nombre_usuario = $fila->nombre_usuario;
                $nombre = $fila->nombre_empresa;
                $cif = $fila->cif;
                $direccion = $fila->direccion;
                $correo = $fila->correo;
                $telefono = $fila->telefono;
                $validado = $fila->validado;

                // Verifica si la empresa está validada
                if ($validado == "1") {
                    $validado = "validado";
                } else {
                    $validado = "novalidado";
                }

                $id_poblacion = $fila->id_poblacion;
                $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);
                $id_sector = $fila->id_sector;
                $nombre_sector = mostrarsector($conexion, $id_sector);

                // Construye la fila de la tabla
                $tabla = "<tr class='$validado'>";
                $tabla .= "<td> $id_usuario<input type='hidden' name='id_usuario' value='$id_usuario'></td>";
                $tabla .= "<td>$nombre</td>";
                $tabla .= "<td>$nombre_usuario</td>";
                $tabla .= "<td>$direccion</td>";
                $tabla .= "<td>$correo</td>";
                $tabla .= "<td>$telefono</td>";
                $tabla .= "<td>$cif</td>";
                $tabla .= "<td id='$id_poblacion'>$nom_poblacion</td>";
                $tabla .= "<td>$validado</td>";
                $tabla .= "<td id='$id_sector'>$nombre_sector</td>";

                // Verifica si la empresa está validada y muestra los botones correspondientes
                if ($validado == "validado") {
                    $tabla .= "<td>";
                    $tabla .= "<form action='empresas-admin' method='post'>";
                    $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                    // $tabla .= "<input type='submit' value='borrar' name='borrar' id='borrar'>";
                    $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                    // $tabla .= "<input type='submit' value='editar' name='editar' id='editar'>";
                    $tabla .=  "<button type='submit' name='editar' id='editar'><i class='fas fa-pencil-alt'></i></button>";
                    $tabla .= "</form>";
                    $tabla .= "</td>";
                } else {
                    $tabla .= "<td>";
                    $tabla .= "<form action='empresas-admin' method='post'>";
                    $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                    // $tabla .= "<input type='submit' value='validar' name='validar' id='validar'>";
                    $tabla .=  "<button type='submit' name='validar' id='validar'><i class='fas fa-check'></i></button>";
                    // $tabla .= "<input type='submit' value='editar' name='editar' id='editar'>";
                    $tabla .=  "<button type='submit' name='editar' id='editar' ><i class='fas fa-pencil-alt'></i></button>";
                    // $tabla .= "<input type='submit' value='borrar' name='borrar' id='borrar'>";
                    $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash'></i></button>";
                    $tabla .= "</form>";
                    $tabla .= "</td>";
                }

                $tabla .= "</tr>";

                // Muestra la fila en la tabla
                echo $tabla;
            }

            // Llama a la función para mostrar la paginación
            paginar($max_filas_por_pagina, $conexion, $total_filas);
        }
    }
// Función para borrar el registro de una empresa
    function borrarregistroempresa($conexion, $id_usuario){
        try {
            // Intenta eliminar el registro de la tabla 'empresa' usando el ID de usuario
            $sql = "DELETE FROM empresa WHERE id_usuario = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();

            // Intenta eliminar el registro de la tabla 'usuario' usando el ID de usuario
            $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();
        } catch (PDOException $e) {
            // En caso de error, imprime un mensaje de error
            echo "Error: " . $e->getMessage();
        }
    }

//Función para editar el registro de una empresa en la base de datos
function editarregistroempresa($conexion, $id) {
    $resultado = array(); // Array para almacenar los valores

    // Consulta los datos de la empresa a editar
    $sql = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario WHERE usuario.id_usuario = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta y almacena los valores en el array
    if ($consulta->execute()) {
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $resultado['id_usuario'] = $id;
            $resultado['nombre_usuario'] = $fila->nombre_usuario;
            $resultado['nombre'] = $fila->nombre_empresa;
            $resultado['cif'] = $fila->cif;
            $resultado['direccion'] = $fila->direccion;
            $resultado['correo'] = $fila->correo;
            $resultado['poblacion'] = $fila->id_poblacion;
            $resultado['sector'] = $fila->id_sector;
            $resultado['telefono'] = $fila->telefono;
        }
    }

    echo "<script> var datosEmpresa = " . json_encode($resultado) . ";</script>";
}



// function editarregistroempresa($conexion, $id) {

//              // Consulta los datos de la empresa a editar
//              $sql = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario WHERE usuario.id_usuario = :id";
//             $consulta = $conexion->prepare($sql);
//             $consulta->bindParam(':id', $id, PDO::PARAM_INT);

//              // Ejecuta la consulta y muestra el formulario con los datos actuales
//             if ($consulta->execute()) {
//                 while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
//                     $nombre_usuario = $fila->nombre_usuario;
//                     $nombre = $fila->nombre_empresa;
//                     $cif = $fila->cif;
//                     $direccion = $fila->direccion;
//                     $correo = $fila->correo;
//                     $pob=$fila->id_poblacion;
//                     $sec=$fila->id_sector;
//                     $telefono = $fila->telefono;
//                      // Muestra el formulario con los valores actuales

//                     echo "<div class='modal-content'>";
//                     echo "<span class='close' onclick='cerrarModal('modalEmpresa')'>&times;</span>";  
//                     echo "<h2>Editar empresa</h2>";
//                     echo "<form action='empresas-admin' method='POST'>";
//                     echo "<input type='text' name='nombre_usuario' value='$nombre_usuario'>";
//                     echo "<input type='text' name='nombre' value='$nombre'>";
//                     echo "<input type='text' name='cif' value='$cif'>";
//                     echo "<input type='text' name='direccion' value='$direccion'>";
//                     echo "<input type='text' name='correo' value='$correo'>";
//                     echo "<select name='poblacionSelect' id='poblacionSelect'>";
                    
//                     $nombre_poblacion=mostrarPoblacion($conexion, $pob);
//                     echo ("<option value='$pob'> $nombre_poblacion</option>");
//                     listarProvinciaypoblacion($conexion, 'poblacionSelect');
//                     echo "</select>";
//                     echo  "<select name='id_sector'>";
//                         $nombre_sector=mostrarsector($conexion, $sec);
//                         echo ("<option value='$sec'> $nombre_sector</option>");
//                         listarsectores($conexion);
//                     echo "</select>";
//                     echo "<input type='text' name='telefono' value='$telefono'>";
//                     echo "<input type='hidden' name='id_usuario' value='$id'>";
//                     echo "<input type='submit' name='guardar' value='Guardar'>";
//                     echo "</form>";
//                     echo "</div>";
//                 }
//             }
//     }
//Funcion para insertar empresas
    function insertarempresaadmin($conexion){
            $nombre_usuario=$_POST['nombre_usuario'];
            $contrasena=$_POST['contraseña'];
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
            $email=$_POST['emailbtn'];
            $cif=$_POST['cif'];
            $nombre=$_POST['nombre'];
            $direccion=$_POST['direccion'];
            $descripcion=$_POST['descripcion'];
            $telefono=$_POST['telefono'];
            $id_poblacion=$_POST['Selectpoblacion'];
            $id_sector=$_POST['sectorselect'];
            $validado=1;
            $tipo="empresa";
            echo "usu";

            $sql = "INSERT INTO `usuario`( `nombre_usuario`, `password`, `correo`, `validado`, `tipo`) VALUES ('$nombre_usuario','$hashed_password','$email','$validado','$tipo');";
            
            $consulta = $conexion->prepare($sql);
          
            if($consulta->execute()){
                
            }else{
               
            }
            
            // Obtener el ID generado automáticamente
                $id_insertado = $conexion->lastInsertId();


            $sql="INSERT INTO empresa(`id_usuario`, `cif`, `nombre_empresa`, `direccion`, `descripcion`, `telefono`, `id_poblacion`, `id_sector`) VALUES ('$id_insertado','$cif','$nombre','$direccion','$descripcion','$telefono','$id_poblacion','$id_sector');";
            $consulta = $conexion->prepare($sql);
         
            if($consulta->execute()){
                
            }else{
               
            }
        }
    


?>