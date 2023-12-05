<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Lista de Alumnos</title>

    <!-- Incluye archivos PHP necesarios -->
    <?php
        include("../includes/links.php");
        include("../includes/conexion.php");
        include("../includes/funciones.php");
    ?>

<style>
   
</style>

</head>
<body>
    <?php include("../includes/cabecera_registrado.php"); 
    
    if ($_SESSION['tipoUsuario']!="empresa") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }
    
    ?>
    
    <main id="buscaralumnoempresas">
        <div>    
            <!-- Navegación de migas de pan -->
            <ul class="breadcrumb">
                <li><a href="pagina-empresa">Menú</a></li>
                <li>Gestión Alumnos</li>
            </ul>

            <h1 class="titulo">Buscar Alumnos</h1>
        <!-- FILTROS -->
            <div id="filtrossa">
                    <!-- Filtro por nombre -->
                    <div id="buscadorr">
                        <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
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
                    <div id="poblaciondiv">
                        <select name="poblacion" id="poblacion">
                            <?php    
                                listarProvinciaypoblacion($conexion)
                            ?>    
                        </select>
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
                               // Consulta SQL para obtener los datos de los alumnos
                $sql = "SELECT alumno.id_usuario as id_user, alumno.nombre, alumno.apellidos, alumno.fecha_nacim, alumno.telefono, alumno.carnet_conducir, alumno.actitudes, alumno.aptitudes, poblacion.id_poblacion as id_poblacion , poblacion.nombre AS poblacion_nombre
                        FROM alumno
                        LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion ORDER BY alumno.fecha_nacim DESC";

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
                } else {
                    echo "<tr><td colspan='8'>No se encontraron alumnos.</td></tr>";
                }
                ?>
            </table>
        </div>
    </main>
    <?php
    // Incluye el pie de página
    include("../includes/footer.php");
    ?>
</body>
 
 
</html>

<script src="../../JS/tablasempresa/buscaralumno.js"></script>
