<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen</title>
</head>
<body>
    <?php
    include("../includes/cabecera_registrado.php");
    include("../includes/conexion.php");
    include("../includes/funciones.php");
    ?>
    <div>

        <!-- Navegación de migas de pan -->
        <ul class="breadcrumb">
            <li><a href="pagina-empresa">Menú</a></li>
            <li>Resumen </li>
        </ul> 


        <h1 class="titulo">OFERTAS PUBLICADAS</h1>
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
                    $id_oferta = $fila->id_oferta;
                    // Imprimir cada fila de la tabla
                    echo "<tr>";
                    echo "<td>" . $fila->Titulo . "</td>";
                    echo "<td>" . $fila->Descripcion_Oferta . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($fila->Fecha_Publicacion)) . "</td>"; // Formatea la fecha
                    echo "<td>" . $fila->Duracion_Contrato . "</td>";
                    echo "<td>" . ($fila->Carnet_Conducir ? "Sí" : "No") . "</td>";
                    echo "<td id='".$fila->id_poblacion."'>" . $fila->Nombre_Poblacion . "</td>";
                    echo "<td><button onclick='mostrarDatosAlumno()' id='".$id_oferta."'>Alumnos inscritos</button></td>";
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

<?php

function mostrarDatosAlumno($conexion, $id_oferta) {

    echo " <div id='modalEmpresa' class='modal' style='display: block;'>
    <div class='modal-content'>
    <span class='close' onclick=\"cerrarModal('modalEmpresa')\">&times;</span>  
    <h2>Alumnos inscritos</h2>";
    
    // Realizar consulta para obtener los id_usuario de inscribir
    $sql = "SELECT id_usuario FROM inscribir WHERE id_oferta = :id_oferta";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        $usuarios = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $usuarios[] = $fila->id_usuario;
        }

        // Recorrer los id_usuario obtenidos y realizar consultas adicionales
        foreach ($usuarios as $id_usuario) {
            // Consulta para obtener datos de la tabla alumno
            $sql_alumno = "SELECT * FROM alumno WHERE id_usuario = :id_usuario";
            $stmt_alumno = $conexion->prepare($sql_alumno);
            $stmt_alumno->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            // Ejecuta la consulta
            if ($stmt_alumno->execute()) {
                while ($fila_alumno = $stmt_alumno->fetch(PDO::FETCH_OBJ)) {
                    // Almacena los datos en variables o haz lo que sea necesario
                    $nombre = $fila_alumno->nombre;
                    // ... otros campos ...
                }

                // Imprime o retorna los datos como sea necesario
                echo $nombre;
            }
        }
    }
}

?>