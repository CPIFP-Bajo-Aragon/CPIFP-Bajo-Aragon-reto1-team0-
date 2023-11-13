<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include("../includes/cabecera_registrado.php");
    include("../includes/conexion.php");
    include("../includes/funciones.php");
    ?>
    <div>
        <h3>OFERTAS PUBLICADAS</h3>
        <div id="tabla">
        <table>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha de Publicación</th>
                <th>Duración del Contrato (meses)</th>
                <th>Requiere Carnet de Conducir</th>
                <th>Población</th>
            </tr>
            
            <?php
            // Manejo de paginación y obtención de datos de ofertas de trabajo desde la base de datos
            $pagina = 1; // Página por defecto.
            $max_filas_por_pagina = 5;
            if (isset($_POST['pagina'])) {
                $pagina = $_POST['pagina'];
            }
            
            $inicio = ($pagina - 1) * $max_filas_por_pagina;

            // Consulta para obtener el total de filas de ofertas de trabajo
            $sql = "SELECT COUNT(*) FROM alumno LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion";
            $totalConsulta = $conexion->prepare($sql);
            $totalConsulta->execute();
            $total_filas = $totalConsulta->fetchColumn();
            $id_usuario=$_SESSION['id_usuario'];

            // Consulta para obtener las ofertas de trabajo paginadas

            $sql = "SELECT OT.id_oferta as id_oferta, OT.titulo AS Titulo, OT.descripcion_oferta AS Descripcion_Oferta, OT.fecha_publicacion AS Fecha_Publicacion, OT.duracion_contrato AS Duracion_Contrato, OT.carnet_conducir AS Carnet_Conducir, P.nombre AS Nombre_Poblacion, P.id_poblacion as id_poblacion FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario WHERE E.id_usuario=$id_usuario LIMIT $inicio, $max_filas_por_pagina ";
            
            $consulta = $conexion->prepare($sql);
            
            // Mostrar resultados en la tabla
            if ($consulta->execute()) {
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Imprimir cada fila de la tabla
                    echo "<tr>";
                    echo "<td>" . $fila->Titulo . "</td>";
                    echo "<td>" . $fila->Descripcion_Oferta . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($fila->Fecha_Publicacion)) . "</td>"; // Formatea la fecha
                    echo "<td>" . $fila->Duracion_Contrato . "</td>";
                    echo "<td>" . ($fila->Carnet_Conducir ? "Sí" : "No") . "</td>";
                    echo "<td id='".$fila->id_poblacion."'>" . $fila->Nombre_Poblacion . "</td>";
                    echo "</tr>";
                }
                
                // Formulario para la paginación
                echo ('<form action="listarofertas.php" method="post">');
                paginar($max_filas_por_pagina, $conexion, $total_filas);
                echo ('</form>');
                
            } else {
                // Mensaje si no se encuentran ofertas de trabajo
                echo "<tr><td colspan='8'>No se encontraron ofertas de trabajo.</td></tr>";
            }
            ?>
            <!-- Elemento div extra no válido dentro de la tabla -->
            <div id="midiv"></div>
        </table>
    </div>
    </div>

    <?php
    include("../includes/footer.php");
    ?>
</body>
</html>