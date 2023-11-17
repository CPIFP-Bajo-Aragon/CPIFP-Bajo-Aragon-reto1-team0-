<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Lista de Alumnos</title>
    <?php
        include("../includes/conexion.php");
        include("../includes/funciones.php");
    ?>


</head>

<?php include("../includes/cabecera_registrado.php"); ?>
<body>
    <?php
    if(isset($_POST['editar'])){

        $id = $_POST["id_usuario"];
        
        //MOSTRAR PERFIL
        $sqlOferta="SELECT * FROM alumno WHERE id_usuario='$id'";
        $stmt = $conexion->prepare($sqlOferta);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $dni = $fila->dni;
                $nombre = $fila->nombre;
                $apellidos = $fila->apellidos;
                $fecha_nacim = $fila->fecha_nacim;
                $telefono= $fila->telefono;
                $carnet_conducir=$fila->carnet_conducir;
                $actitudes=$fila->actitudes;
                $aptitudes=$fila->aptitudes;
                $id_poblacion=$fila->id_poblacion;
                //$id=$fila->id_usuario;



                // Guarda el nombre de la población 
               $sqlPoblacion="SELECT p.nombre FROM poblacion as p JOIN alumno as a ON a.id_poblacion=p.id_poblacion WHERE a.id_usuario=$id";
               $consultaPoblacion = $conexion->prepare($sqlPoblacion);
               $consultaPoblacion->execute();
               $nombrePoblacion = $consultaPoblacion->fetchColumn();

        
               echo " <div id='modalEmpresa' class='modal' style='display: block;'>
                <div class='modal-content'>
                <span class='close' onclick=\"cerrarModal('modalEmpresa')\">&times;</span>  
                <h2>Editar alumno</h2>
                <form action='usuarios-admin' method='POST'>
                <label for='dni'>DNI</label>
                <input type='text' name='dni' value='$dni'>

                <label for='nombre'>Nombre</label>
                <input type='text' name='nombre' value='$nombre'>

                <label for='nombre'>Apellidos</label>
                <input type='text' name='apellidos' value='$apellidos'>

                <label for='fecha_nacim'>Fecha de nacimiento</label>
                <input type='text' name='fecha_nacim' value='$fecha_nacim'>

                <label for='telefono'>Teléfono</label>
                <input type='text' name='telefono' value='$telefono'>

                <label for='carnet'>Carnet de conducir</label>
                <input type='text' name='carnet' value='$carnet_conducir'>

                <label for='actitudes'>Actitudes</label>
                <input type='text' name='actitudes' value='$actitudes'>

                <label for='aptitudes'>Aptitudes</label>
                <input type='text' name='aptitudes' value='$aptitudes'>

                <label for='poblacion'>Población</label>
                <input type='text' name='poblacion' value='$nombrePoblacion'>

                <input type='submit' name='Guardar' value='Guardar'>
                </form>
                </div>
                </div>";
            }
    }
}


 // Verificar si el formulario se ha enviado
 if (isset($_POST['Guardar'])) {
    // Recoger los datos del formulario
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacim = $_POST['fecha_nacim'];
    $telefono = $_POST['telefono'];
    $carnet = $_POST['carnet'];
    $actitudes = $_POST['actitudes'];
    $aptitudes = $_POST['aptitudes'];
    $poblacion = $_POST['poblacion'];


    // Guarda el id de la población 
    $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
    $consultaPoblacion = $conexion->prepare($sqlPoblacion);
    $consultaPoblacion->execute();
    $poblacionId = $consultaPoblacion->fetchColumn();

    // Actualizar los datos en la base de datos
    $update_alumno_sql = "UPDATE alumno 
                               SET dni = ?, nombre = ?,  apellidos = ? ,fecha_nacim = ?, telefono = ?, carnet_conducir = ?, actitudes = ?, aptitudes = ?, id_poblacion = ?
                               WHERE dni = ?";
    $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
    $update_alumno_stmt = $conexion->prepare($update_alumno_sql);
    $update_alumno_stmt->bindValue(1, $dni);
    $update_alumno_stmt->bindValue(2, $nombre);
    $update_alumno_stmt->bindValue(3, $apellidos);
    $update_alumno_stmt->bindValue(4, $fecha_nacim);
    $update_alumno_stmt->bindValue(5, $telefono);
    $update_alumno_stmt->bindValue(6, $carnet);
    $update_alumno_stmt->bindValue(7, $actitudes);
    $update_alumno_stmt->bindValue(8, $aptitudes);
    $update_alumno_stmt->bindValue(9, $poblacionId);
    $update_alumno_stmt->bindValue(10, $dni);

    $update_alumno_stmt->execute();
}     



    if(isset($_POST['borrar'])){

        echo '<script>
        var confirmacion = confirm("¿Estás seguro de que quieres borrar este alumno?");
        console.log("Valor de confirmar_borrar:", document.getElementById("confirmar_borrar").value);
        if (confirmacion) {
            '.
            $sql = "DELETE FROM habla_idioma WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
       
        $sql = "DELETE FROM tener_estudio WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM inscribir WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM mensaje WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $sql = "DELETE FROM poseer_experiencia WHERE id_usuario = :id_usuario";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();




        $id_usuario=$_POST['id_usuario'];
         // Intenta eliminar el registro de la tabla 'empresa' usando el ID de usuario
         $sql = "DELETE FROM alumno WHERE id_usuario = :id_usuario";
         $consulta = $conexion->prepare($sql);
         $consulta->bindParam(':id_usuario', $id_usuario);
         $consulta->execute();


         // Intenta eliminar el registro de la tabla 'usuario' usando el ID de usuario
         $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
         $consulta = $conexion->prepare($sql);
         $consulta->bindParam(':id_usuario', $id_usuario);
         $consulta->execute();
            '
        }        
        </script>';
       


    }
    ?>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-admin">Menú</a></li>
        <li>Gestión Alumnos</li>
    </ul>


    <h1 class="titulo">Lista de Alumnos</h1>
    <div class="filtross">
        <!-- Filtro por nombre -->
        <div id="buscadorr">
            <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
        </div>


        <!-- Filtro por año de nacimiento
        <div id="añonacimiento">
            Año de Nacimiento desde:
            <input type="number" id="anioDesde" name="anioDesde" min="1900" max="<?php echo date("Y"); ?>">
            <br>
            Año de Nacimiento hasta:
            <input type="number" id="anioHasta" name="anioHasta" min="1900" max="<?php echo date("Y"); ?>">
            <button id="filtrarPorAnio">Filtrar por Año</button> <!-- Agregado un botón para activar el filtro
        </div> -->


        <!-- Filtro por Carnet de Conducir -->
        <div id="conducirr">
            Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
            <br>
            Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
            <br>
            Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
        </div>


        <!-- Filtro por Población -->
        <div id="poblacion">
            <select name="poblacionSelect" id="poblacionSelect">
                    <?php
                    listarProvinciaypoblacion($conexion, $select_name)
                    ?>
                </select>
            
        <div id="fvalidar">
            <!-- Formulario de filtrado por validación -->
            <form action="usuarios-admin" method="post" id="filtrarValidacion">
                Validado<input type="radio" name="filtrovalidar" value="validado" id="validado">
                <br>
                Sin validar<input type="radio" name="filtrovalidar" value="sinvalidar" id="sinvalidar">
                <br>
                Todos<input type="radio" name="filtrovalidar" value="todos" id="todos">
            </form>
        </div>
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
                        $tabla .= "<td>" . $fila->actitudes . "</td>";
                    }
                    $tabla .= "<td id='" . $fila->id_poblacion . "'>" . $fila->poblacion_nombre . "</td>";
                    $tabla .= "<td>" . ($fila->validado == 1 ? 'validado' : 'novalidado') . "</td>";
                        $tabla .= "<td>";
                                $tabla .= "<form action='usuarios-admin' method='post'>";
                                $tabla .= "<input type='hidden' name='id_usuario' value='$id_usuario'>";
                                $tabla .=  "<button type='submit' name='borrar' id='borrar'><i class='fas fa-trash''></i></button>";
                                $tabla .=  "<button type='submit' name='editar' id='editar'><i class='fas fa-pencil-alt'></i></button>";
                                $tabla .= "</form>";
                            $tabla .= "</td>";
                    $tabla .= "</tr>";
                }
                echo ($tabla);
                paginar($max_filas_por_pagina, $conexion, $total_filas);
            } else {
                echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

<?php
        include("../includes/footer.php");
    ?>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    // Almacena la tabla de alumnos
    const tablaAlumnos = document.querySelector('#tabla');


    // Filtrador de validado
    const radioButtonsValidar = document.querySelectorAll('input[name="filtrovalidar"]');
   
    radioButtonsValidar.forEach(function (radio) {
        radio.addEventListener('change', function () {
            const filtro = this.value;


            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


            filas.forEach(function (fila) {
                const columnaValidado = fila.querySelector('td:nth-child(9)').textContent.trim();


                if (filtro === 'todos' || columnaValidado === (filtro === 'validado' ? 'validado' : 'novalidado')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });
    // Filtrador de Carnet de Conducir
    const radioButtons = document.querySelectorAll('input[name="filtroCarnet"]');
   
    radioButtons.forEach(function (radio) {
        radio.addEventListener('change', function () {
            // Almacena el valor del filtro
            const filtro = this.value;
            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


            filas.forEach(function (fila) {
                // Obtiene la columna que contiene la información del Carnet de Conducir
                const columnaCarnet = fila.querySelector('td:nth-child(5)');
                // Comprueba si la fila cumple con el filtro
                if (filtro === 'todos' || columnaCarnet.textContent.trim() === (filtro === 'conCarnet' ? 'Sí' : 'No')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });


    // // Filtrar por año de nacimiento
    // document.getElementById('filtrarPorAnio').addEventListener('click', function() {
    //     filtrarPorAnio();
    // });


    // function filtrarPorAnio() {
    //     // Obtiene los valores de los campos de año desde y año hasta
    //     const anioDesde = parseInt(document.getElementById('anioDesde').value) || 0; // Si no se ingresa un valor, asumimos 0.
    //     const anioHasta = parseInt(document.getElementById('anioHasta').value) || 9999; // Si no se ingresa un valor, asumimos un año alto.


    //     // Obtiene todas las filas de la tabla excepto la primera (encabezados).
    //     const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


    //     filas.forEach(function(fila) {
    //         // Obtiene el valor de la fecha de nacimiento en formato de año
    //         const fechaNacimiento = parseInt(fila.querySelector('td:nth-child(3)').textContent);
    //         // Comprueba si la fila cumple con el filtro de año de nacimiento
    //         if (fechaNacimiento >= anioDesde && fechaNacimiento <= anioHasta) {
    //             fila.style.display = ''; // Muestra la fila si coincide con el filtro de año de nacimiento.
    //         } else {
    //             fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
    //         }
    //     });
    // }


    // // Agrega eventos para el filtrado inicial al cargar la página
    // filtrarPorAnio();
    // radioButtons.forEach(function (radio) {
    //     radio.checked = true;
    //     radio.dispatchEvent(new Event('change'));
    // });


    // Filtrador por Población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');


    filtroPoblacionSelect.addEventListener('change', function () {
        const poblacionSeleccionada = filtroPoblacionSelect.value;


        // Obtiene todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


        // Recorre las filas y filtra según la población seleccionada.
        filas.forEach(function (fila) {
            // Obtiene el ID de población almacenado en un atributo personalizado
            const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');


            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro de población.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    //Filtrar por el buscador de manera asincrona


    const filtroNombreInput = document.getElementById('nombreBusqueda');

    filtroNombreInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas
        const filtroTexto = this.value.toLowerCase();
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro por título
        filas.forEach(function (fila) {
            // Obtiene el contenido de la columna "Título"
            const columnaTitulo = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (columnaTitulo.includes(filtroTexto)) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });
});



    function closeModal(modalEmpresa) {
        var modal = document.getElementById(modalEmpresa);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('modalEmpresa');
    });




</script>

