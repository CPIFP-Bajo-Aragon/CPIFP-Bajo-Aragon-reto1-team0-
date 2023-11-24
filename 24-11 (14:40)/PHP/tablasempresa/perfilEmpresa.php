<?php
    session_start();
    
    if ($_SESSION['tipoUsuario']!="empresa") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        header("Location: inicio");
        exit();
    }

    include("../includes/conexion.php");
    include("../includes/funciones.php");
    $id_usuario=$_SESSION['id_usuario'];

    //MOSTRAR PERFIL
    
    $sqlEmpresa="SELECT * FROM empresa WHERE id_usuario=$id_usuario";
    $stmt = $conexion->prepare($sqlEmpresa);
    
    // Ejecuta la consulta
    if ($stmt->execute()) {

        // Itera a través de las empresas y genera opciones HTML
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $cif = $fila->cif;
            $nombre = $fila->nombre_empresa;
            $direccion = $fila->direccion;
            $descripcion = $fila->descripcion;
            $telefono= $fila->telefono;
            $id_poblacion=$fila->id_poblacion;
            $id_sector=$fila->id_sector;
        }
    }

    // Guarda el nombre de la población 
    $sqlPoblacion="SELECT nombre FROM poblacion as p JOIN empresa as e ON e.id_poblacion=p.id_poblacion WHERE e.id_usuario=$id_usuario";
    $consultaPoblacion = $conexion->prepare($sqlPoblacion);
    $consultaPoblacion->execute();
    $nombrePoblacion = $consultaPoblacion->fetchColumn();

    // Guarda el nombre del sector 
    $sqlSector="SELECT nombre_sector FROM sector as s JOIN empresa as e ON e.id_sector=s.id_sector WHERE e.id_usuario=$id_usuario";
    $consultaSector = $conexion->prepare($sqlSector);
    $consultaSector->execute();
    $nombreSector = $consultaSector->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Editar</title>
</head>
<body>
<?php include("../includes/cabecera_registrado.php");?>
    <div>
        <!-- ISSET -->
            <?php
                // Verificar si el formulario se ha enviado
                if (isset($_POST['Guardar'])) {
                    // Recoger los datos del formulario
                    $nombre_empresa = $_POST['nombre_empresa'];
                    $cif = $_POST['cif'];
                    $direccion = $_POST['direccion'];
                    $descripcion = $_POST['descripcion'];
                    $telefono = $_POST['telefono'];
                    $poblacion = $_POST['poblacion'];
                    $sector = $_POST['sector'];
            
                    // Guarda el id de la población 
                    $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
                    $consultaPoblacion = $conexion->prepare($sqlPoblacion);
                    $consultaPoblacion->execute();
                    $poblacion = $consultaPoblacion->fetchColumn();
            
                    // Guarda el id del sector 
                    $sqlSector="SELECT s.id_sector FROM sector as s JOIN empresa as e WHERE s.nombre_sector='$sector'";
                    $consultaSector = $conexion->prepare($sqlSector);
                    $consultaSector->execute();
                    $sector = $consultaSector->fetchColumn();
            
                    // Actualizar los datos en la base de datos
                    $update_empresa_sql = "UPDATE empresa 
                                        SET cif = ?, nombre_empresa = ?,  direccion = ? ,descripcion = ?, telefono = ?, id_poblacion = ?, id_sector = ?
                                        WHERE id_usuario = ?";
                    $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
                    $update_empresa_stmt->execute([$cif, $nombre_empresa, $direccion, $descripcion, $telefono, $poblacion, $sector, $id_usuario]);
            
                    // Manejar errores o mostrar un mensaje de éxito
                    if ($update_empresa_stmt->rowCount() > 0) {
                        echo "Actualización exitosa";
                    } else {
                        echo "Error en la actualización";
                    }
                }
            ?>
        <!-- Navegación de migas de pan -->
        <ul class="breadcrumb">
            <li><a href="pagina-empresa">Menú</a></li>
            <li>Editar Usuario</li>
        </ul> 

        <div>
                <form action="" method="post" class="formulariodatos">
                    <label for="cif">CIF:</label>
                    <input type="text" name="cif" placeholder="Cif" value="<?php echo $cif ?>" placeholder="CIF"> 

                    <label for="nombre_empresa">Nombre:</label>
                    <input type="text" name="nombre_empresa" placeholder="Nombre" value="<?php echo $nombre ?>" placeholder="Nombre Empresa">

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" placeholder="Direccion" value="<?php echo $direccion ?>" placeholder="Direccion">

                    <?php
                        // Obtener la longitud del texto
                        $longitud_descripcion = strlen($descripcion);

                        // Establecer una longitud promedio de línea (ajústala según tus necesidades)
                        $longitud_promedio_linea_descripcion = 50;

                        // Calcular la cantidad aproximada de filas necesarias
                        $filas_descripcion = ceil($longitud_descripcion / $longitud_promedio_linea_descripcion);
                    ?>

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" placeholder="Descripcion" rows="<?php echo $filas_descripcion; ?>"><?php echo $descripcion ?></textarea>

                    <label for="telefono">Telefono:</label>
                    <input type="text" name="telefono" placeholder="Telefono" value="<?php echo $telefono ?>" placeholder="Telefono">

                    <label for="poblacion">Poblacion:</label>
                    <input type="text" name="poblacion" placeholder="Poblacion" value="<?php echo $nombrePoblacion ?>" placeholder="Poblacion">

                    <label for="sector">Sector:</label>
                    <input type="text" name="sector" placeholder="Sector" value="<?php echo $nombreSector ?>" placeholder="Sector">

                    <input type="submit" name="Guardar" value="Guardar">
                </form>
        </div>
    </div>
    <?php include("../includes/footer.php");?>
</body>
</html>
<script src="../../JS/tablasempresa/perfilempresa.js"></script>
