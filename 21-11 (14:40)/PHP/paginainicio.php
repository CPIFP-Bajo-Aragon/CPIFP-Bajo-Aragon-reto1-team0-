<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include("includes/conexion.php");
        include("includes/funciones.php");
    ?>
</head>
<body>
    <?php
    $cantidad=validarusuario($conexion);
        // Muestra la cantidad de registros que coinciden
        if ($cantidad > 0) {
            echo "Los datos son correctos. Coinciden $cantidad registros.";
        } else {
            echo "Los datos no son correctos. No se encontraron coincidencias.";
        }
        ?>
</body>
</html>