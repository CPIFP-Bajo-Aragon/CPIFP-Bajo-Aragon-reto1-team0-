<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Lista de Alumnos</title>
    <?php
        include("../includes/conexion.php");
        include("../includes/funciones.php");
        include("../includes/links.php");
    ?>

<?php  if ($_SESSION['tipoUsuario']!="administrador") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }?>

    <style>
            
            

        @media (max-width: 700px) {
            #listaralumnosadmin .filtross {
                display: flex;
                flex-direction: column;
                width: 80vw;
            }

            

            #listaralumnosadmin .filtross > div {
                margin-bottom: 10px; /* Puedes ajustar este valor según tus necesidades */
            }
            /* Ejemplo de ajuste para el contenido */
            #listaralumnosadmin #tableUsuarios {
                max-height: 100vh; /* Ajusta la altura máxima al 100% del alto de la ventana */
                overflow-y: auto; /* Añade un desplazamiento vertical si el contenido excede la altura máxima */
                max-width: 40vh;
                overflow-x: auto;
            }
            
        }
        
    </style>
</head>

<body>
    
    <?php
        include("../includes/cabecera_registrado.php"); 
    ?>
    <div>
        <!-- ISSET -->
            <?php
                if (isset($_POST['guardar'])) {
                    // Recoger los datos del formulario
                    $dni = $_POST['dni'];
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellido'];
                    $fecha_nacim = $_POST['fecha'];
                    $telefono = $_POST['telefono'];
                    if(isset($_POST['carnet'])){
                        $carnet = 1;
                    }else{
                        $carnet=0;
                    }
                    $actitudes = $_POST['actitudes'];
                    $aptitudes = $_POST['aptitudes'];
                    $id=$_POST['id_usuario'];


                    $update_alumno_sql = "UPDATE alumno 
                        SET dni = ?, nombre = ?, apellidos = ?, fecha_nacim = ?, telefono = ?, carnet_conducir = ?, actitudes = ?, aptitudes = ?
                        WHERE id_usuario = ?";
                        $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
                        $update_alumno_stmt->bindParam(1, $dni);
                        $update_alumno_stmt->bindParam(2, $nombre);
                        $update_alumno_stmt->bindParam(3, $apellidos);
                        $update_alumno_stmt->bindParam(4, $fecha_nacim);
                        $update_alumno_stmt->bindParam(5, $telefono);
                        $update_alumno_stmt->bindParam(6, $carnet);
                        $update_alumno_stmt->bindParam(7, $actitudes);
                        $update_alumno_stmt->bindParam(8, $aptitudes);
                        $update_alumno_stmt->bindParam(9, $id);
                        $update_alumno_stmt->execute();
                }     
                if (isset($_POST["borrar"])) {
                    $id = $_POST["id_usuario"];
                    //confirmar borrado 
                    ?>
                        <div id="confirmar">
                            <form action="" method="POST">
                                <input type="hidden" name="id_usuario" value="<?php echo $id ?>">
                                <label for="">¿Seguro que quieres borrar el registro?</label>
                                <input type="submit" value="no">
                                <input type="submit" value="si" name="si">
                            </form>
                        </div>
                    <?php
                }
                if (isset($_POST["si"])) {
                // Obtener el ID de usuario desde la solicitud POST
                    $id_usuario = $_POST["id_usuario"];

                // Eliminar registros de la tabla 'habla_idioma' relacionados con el usuario
                    $sql = "DELETE FROM habla_idioma WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Eliminar registros de la tabla 'tener_estudio' relacionados con el usuario
                    $sql = "DELETE FROM tener_estudio WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Eliminar registros de la tabla 'inscribir' relacionados con el usuario
                    $sql = "DELETE FROM inscribir WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Eliminar registros de la tabla 'mensaje' relacionados con el usuario
                    $sql = "DELETE FROM mensaje WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Eliminar registros de la tabla 'poseer_experiencia' relacionados con el usuario
                    $sql = "DELETE FROM poseer_experiencia WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Intenta eliminar el registro de la tabla 'alumno' usando el ID de usuario
                    $sql = "DELETE FROM alumno WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();

                // Intenta eliminar el registro de la tabla 'usuario' usando el ID de usuario
                    $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
                    $consulta = $conexion->prepare($sql);
                    $consulta->bindParam(':id_usuario', $id_usuario);
                    $consulta->execute();
                }
                if(isset($_POST['validar'])){
                    $id = $_POST["id_usuario"];
                    validarregistro($conexion, $id);
                }
            ?>
        <main id="listaralumnosadmin">
            <!-- Navegación de migas de pan -->
                <ul class="breadcrumb">
                    <li><a href="pagina-admin">Menú</a></li>
                    <li>Gestión Alumnos</li>
                </ul>
                
            <h1 class="titulo">Lista de Alumnos</h1>
            <!-- FILTROS -->
                <div class="filtross">
                    <!-- Filtro por nombre -->
                    <div id="buscadorr" class="fil">
                        <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
                    </div>

                    <!-- Filtro por Carnet de Conducir -->
                    <div id="conducirr" class="fil">
                        Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
                        <br>
                        Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
                        <br>
                        Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
                    </div>


                    <!-- Filtro por Población -->
                    <div id="poblacion" class="fil">
                        <select name="poblacionSelect" id="poblacionSelect">
                                <?php
                                listarProvinciaypoblacion($conexion, $select_name)
                                ?>
                            </select>
                    </div>
                    <div id="fvalidar" class="fil">
                        <!-- Formulario de filtrado por validación -->
                        <form action="usuarios-admin" method="post" id="filtrarValidacion">
                            Validado<input type="radio" name="filtrovalidar" value="validado" id="validado">
                            <br>
                            Sin validar<input type="radio" name="filtrovalidar" value="sinvalidar" id="sinvalidar">
                            <br>
                            Todos<input type="radio" name="filtrovalidar" value="todos" id="todos">
                        </form>
                    </div>

                    <form action="usuarios-admin" >
                    <button class='boton_recarga'>Limpiar Filtros</button>
                    </form>

                </div>

            


            <!-- Tabla de Alumnos -->
            <div id="tableUsuarios">
                <table id="tabla">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Teléfono</th>
                        <th>Carnet de Conducir</th>
                        <th>Actitudes</th>
                        <th>Aptitudes</th>
                        <th>Población</th>
                        <th>Validado</th>
                        <th>Opciones</th>
                    </tr>


                    <?php
                    $max_filas_por_pagina=5;
                    // Manejo de paginación y obtención de datos de ofertas de trabajo desde la base de datos
                    $pagina = 1; // Página por defecto.
                    if (isset($_POST['pagina'])) {
                        $pagina = $_POST['pagina'];
                    }
                $inicio = ($pagina - 1) * $max_filas_por_pagina;
        
                // Consulta para obtener el total de filas de ofertas de trabajo
                    $sqlTotal = "SELECT count(*) FROM alumno LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion ";
                    $totalConsulta = $conexion->prepare($sqlTotal);
                    $totalConsulta->execute();
                    $total_filas = $totalConsulta->fetchColumn();
        
        
                // Consulta SQL para obtener los datos de los alumnos
                    $sql = "SELECT alumno.id_usuario as id_user, alumno.nombre, usuario.validado as validado, alumno.apellidos, alumno.fecha_nacim, alumno.telefono, alumno.carnet_conducir, alumno.actitudes, alumno.aptitudes, poblacion.id_poblacion as id_poblacion , poblacion.nombre AS poblacion_nombre FROM alumno INNER JOIN usuario ON alumno.id_usuario = usuario.id_usuario LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion  LIMIT $inicio, $max_filas_por_pagina";
        

                    $consulta = $conexion->prepare($sql);
                    if ($consulta->execute()) {
                        $tabla = "";
                        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                            if ($fila->validado) {
                                $validado = "validado";
                            } else {
                                $validado = "novalidado";
                            }
                            // Construye la fila de la tabla con los datos del alumno
                            $id_usuario= $fila->id_user;
                            $tabla .= "<tr>";
                            $tabla .= "<td>" . $fila->nombre . "</td>";
                            $tabla .= "<td>" . $fila->apellidos . "</td>";
                            // $tabla .= "<td>" . $fila->fecha_nacim . "</td>";
                            $tabla .= "<td>" . date('d-m-Y', strtotime($fila->fecha_nacim)) . "</td>";
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
                            
                            $tabla .= "<td>$validado</td>";
                            if($fila->validado == 1){
                                $tabla .= "<td>";
                                $tabla .= "<form action='usuarios-admin' method='post'>";
                                $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                                // $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                                $tabla .=  "<button type='submit' name='borrar' id='borrar' style='background-color: #ff6347; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-left: 20%;'><i class='fas fa-trash'></i></button>";
                                // $tabla .=  "<button type='submit' name='editar' id='editar_$id_usuario'><i class='fas fa-pencil-alt'></i></button>";
                                $tabla .= "<button type='submit' name='editar' id='editar_$id_usuario' style='background-color: #a9dfbf; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-left: 20%;'><i class='fas fa-pencil-alt'></i></button>";
                                $tabla .= "</form>";
                            $tabla .= "</td>";
                            }else{
                                $tabla .= "<td>";
                                $tabla .= "<form action='usuarios-admin' method='post'>";
                                $tabla .=  "<input type='hidden' name='pagina' id='pagina' value='$pagina'>";
                                $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                                // $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                                $tabla .=  "<button type='submit' name='borrar' id='borrar' style='background-color: #ff6347; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-left: 20%;'><i class='fas fa-trash'></i></button>";
                                // $tabla .=  "<button type='submit' name='validar' id='validar'><i class='fas fa-check'></i></button>";
                                $tabla .=  "<button type='submit' name='validar' id='validar' style='background-color: #add8e6; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-left: 20%;'><i class='fas fa-check'></i></button>";
                                // $tabla .=  "<button type='submit' name='editar' id='editar_$id_usuario'><i class='fas fa-pencil-alt'></i></button>";
                                $tabla .= "<button type='submit' name='editar' id='editar_$id_usuario' style='background-color: #a9dfbf; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-left: 20%;'><i class='fas fa-pencil-alt'></i></button>";
                                $tabla .= "</form>";
                            $tabla .= "</td>";
                            }
                            $tabla .= "</tr>";
                            
                        
                        }
                        echo ($tabla);
                        echo ('<form action="usuarios-admin" method="post">');
                            paginar($max_filas_por_pagina, $total_filas);
                        echo ('</form>');

                    } else {
                        echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div id='modalUsuario' class='modal' style='display: none;'>
                <div id='modal-content' class='modal-content'></div>
            </div>
        </main>
    </div>
    <?php
        include("../includes/footer.php");
    ?>
</body>


</html>
<script src="../../JS/tablas_admin/listarusuarios.js"></script>

<script>
    // Función para mostrar un modal por su ID
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

    // Función para cerrar un modal por su ID
    function cerrarModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Función para crear un elemento de entrada
    function crearInput(type, name, value) {
        var input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.value = value;
        return input;
    }

    // Elemento que contendrá el contenido del modal
    var modalContent = document.getElementById('modal-content');

    // EventListener para cada botón con el atributo 'name="editar"'
    document.querySelectorAll('[name="editar"]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Evitar la recarga de la página por defecto
            modalContent.innerHTML = ''; // Limpiar el contenido del modal

            // Crear el botón de cerrar
            var close = document.createElement('span');
            close.className = 'close';
            close.textContent = '\u00D7';  // Código Unicode para la 'x'
            close.onclick = function() {
                cerrarModal('modalUsuario');
            };

            var idUsuario = this.getAttribute('id').replace('editar_', '');

            // Crear el título del modal
            var h2 = document.createElement('h2');
            h2.textContent = 'Editar Usuario';

            // Crear el formulario
            var form = document.createElement('form');
            form.action = 'usuarios-admin';
            form.method = 'POST';

            // Crear e insertar los elementos de entrada en el formulario
            var inputNombre = crearInput('text', 'nombre', idUsuario);
            var inputApellido = crearInput('text', 'apellido', idUsuario);
            var inputFecha = crearInput('date', 'fecha', idUsuario);
            var inputDNI = crearInput('text', 'dni', idUsuario);
            var inputCarnet = crearInput('checkbox', 'carnet', idUsuario);   
            var inputTelefono = crearInput('text', 'telefono', idUsuario);
            var inputActitudes = crearInput('text', 'actitudes', idUsuario);
            var inputAptitudes = crearInput('text', 'aptitudes', idUsuario);
            var inputIdUsuario = crearInput('hidden', 'id_usuario', idUsuario); 
            // var inputPoblacion = crearInput('text', 'poblacion', idUsuario);

            // Crear el botón de submit
            var inputSubmit =  crearInput('submit', 'guardar', 'Guardar');
            
            // Asignar identificadores únicos a los elementos
            inputNombre.id = 'inputNombre';
            inputApellido.id = 'inputApellido';
            inputFecha.id = 'inputFecha';
            inputDNI.id = 'inputDNI';
            inputCarnet.id = 'inputCarnet';
            inputTelefono.id = 'inputTelefono';
            inputActitudes.id = 'inputActitudes';
            inputAptitudes.id = 'inputAptitudes';
            inputIdUsuario.id = 'inputIdUsuario';
            // inputPoblacion.id = 'inputPoblacion';

            

            var labelnombre = document.createElement('label');
            labelnombre.textContent = 'Nombre';

            var labelapellido = document.createElement('label');
            labelapellido.textContent = 'Apellido';

            var labeldni = document.createElement('label');
            labeldni.textContent = 'DNI';

            var labelcarnet = document.createElement('label');
            labelcarnet.textContent = '¿Tienes carnet Carnet?';
            
            var labelactitudes = document.createElement('label');
            labelactitudes.textContent = 'Actitudes';

            var labelaptitudes = document.createElement('label');
            labelaptitudes.textContent = 'Aptitudes';

            var labeltelefono = document.createElement('label');
            labeltelefono.textContent = 'Telefono';

            // Agregar elementos al formulario
            form.appendChild(labelnombre);
            form.appendChild(inputNombre);
            form.appendChild(labelapellido);
            form.appendChild(inputApellido);
            form.appendChild(inputFecha);
            form.appendChild(labeldni);
            form.appendChild(inputDNI);
            form.appendChild(labelcarnet);
            form.appendChild(inputCarnet);
            form.appendChild(labeltelefono);
            form.appendChild(inputTelefono);
            form.appendChild(labelactitudes);
            form.appendChild(inputActitudes);
            form.appendChild(labelaptitudes);
            form.appendChild(inputAptitudes);
            form.appendChild(inputIdUsuario);
            // form.appendChild(inputPoblacion);
            form.appendChild(inputSubmit);

            // Agregar elementos al contenedor del modal
            modalContent.appendChild(close);
            modalContent.appendChild(h2);
            modalContent.appendChild(form);

            // Cargar ventana modal con datos
            cargarVentanaModal(idUsuario);
            // Llenar el modal con datos
            llenarDatosEnModal(modalUsuario);

            // Mostrar el modal
            openModal('modalUsuario');
        });
    });

    // Función para llenar el modal con datos
    function llenarDatosEnModal(datosUsuario) {
        document.getElementById('inputNombre').value = datosUsuario.nombre;
        document.getElementById('inputApellido').value = datosUsuario.apellidos;
        var fecha = datosUsuario.fecha_nacim;
        console.log(fecha);
        // Convertir la fecha al formato YYYY-MM-DD
        var partesFecha = fecha.split("/");
        var fechaConvertida = partesFecha[2] + "-" + partesFecha[1] + "-" + partesFecha[0];

        // Establecer el valor en el elemento de entrada
        document.getElementById('inputFecha').value = fechaConvertida;
        // document.getElementById('inputFecha').value = "2004-11-15";
        document.getElementById('inputDNI').value = datosUsuario.dni;
        document.getElementById('inputCarnet').checked = datosUsuario.carnet_conducir === 1;
        document.getElementById('inputTelefono').value = datosUsuario.telefono;
        document.getElementById('inputActitudes').value = datosUsuario.actitudes;
        document.getElementById('inputAptitudes').value = datosUsuario.aptitudes;
        document.getElementById('inputIdUsuario').value = datosUsuario.id_usuario;
        // document.getElementById('inputPoblacion').value = datosUsuario.nombrePoblacion;
    }

    // Función para cargar datos en el modal desde el servidor
    function cargarVentanaModal(idUsuario) {
        // Simulamos la solicitud aquí, puedes ajustarlo para que sea una solicitud real si es necesario
        fetch('/PHP/tablas_admin/editarusuarios.php?id_usuario=' + idUsuario)
            .then(response => response.json())
            .then(modalUsuario => {
                // Llena el modal con los datos obtenidos
                llenarDatosEnModal(modalUsuario);

                // Muestra el modal
                openModal('modalUsuario');
            });
    }

</script>