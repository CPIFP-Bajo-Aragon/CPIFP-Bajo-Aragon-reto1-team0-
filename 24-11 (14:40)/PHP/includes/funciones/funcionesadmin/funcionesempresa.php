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
                    $tabla .= "<td>";
                        $tabla .= "<form action='empresas-admin' method='post'>";
                        $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                        $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                        $tabla .= "<button type='submit' name='editar' id='editar_$id_usuario'><i class='fas fa-pencil-alt'></i></button>";
                            if ($validado == "validado") {
                            
                            } else {
                                $tabla .=  "<button type='submit' name='validar' id='validar'><i class='fas fa-check'></i></button>";
                            }
                        $tabla .= "</form>";
                        $tabla .= "</td>";
                    
                    $tabla .= "</tr>";

                    // Muestra la fila en la tabla
                    echo $tabla;
                }

                // Llama a la función para mostrar la paginación
                echo ('<form action="empresas-admin" method="post">');
                    paginar($max_filas_por_pagina, $conexion, $total_filas);
                echo ('</form>');
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

    //Funcion para insertar empresas
        function insertarempresaadmin($conexion) {
            // Recopilar datos del formulario
                $nombre_usuario = $_POST['nombre_usuario'];
                $contrasena = $_POST['contraseña'];
                $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT); // Hash de la contraseña para almacenarla de forma segura
                $email = $_POST['emailbtn'];
                $cif = $_POST['cif'];
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $descripcion = $_POST['descripcion'];
                $telefono = $_POST['telefono'];
                $id_poblacion = $_POST['Selectpoblacion'];
                $id_sector = $_POST['sectorselect'];
                $validado = 1; // Se asume que el usuario se registra como validado por defecto
                $tipo = "empresa";

            // Primera consulta para insertar en la tabla 'usuario'
                $sql = "INSERT INTO `usuario`(`nombre_usuario`, `password`, `correo`, `validado`, `tipo`) VALUES ('$nombre_usuario','$hashed_password','$email','$validado','$tipo');";
                $consulta = $conexion->prepare($sql);

            // Ejecuta la primera consulta
                if ($consulta->execute()) {
                    // La ejecución fue exitosa
                } else {
                    // Ocurrió un error durante la ejecución
                }

            // Obtener el ID generado automáticamente después de la primera inserción
                $id_insertado = $conexion->lastInsertId();

            // Segunda consulta para insertar en la tabla 'empresa'
                $sql = "INSERT INTO empresa(`id_usuario`, `cif`, `nombre_empresa`, `direccion`, `descripcion`, `telefono`, `id_poblacion`, `id_sector`) VALUES ('$id_insertado','$cif','$nombre','$direccion','$descripcion','$telefono','$id_poblacion','$id_sector');";
                $consulta = $conexion->prepare($sql);

            // Ejecuta la segunda consulta
                if ($consulta->execute()) {
                    // La ejecución fue exitosa
                } else {
                    // Ocurrió un error durante la ejecución
                }
        }
?>