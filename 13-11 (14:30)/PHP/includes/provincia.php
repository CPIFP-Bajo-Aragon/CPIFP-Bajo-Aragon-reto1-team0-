<?php
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">';
    
    include("conexion.php");
    //si se ha recibido el parametro "provincia" a traves de GET
    if (isset($_GET['provincia'])) {
        $provinciaSeleccionada = $_GET['provincia'];

        try {
            
            $sql_provincia = "SELECT id_provincia FROM provincia WHERE nombre = :provincia";
            $stmt_provincia = $conexion->prepare($sql_provincia);
            $stmt_provincia->bindParam(':provincia', $provinciaSeleccionada);
            $stmt_provincia->execute();

            $idprovincia = $stmt_provincia->fetchColumn();

            // Consulta para obtener las poblaciones de la provincia seleccionada
            $sql_poblaciones = "SELECT * FROM poblacion WHERE id_provincia = :idprovincia";
            $stmt_poblaciones = $conexion->prepare($sql_poblaciones);
            $stmt_poblaciones->bindParam(':idprovincia', $idprovincia, PDO::PARAM_INT);
            $stmt_poblaciones->execute();

            //opciones de poblaciones
            $options = '<option value="">Selecciona una población</option>';
            while ($fila_poblacion = $stmt_poblaciones->fetch(PDO::FETCH_OBJ)) {
                $id_poblacion = $fila_poblacion->id_poblacion;
                $nombre = $fila_poblacion->nombre;
                $options .= "<option value='$id_poblacion'>$nombre</option>";
            }

            echo $options;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Esto es para cerrar la consulta porque si no vuelve a omprimir todas las provincias debajo de las poblaciones devueltas.
        exit;
    }
?>

    <select id="provinciaSelect">
        <?php
        try {
            

            //opciones de provincias
            $sql = "SELECT * FROM provincia";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $nombre = $fila->nombre;
                echo "<option value='$nombre'>$nombre</option>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </select>

    <select id="poblacionSelect">
        <!-- Aqui se cargan las poblaciones de forma asincrona una vez seleccionada la provincia-->
    </select>

    <script>
    var provinciaSelect = document.getElementById('provinciaSelect');
    var poblacionSelect = document.getElementById('poblacionSelect');

    provinciaSelect.addEventListener('change', function () {
        var selectedProvincia = provinciaSelect.value;
        fetch('../includes/provincia.php?provincia=' + selectedProvincia)
            .then(function (response) {
                if (response.status === 200) {
                    return response.text();
                } else {
                    console.log('Error al cargar las poblaciones');
                    return '';
                }
            })
            .then(function (data) {
                poblacionSelect.innerHTML = data;
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    });
</script>
