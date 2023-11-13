<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Lista de Alumnos</title>

    <!-- Incluye archivos PHP necesarios -->
    <?php
        include("../includes/conexion.php");
        include("../includes/funciones.php");
    ?>
    
    <!-- Cabecera administrado cuando está registrado-->
    <?php include("../includes/cabecera_registrado.php"); ?>
</head>
<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="../paginas_inicio/PaginaAdmin.php">Menú</a></li>
        <li>Gestión Alumnos</li>
    </ul> 

    <h1 class="titulo">Lista de Alumnos</h1>
    <div id="filtross">
        <!-- Filtro por nombre -->
        <div id="buscadorr">
            <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
            <button id="filtrarPorNombre">Buscar</button>
        </div>

        <!-- Filtro por año de nacimiento -->
        <div id="añonacimiento">
            Año de Nacimiento desde:
            <input type="number" id="anioDesde" name="anioDesde" min="1900" max="<?php echo date("Y"); ?>">
            <br>
            Año de Nacimiento hasta:
            <input type="number" id="anioHasta" name="anioHasta" min="1900" max="<?php echo date("Y"); ?>">
            <button id="filtrarPorAnio">Filtrar por Año</button> <!-- Agregado un botón para activar el filtro -->
        </div>

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
            <?php
                include("../includes/provincia.php")
            ?>
        </div>
    </div>

    <!-- Tabla de Alumnos -->
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
            $sqlTotal = "SELECT COUNT(*) FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario";
            $totalConsulta = $conexion->prepare($sqlTotal);
            $totalConsulta->execute();
            $total_filas = $totalConsulta->fetchColumn();
        // Consulta SQL para obtener los datos de los alumnos
            $sql = "SELECT alumno.id_usuario, alumno.nombre, alumno.apellidos, alumno.fecha_nacim, alumno.telefono, alumno.carnet_conducir, alumno.actitudes, alumno.aptitudes, poblacion.id_poblacion as id_poblacion , poblacion.nombre AS poblacion_nombre
                    FROM alumno
                    LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion";

        $consulta = $conexion->prepare($sql);
        if ($consulta->execute()) {
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Construye la fila de la tabla con los datos del alumno
                $tabla = "<tr>";
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
                $tabla .= "</tr>";
            }
            echo ($tabla);
            paginar($max_filas_por_pagina, $conexion, $total_filas);
        } else {
            echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
        }
        ?>

    </table>
<!-- 
    <?php
        // Incluye el pie de página
        include("../includes/footer.php");
    ?> -->
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Almacena la tabla de alumnos
    const tablaAlumnos = document.querySelector('table');

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

    // Filtrar por año de nacimiento
    document.getElementById('filtrarPorAnio').addEventListener('click', function() {
        filtrarPorAnio();
    });

    function filtrarPorAnio() {
        // Obtiene los valores de los campos de año desde y año hasta
        const anioDesde = parseInt(document.getElementById('anioDesde').value) || 0; // Si no se ingresa un valor, asumimos 0.
        const anioHasta = parseInt(document.getElementById('anioHasta').value) || 9999; // Si no se ingresa un valor, asumimos un año alto.

        // Obtiene todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

        filas.forEach(function(fila) {
            // Obtiene el valor de la fecha de nacimiento en formato de año
            const fechaNacimiento = parseInt(fila.querySelector('td:nth-child(3)').textContent);
            // Comprueba si la fila cumple con el filtro de año de nacimiento
            if (fechaNacimiento >= anioDesde && fechaNacimiento <= anioHasta) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro de año de nacimiento.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    }

    // Agrega eventos para el filtrado inicial al cargar la página
    filtrarPorAnio();
    radioButtons.forEach(function (radio) {
        radio.checked = true;
        radio.dispatchEvent(new Event('change'));
    });

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

    // Filtrador por Buscador de Nombre
    document.getElementById('filtrarPorNombre').addEventListener('click', function() {
        filtrarPorNombre();
    });

    function filtrarPorNombre() {
        // Obtiene el valor del buscador y lo convierte a minúsculas para hacer la búsqueda no sensible a mayúsculas/minúsculas.
        const nombreBusqueda = document.getElementById('nombreBusqueda').value.toLowerCase();

        // Obtiene todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

        filas.forEach(function(fila) {
            // Obtiene el valor de la primera columna (nombre) y lo convierte a minúsculas.
            const columnaNombre = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();

            if (columnaNombre.includes(nombreBusqueda)) {
                fila.style.display = ''; // Muestra la fila si el nombre coincide con la búsqueda.
            } else {
                fila.style.display = 'none'; // Oculta la fila si el nombre no coincide con la búsqueda.
            }
        });
    }

});

</script>
</html>
