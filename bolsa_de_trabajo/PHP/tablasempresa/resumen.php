<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">     
    <title>Resumen</title>
    <style>



    </style>
</head>
<body>
    <?php
    include("../includes/cabecera_registrado.php");
    include("../includes/conexion.php");
    include("../includes/funciones.php");
    ?>
    <?php if ($_SESSION['tipoUsuario']!="empresa") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
    }?>
    
    <main id="mainofertaspublicadasempresa">

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
           
            $id_usuario=$_SESSION['id_usuario'];

            // Consulta para obtener las ofertas de trabajo paginadas

            $sql = "SELECT OT.id_oferta as id_oferta, OT.titulo AS Titulo, OT.descripcion_oferta AS Descripcion_Oferta, OT.fecha_publicacion AS Fecha_Publicacion, OT.duracion_contrato AS Duracion_Contrato, OT.carnet_conducir AS Carnet_Conducir, P.nombre AS Nombre_Poblacion, P.id_poblacion as id_poblacion FROM oferta_trabajo AS OT JOIN poblacion AS P ON OT.id_poblacion = P.id_poblacion JOIN empresa AS E ON OT.id_usuario = E.id_usuario WHERE E.id_usuario=$id_usuario ";
            
            $consulta = $conexion->prepare($sql);
            
            // Mostrar resultados en la tabla
            if ($consulta->execute()) {
                while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id_oferta = $fila->id_oferta;
                    // Imprimir cada fila de la tabla
                    echo "<tr>";
                    echo "<td>" . $fila->Titulo . "</td>";
                    echo "<td>" . $fila->Descripcion_Oferta . "</td>";
                    echo "<td>" . date('d-m-Y', strtotime($fila->Fecha_Publicacion)) . "</td>";                     
                    echo "<td>" . $fila->Duracion_Contrato . "</td>";
                    echo "<td>" . ($fila->Carnet_Conducir ? "Sí" : "No") . "</td>";
                    echo "<td id='".$fila->id_poblacion."'>" . $fila->Nombre_Poblacion . "</td>";
                    echo "<td>";
                    echo "<button class='btn_inscritos' data-modal-id='$id_oferta'>Alumnos inscritos</button></td>";
                    echo "</tr>";
            }
                
                
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
        </main>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var modal = crearModal();
    document.body.appendChild(modal);

    var cerrarModalButton = document.getElementById('cerrarModal');

    cerrarModalButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    function cargarVentanaModal(id_oferta) {
        fetch('/PHP/tablasempresa/obtener_datos_alumnos.php?id_oferta=' + id_oferta)
            .then(response => response.json())
            .then(datosAlumnos => {
                pintarDatosEnModal(datosAlumnos);
                modal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error al parsear JSON: ', error);
            });
    }

    function pintarDatosEnModal(datosAlumnos, id_oferta) {
        var datosAlumnosDiv = document.getElementById('datosAlumnos');
        datosAlumnosDiv.innerHTML = '';

        datosAlumnos.forEach(function(alumno) {
            var alumnoDiv = document.createElement('div');
            alumnoDiv.textContent = alumno.nombre ;
            datosAlumnosDiv.appendChild(alumnoDiv);

            var botonCurriculum = document.createElement('button');
            botonCurriculum.textContent = 'Ver perfil';
            botonCurriculum.className = 'botonPerfil';
            botonCurriculum.addEventListener('click', function() {
            // Verifica que haya datos en la respuesta
                // Tomamos el id_usuario del primer elemento (puedes ajustar según tus necesidades)
                    var id_usuario = datosAlumnos[0].id_usuario;

                // Redirige a la página del currículum utilizando el archivo PHP correspondiente y el id_usuario
                    window.location.href = '../../PHP/tablasempresa/vercurriculum.php?id_usuario=' + id_usuario;
                } 
            )

            alumnoDiv.appendChild(botonCurriculum);

            datosAlumnosDiv.appendChild(alumnoDiv);
    });
        
    }

    var buttons = document.querySelectorAll('.btn_inscritos');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id_oferta = this.getAttribute('data-modal-id');
            cargarVentanaModal(id_oferta);
        });
    });

    // Función para crear la modal dinámicamente
    function crearModal() {
        var modal = document.createElement('div');
        modal.id = 'miModal';
        modal.className = 'modal';

        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';

        var closeButton = document.createElement('span');
        closeButton.className = 'closeI';
        closeButton.id = 'cerrarModal';
        closeButton.textContent = '×';

        var modalTitle = document.createElement('h2');
        modalTitle.textContent = 'Alumnos inscritos';

        var modalData = document.createElement('div');
        modalData.id = 'datosAlumnos';

        modalContent.appendChild(closeButton);
        modalContent.appendChild(modalTitle);
        modalContent.appendChild(modalData);

        modal.appendChild(modalContent);

        return modal;
    }
});
</script>

<?php
    include("../includes/footer.php");
?>

</body>
</html>

<script src="../../JS/tablasempresa/resumen.js"></script>