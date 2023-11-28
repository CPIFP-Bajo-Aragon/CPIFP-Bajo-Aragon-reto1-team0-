<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum</title>
    <link rel="stylesheet" href="../../CSS/index.css">
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

</head>

<?php 
include("../includes/funciones.php"); 

$id_usuario = $_GET['id_usuario'];

//DATOS ALUMNO
$sql = "SELECT usuario.*, alumno.*, poblacion.nombre as nombre_poblacion
            FROM usuario 
            LEFT JOIN alumno ON usuario.id_usuario = alumno.id_usuario
            LEFT JOIN poblacion ON alumno.id_poblacion = poblacion.id_poblacion
            WHERE usuario.id_usuario = :id_usuario";



    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mostrar = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Manejar errores si la consulta no es exitosa
        // echo "Error en la consulta: No se encontraron datos para el usuario con ID: $id_usuario";
    }

 
 $experiencias = obtenerExperienciaLaboral($conexion, $id_usuario);
 $estudios = obtenerEstudios($conexion, $id_usuario);
 $idiomas = obtenerIdiomas($conexion, $id_usuario);



 

 ?>

<body>
    
    <!-- <?php if ($_SESSION['tipoUsuario']!="alumno") {
        // No ha iniciado sesión, redirige a la página de inicio de sesión
        //header("Location: inicio");
        //exit();
    }?> -->

    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="resumen-empresa">Resumen</a></li>
        <li>Curriculum</li>
    </ul>

    <button id="exportButton"><i class="fa-regular fa-file-pdf"></i></button>

    <!-- <button onclick="imprimirCuerpo()">Imprimir Currículum</button> -->
    <main id="contenido-cuerpo">

        <aside>
            <section>
                <h2>PERFIL</h2>

                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $mostrar['nombre'] ?>" readonly style="border: none;">
                </div>

                <div>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $mostrar['apellidos'] ?> " readonly style="border: none;">
                </div>
            </section>
            <section>
                <h2>CONTACTO</h2>
                <div>
                    <label for="telefono">Telefono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo $mostrar['telefono'] ?>" readonly style="border: none;">
                </div>

                <div>
                    <label for="gmail">Gmail:</label>
                    <input type="email" id="gmail" name="gmail" value="<?php echo $mostrar['correo'] ?>" readonly style="border: none;">
                </div>

                <div>
                    <label for="direccion">Poblacion:</label>
                    <?php
                    $idpoblacion=$mostrar['id_poblacion'];
                    $nombrepoblacion=mostrarPoblacion($conexion, $idpoblacion);
                    ?>
                    <input type="text" id="poblacion" name="poblacion" value="<?php echo $nombrepoblacion  ?>" readonly style="border: none;">
                </div>


                <div>
                    <label for="fecha_nacim">Fecha Nacimiento:</label>
                    
                    <input type="date" id="fecha_nacim" name="fecha_nacim" value="<?php echo date('Y-m-d', strtotime($mostrar['fecha_nacim'])); ?>" readonly style="border: none;">
                </div>

                <div>
                    <label for="carnet">Carnet de Conducir:</label>
                   
                        <?php if ($mostrar['carnet_conducir'] == 1): ?>
                            <input type="text"  value="Si" readonly  style="border: none;">
                        <?php else: ?>
                            <input type="text"  value="No" readonly style="border: none;">
                          
                        <?php endif; ?>
                </div>
            </section>

            <section>
                <h2>APTITUDES</h2>
                
                <div id="crear1">
                    <label for="actitudes">Aptitud:</label>
                    <textarea id="aptitudes" name="aptitudes" rows="4" cols="50" style="width: 10px; margin-top: 8px; border: none;"readonly><?php echo $mostrar['aptitudes'];?></textarea>
                </div>
              
            </section>
            <section>
                <h2>ACTITUDES</h2>
               
                <div id="crear2">
                    <label for="actitud">Actitudes:</label>
                    <textarea id="actitudes" name="actitudes" rows="4" cols="50" style="width: 10px; margin-top: 8px;  border: none;" readonly><?php echo $mostrar['actitudes'];?></textarea>

                </div>
          
            </section>
        </aside>

        <article>
        <section class="experiencia">
            <h2>EXPERIENCIA LABORAL</h2><br>
            <div>
                <?php foreach ($experiencias as $experiencia): ?>
                    <p>
                        <strong>Nombre Cargo:</strong> <?php echo $experiencia['puesto_trabajo']; ?><br>
                        <strong>Nombre de la Empresa:</strong> <?php echo $experiencia['nombre_empresa']; ?><br>
                        <strong>Poblacion:</strong> <?php echo $experiencia['poblacion']; ?><br>
                        <!-- <strong>Fecha de Inicio:</strong> <?php echo $experiencia['fecha_inicio']; ?><br>
                        <strong>Fecha de Fin:</strong> <?php echo $experiencia['fecha_fin']; ?><br> -->
                        <strong>Fecha de Inicio:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_inicio']));?><br>
                        <strong>Fecha de Fin:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_fin']));?>
                    </p>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="formacion">
            <h2>FORMACIÓN ACADÉMICA</h2>
            <div>
                <?php foreach ($estudios as $estudio): ?>
                    <p>
                        <strong>Nombre Estudio:</strong> <?php echo $estudio['nombre_estudio']; ?><br>
                        <strong>Nombre Instituto:</strong> <?php echo $estudio['nombre_instituto']; ?><br>
                    </p>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="idiomas">
            <h2>IDIOMAS</h2>
            <div>
                <?php foreach ($idiomas as $idioma): ?>
                    <p>
                        <strong>Idioma:</strong> <?php echo $idioma['nombre']; ?><br>
                        <strong>Nivel:</strong> <?php echo $idioma['nivel']; ?><br>
                    </p>
                <?php endforeach; ?>
            </div>
        </section>
        </article>

        
    </main>
   
</body>
<?php include("../includes/footer.php");?>
</html>
<script>

    //event llistener para recoger el id del boton
    document.getElementById('exportButton').addEventListener('click', function() {
        // Muestra un mensaje de confirmación
        const confirmacion = window.confirm('¿Deseas descargar el PDF?');

        if (confirmacion) {
            // si se hace la confirmacion se recoge el contenido main que quiero exportar
            const contenidoCuerpo = document.getElementById('contenido-cuerpo');
            //uso de la biblioteca html2pdf, recoge la variable contenidoCuerpo y lo convierte a pdf
            html2pdf(contenidoCuerpo, {
                filename: 'curriculum.pdf',
                //escala del lienzo html2canvas que hace una captura para convertirlo en imagen antes de pasarlo a pdf
                //el dos indica que se usaran el doble de pixeles, para mejorar la calidad
                html2canvas: { scale: 2 },
                //formato y indicar la orientacion en portrait(vertical)
                jsPDF: { format: 'a4', orientation: 'portrait' }
            });
        }
    });
</script>

<script src="../../JS/tablas_alumno/crearcurriculum.js"></script>