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
        <li><a href="pagina-empresa">Menú</a></li>
        <li>Gestión Alumnos</li>
    </ul>

    <h1 class="titulo">Buscar Alumnos</h1>
    <?php
        include "../includes/filtros/tablasempresa/buscaralumno.php"
    ?>

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
        $sqlTotal = "SELECT count(*) FROM alumno LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion ";
        $totalConsulta = $conexion->prepare($sqlTotal);
        $totalConsulta->execute();
        $total_filas = $totalConsulta->fetchColumn();

        // Consulta SQL para obtener los datos de los alumnos
        $sql = "SELECT alumno.id_usuario as id_user, alumno.nombre, alumno.apellidos, alumno.fecha_nacim, alumno.telefono, alumno.carnet_conducir, alumno.actitudes, alumno.aptitudes, poblacion.id_poblacion as id_poblacion , poblacion.nombre AS poblacion_nombre
                FROM alumno
                LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion ORDER BY alumno.fecha_nacim DESC LIMIT $inicio, $max_filas_por_pagina";

        $consulta = $conexion->prepare($sql);
        if ($consulta->execute()) {
            $tabla = "";
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Construye la fila de la tabla con los datos del alumno
                $id_usuario= $fila->id_user;
                $tabla .= "<tr>";
                $tabla .= "<td>" . $fila->nombre . "</td>";
                $tabla .= "<td>" . $fila->apellidos . "</td>";
                $fecha_nacimiento = date('d/m/Y', strtotime($fila->fecha_nacim));
                $tabla .= "<td>" . $fecha_nacimiento . "</td>";
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
</body>
 
<?php
    // Incluye el pie de página
    include("../includes/footer.php");
?> 
</html>

<script src="../../JS/tablasempresa/buscaralumno.js"></script>
