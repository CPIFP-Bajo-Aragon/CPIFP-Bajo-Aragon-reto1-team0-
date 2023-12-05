<?php
    function listarempresachat($conexion){
       
        $id_personal=$_SESSION['id_usuario'];

        // Consulta paginada para obtener los datos de las empresas
        $sql_empresas = "SELECT * FROM usuario INNER JOIN empresa ON empresa.id_usuario = usuario.id_usuario where usuario.id_usuario!= $id_personal;";
        $consulta_empresas = $conexion->prepare($sql_empresas);

        // Ejecuta la consulta paginada
        if ($consulta_empresas->execute()) {
            while ($fila = $consulta_empresas->fetch(PDO::FETCH_OBJ)) {
                // Extrae la información de la empresa
                $id_usuario = $fila->id_usuario;
                $nombre = $fila->nombre_empresa;
                $direccion = $fila->direccion;
                $correo = $fila->correo;
                $telefono = $fila->telefono;


                $id_poblacion = $fila->id_poblacion;
                $nom_poblacion = mostrarPoblacion($conexion, $id_poblacion);
                $id_sector = $fila->id_sector;
                $nombre_sector = mostrarsector($conexion, $id_sector);

                // Construye la fila de la tabla
                $tabla = "<tr>";
                $tabla .= "<td>$id_usuario</td>";
                $tabla .= "<td>$nombre</td>";
                $tabla .= "<td>$direccion</td>";
                $tabla .= "<td>$correo</td>";
                $tabla .= "<td>$telefono</td>";
                $tabla .= "<td id='$id_poblacion'>$nom_poblacion</td>";
                $tabla .= "<td id='$id_sector'>$nombre_sector</td>";

                    $tabla .= "<td>";
                    $tabla .= "<form action='chatea' method='post'>";
                    $tabla .= "<input type='hidden' name='id_receptor' value='$id_usuario'>";
                    $tabla .=  "<button type='submit' name='chatear_empresas' id='chatear_empresas'>chatear</button>";
                    $tabla .= "</form>";
                    $tabla .= "</td>";
                $tabla .= "</tr>";

                // Muestra la fila en la tabla
                echo $tabla;
            }

        }
    }

    function listaralumnochat($conexion){
       

            $id_personal=$_SESSION['id_usuario'];
        // Consulta SQL para obtener los datos de los alumnos
            $sql = "SELECT alumno.id_usuario as id_user, alumno.nombre, usuario.validado as validado, alumno.apellidos, alumno.fecha_nacim, alumno.telefono, alumno.carnet_conducir, alumno.actitudes, alumno.aptitudes, poblacion.id_poblacion as id_poblacion , poblacion.nombre AS poblacion_nombre FROM alumno INNER JOIN usuario ON alumno.id_usuario = usuario.id_usuario LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion where usuario.id_usuario!= $id_personal ";


            $consulta = $conexion->prepare($sql);
            if ($consulta->execute()) {
                $tabla = "";
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Construye la fila de la tabla con los datos del alumno
                    $id_usuario= $fila->id_user;
                    $tabla .= "<tr>";
                    $tabla .= "<td>" . $fila->nombre . "</td>";
                    $tabla .= "<td>" . $fila->apellidos . "</td>";
                    $tabla .= "<td>" . $fila->fecha_nacim . "</td>";
                    $tabla .= "<td>" . $fila->telefono . "</td>";
                    $tabla .= "<td>" . ($fila->carnet_conducir ? "Sí" : "No") . "</td>";
                    if ($fila->actitudes === "") {
                        $tabla .= "<td>Sin actitudes</td>";
                    } else {
                        $tabla .= "<td>" . $fila->actitudes . "</td>";
                    }
                    if ($fila->actitudes === "") {
                        $tabla .= "<td>Sin aptitudes</td>";
                    } else {
                        $tabla .= "<td>" . $fila->aptitudes . "</td>";
                    }
                    $tabla .= "<td id='" . $fila->id_poblacion . "'>" . $fila->poblacion_nombre . "</td>";
                        $tabla .= "<td>";
                                $tabla .= "<form action='chatea' method='post'>";
                                $tabla .= "<input type='hidden' name='id_receptor' value='$id_usuario'>";
                                $tabla .=  "<button type='submit' name='chatear_alumno' id='chatear_alumno'>chatear</button>";
                                $tabla .= "</form>";
                            $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
                echo ($tabla);
            } else {
                echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
            }
    }


    function listaradminchat($conexion){
       



            $id_personal=$_SESSION['id_usuario'];
        // Consulta SQL para obtener los datos de los alumnos
        $sql = "SELECT * FROM usuario INNER JOIN administrador ON usuario.id_usuario = administrador.id_usuario ";

            $consulta = $conexion->prepare($sql);
            if ($consulta->execute()) {
                $tabla = "";
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Construye la fila de la tabla con los datos del alumno
                    $id_usuario= $fila->id_usuario;
                    $tabla .= "<tr>";
                    $tabla .= "<td>" . $fila->nombre_admin . "</td>";
                    $tabla .= "<td>" . $fila->correro . "</td>";
                        $tabla .= "<td>";
                                $tabla .= "<form action='chat' method='post'>";
                                $tabla .= "<input type='hidden' name='id_usuario_admin' value='$id_usuario'>";
                                $tabla .=  "<button type='submit' name='chatear_admin' id='chatear_admin'>chatear</button>";
                                $tabla .= "</form>";
                            $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
                echo ($tabla);
            } else {
                echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
            }
        
    }
?>