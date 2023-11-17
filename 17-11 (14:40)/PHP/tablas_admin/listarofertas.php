<?php
// Inclusión de archivos PHP con funciones y conexión a la base de datos
include("../includes/conexion.php");
include("../includes/funciones.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Configuración del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  link="../CSS/index.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezjwMz0OJnFLFfNf3e1oA00ZHYj7aJ/N62g1R9bcuU/PU4F2KsR2qro1Q8AzNlAa" crossorigin="anonymous">


    <title>Ofertas de Trabajo</title>
</head>

<?php
    // Inclusión de la cabecera de la página desde otro archivo PHP
    include("../includes/cabecera_registrado.php");

    // Manejo de formularios POST para borrar y editar registros de ofertas de trabajo
    if (isset($_POST["activar"])) {
        $id = $_POST["id_oferta"];
        // Prepara la conofertas-adminsulta SQL para actualizar el campo 'validado' a 1
        $sql = "UPDATE usuario SET validado = 1 WHERE id_oferta = :id_oferta";


        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);


        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_oferta', $id);


        // Ejecuta la consulta para actualizar el estado de validación
        $consulta->execute();
    }
    if (isset($_POST["desactivar"])) {
        $id = $_POST["id_oferta"];
        // Prepara la consulta SQL para actualizar el campo 'validado' a 1
        $sql = "UPDATE usuario SET validado = 0 WHERE id_oferta = :id_oferta";


        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);


        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_oferta', $id);


        // Ejecuta la consulta para actualizar el estado de validación
        $consulta->execute();
    }
    if (isset($_POST["editar"])) {
        $id = $_POST["id_oferta"];
        
        //MOSTRAR PERFIL
        $sqlOferta="SELECT * FROM oferta_trabajo WHERE id_oferta='$id'";
        $stmt = $conexion->prepare($sqlOferta);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
    
            // Itera a través de las empresas y genera opciones HTML
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                $titulo = $fila->titulo;
                $descripcion = $fila->descripcion_oferta;
                $duracion_contrato = $fila->duracion_contrato;
                $carnet = $fila->carnet_conducir;
                $poblacion= $fila->id_poblacion;
                $aptitud=$fila->aptitud;

                // Guarda el nombre de la población 
               $sqlPoblacion="SELECT nombre FROM poblacion as p JOIN oferta_trabajo as o ON o.id_poblacion=p.id_poblacion WHERE o.id_oferta=$id";
               $consultaPoblacion = $conexion->prepare($sqlPoblacion);
               $consultaPoblacion->execute();
               $nombrePoblacion = $consultaPoblacion->fetchColumn();

                //FORMULARIO
                echo "<div id='modalEmpresa' class='modal' style='display: block;'>";
                echo "<div class='modal-content'>";
                echo "<span class='close' onclick=\"cerrarModal('modalEmpresa')\">&times;</span>";  
                echo "<h2>Editar oferta</h2>";
                echo "<form action='ofertas-admin' method='POST'>
                    <label for='titulo'>Título</label>
                    <input type='text' name='titulo' placeholder='Título' value='$titulo'>
        
                    <label for='descripcion'>Descripción</label>
                    <input type='text' name='descripcion' placeholder='Descripción' value='$descripcion'>
        
                    <label for='duracion_contrato'>Duración contrato</label>
                    <input type='text' name='duracion_contrato' placeholder='Duración del contrato' value='$duracion_contrato'>
        
                    <label for='carnet'>Carnet</label>
                    <input type='text' name='carnet' value='$carnet'>
        
                    <label for='poblacion'>Población</label>
                    <input type='text' name='poblacion' placeholder='Población' value='$nombrePoblacion'>
        
                    <label for='aptitud'>Aptitudes necesarias</label>
                    <input type='text' name='aptitud' placeholder='Aptitudes' value='$aptitud'>

                    <input type='hidden' name='id_oferta' value='$id'>
        
                    <input type='submit' name='Guardar' value='Guardar' id='Guardar'>
                      </form>";
                echo "</div>";
                echo "</div>";  
                
            }

            }           
    }
        // Verificar si el formulario se ha enviado
        if (isset($_POST['Guardar'])) {
            // Recoger los datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $duracion_contrato = $_POST['duracion_contrato'];
            $carnet = $_POST['carnet'];
            $poblacion = $_POST['poblacion'];
            $aptitud = $_POST['aptitud'];
            $id_oferta = $_POST['id_oferta'];

            // Guarda el id de la población 
            $sqlPoblacion="SELECT p.id_poblacion FROM poblacion as p WHERE p.nombre='$poblacion'" ;
            $consultaPoblacion = $conexion->prepare($sqlPoblacion);
            $consultaPoblacion->execute();
            $poblacionId = $consultaPoblacion->fetchColumn();

            // Actualizar los datos en la base de datos
            $update_empresa_sql = "UPDATE oferta_trabajo 
                                       SET titulo = ?, descripcion_oferta = ?,  duracion_contrato = ? ,carnet_conducir = ?, id_poblacion = ?, aptitud = ?
                                       WHERE id_oferta = ?";
            $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
            $update_empresa_stmt = $conexion->prepare($update_empresa_sql);
            $update_empresa_stmt->bindValue(1, $titulo);
            $update_empresa_stmt->bindValue(2, $descripcion);
            $update_empresa_stmt->bindValue(3, $duracion_contrato);
            $update_empresa_stmt->bindValue(4, $carnet);
            $update_empresa_stmt->bindValue(5, $poblacionId);
            $update_empresa_stmt->bindValue(6, $aptitud);
            $update_empresa_stmt->bindValue(7, $id_oferta);

            $update_empresa_stmt->execute();
        }     
    
    
?>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-admin">Menú</a></li>
        <li>Gestión Ofertas</li>
    </ul> 

    <div>
        <h1 class="titulo">GESTION DE OFERTAS</h1>
    </div>

    <!-- Filtros para búsqueda y filtrado -->
    <?php $max_filas_por_pagina = 4; ?>

    <div id="filtros">
        <div id="fbusqueda">
            <!-- Input para buscar por título -->
            <input type="text" id="filtroTitulo" placeholder="Buscador por Título">
        </div>
        <div id="fpoblacion">
            <select name="poblacionSelect" id="poblacionSelect">
                    <?php
                    listarProvinciaypoblacion($conexion, $select_name)
                    ?>
                    </select>
            
        <div id="meses">
            <!-- Filtro para la duración del contrato -->
            <label for="">Duración del Contrato:</label>
            <input type="range" id="filtroDuracionContrato" min="0" max="24" step="1" value="0">
            <span id="duracionContratoLabel">Cualquier duración</span>
        </div>  
        <div id="conducir">
            <!-- Filtros para requerir carnet de conducir -->
            Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
            <br>
            Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
            <br>
            Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
        </div>
    </div>
    
    <!-- Tabla que muestra la información de las ofertas de trabajo -->
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
                <th>Empresa</th>
                <th>Opciones</th>
            </tr>
            <?php listarofertas($conexion, $max_filas_por_pagina = 4); ?>
            <!-- Elemento div extra no válido dentro de la tabla -->
            <div id="midiv"></div>
        </table>
    </div>
    
    <!-- Inclusión del pie de página desde otro archivo PHP -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>

<!-- Script JavaScript para funcionalidad interactiva en la página -->
<script>
// Espera a que el contenido del documento HTML esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtiene la tabla de ofertas de trabajo
    const tablaOfertas = document.querySelector('#tabla');

    // Filtrado por requerir o no carnet de conducir
    const radioButtons = document.querySelectorAll('input[name="filtroCarnet"]');

    radioButtons.forEach(function (radio) {
        // Añade un evento de cambio a cada botón de radio
        radio.addEventListener('change', function () {
            // Obtiene el valor del botón de radio seleccionado
            const filtro = this.value;
            // Obtiene todas las filas de la tabla excepto la primera (encabezados)
            const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

            // Itera sobre cada fila para aplicar el filtro
            filas.forEach(function (fila) {
                // Obtiene el contenido de la columna "Requiere Carnet de Conducir"
                const columnaCarnet = fila.querySelector('td:nth-child(5)').innerText;

                // Muestra la fila si coincide con el filtro, oculta si no coincide
                if (filtro === 'todos' || columnaCarnet.trim() === (filtro === 'conCarnet' ? 'Sí' : 'No')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });

    // Filtrado por duración del contrato
    const inputDuracionContrato = document.getElementById('filtroDuracionContrato');
    const duracionContratoLabel = document.getElementById('duracionContratoLabel');

    // Añade un evento de entrada al control deslizante de duración del contrato
    inputDuracionContrato.addEventListener('input', function () {
        // Obtiene la duración seleccionada del control deslizante
        const duracionSeleccionada = parseInt(this.value, 10);
        // Actualiza el texto de la etiqueta para reflejar la duración seleccionada
        duracionContratoLabel.textContent = duracionSeleccionada === 0 ? "Cualquier duración" : `Menos de ${duracionSeleccionada} meses`;

        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro de duración del contrato
        filas.forEach(function (fila) {
            // Obtiene el contenido de la columna "Duración del Contrato"
            let columnaDuracion = parseInt(fila.querySelector('td:nth-child(4)').textContent);

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (duracionSeleccionada === 0 || columnaDuracion <= duracionSeleccionada) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    // Filtrado por población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');

    // Añade un evento de cambio al menú desplegable de población
    filtroPoblacionSelect.addEventListener('change', function () {
        // Obtiene la población seleccionada del menú desplegable
        const poblacionSeleccionada = filtroPoblacionSelect.value;
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro por población
        filas.forEach(function (fila) {
            // Obtiene el ID de población de la columna "Población"
            const columnaIdPoblacion = fila.querySelector('td:nth-child(6)').getAttribute('id');

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Filtrado por título mediante entrada de texto
    const filtroTituloInput = document.getElementById('filtroTitulo');

    // Añade un evento de entrada al campo de entrada de texto para el filtro por título
    filtroTituloInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas
        const filtroTexto = this.value.toLowerCase();
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

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

