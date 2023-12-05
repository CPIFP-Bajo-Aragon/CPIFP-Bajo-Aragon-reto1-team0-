<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum</title>
    <link rel="stylesheet" href="../../CSS/index.css">
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <style>
        @media (max-width: 700px) {
           .button-container{
                margin-left: 100px;
           }
        }
    </style>
</head>

<?php 
include("../includes/links.php");
include("../includes/funciones.php"); 
include("../includes/cabecera_registrado.php");

$experiencias = obtenerExperienciaLaboral($conexion, $id_usuario);
$estudios = obtenerEstudios($conexion, $id_usuario);
$idiomas = obtenerIdiomas($conexion, $id_usuario);

?>

<body class="curriculum">
    <?php if ($_SESSION['tipoUsuario']!="alumno") {
            // No ha iniciado sesión, redirige a la página de inicio de sesión
            header("Location: inicio");
            exit();
        }?>

    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul>

    <div class="button-container">
        <button id="exportButton" class="btncv"><i class="fas fa-file-pdf"></i> PDF</button>
        <a href="curriculum-ingles" class="btncv">Ingles</a>
    </div>

    <main id ="maincurriculumalumno" >
            <aside class="asidecurriculum">
                <section>
                    <h2>PERFIL <i class="far fa-user"></i> </h2>

                    <div>
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $mostrar['nombre'] ?>" readonly style="border: none">
                    </div>

                    <div>
                        <label for="apellidos"> Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?php echo $mostrar['apellidos'] ?>" readonly style="border: none">
                    </div>

                    <div>
                        <label for="fecha_nacim"> Fecha Nacimiento:</label>
                        <input type="date" id="fecha_nacim" name="fecha_nacim"
                            value="<?php echo date('Y-m-d', strtotime($mostrar['fecha_nacim'])); ?>" readonly style="border: none">
                    </div>
                </section>
                <section>
                    <h2>CONTACTO <i class="fas fa-address-book"></i></h2>
                    <div>
                        <label for="telefono"><i class="fas fa-phone-alt"></i> Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo $mostrar['telefono'] ?>" readonly style="border: none">
                    </div>

                    <div>
                        <label for="gmail"><i class="far fa-envelope"></i> Gmail:</label>
                        <input type="email" id="gmail" name="gmail" value="<?php echo $mostrar['correo'] ?>" readonly style="border: none">
                    </div>

                    <div>
                        <label for="direccion"><i class="fas fa-map-marker-alt"></i> Población:</label>
                        <?php
                        $idpoblacion = $mostrar['id_poblacion'];
                        $nombrepoblacion = mostrarPoblacion($conexion, $idpoblacion);
                        ?>
                        <input type="text" id="poblacion" name="poblacion" value="<?php echo $nombrepoblacion ?>" readonly style="border: none">
                    </div>

                
                </section>

                <section>
            
                <h2>APTITUDES <i class="far fa-check-square"></i></h2>
                    <div>
                        <label for="carnet"> Carnet de Conducir:</label>
                        <?php if ($mostrar['carnet_conducir'] == 1): ?>
                        <input type="text" value="Si" readonly>
                        <?php else: ?>
                        <input type="text" value="No" readonly>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="vehiculo_propio"> Vehiculo Propio:</label>
                        <?php if ($mostrar['vehiculo_propio'] == 1): ?>
                        <input type="text" value="Si" readonly>
                        <?php else: ?>
                        <input type="text" value="No" readonly>
                        <?php endif; ?>
                    </div>
                    

                    <div id="crear1">
                        <label for="aptitudes"> Aptitudes:</label>
                        <textarea id="aptitudes" name="aptitudes" rows="4"
                            readonly><?php echo $mostrar['aptitudes'];?></textarea>
                    </div>

                </section>
                <section>
                    <h2>ACTITUDES <i class="far fa-thumbs-up"></i></h2>

                    <div id="crear2">
                        <label for="actitudes"> Actitudes:</label>
                        <textarea id="actitudes" name="actitudes" rows="4"
                            readonly><?php echo $mostrar['actitudes'];?></textarea>

                    </div>

                </section>
            </aside>

            <article  class="articlecurriculum">
            <section>
                    <h2>EXPERIENCIA LABORAL <i class="fas fa-briefcase"></i></h2>
                    <?php foreach ($experiencias as $experiencia): ?>
                        <div class="experiencia">
                            <p class="tituloexperiencia"><strong>Nombre Cargo:</strong> <?php echo $experiencia['puesto_trabajo']; ?> </p>
                            <p><strong>Nombre de la Empresa:</strong> <?php echo $experiencia['nombre_empresa']; ?></p>
                            <p><strong>Población:</strong> <?php echo $experiencia['poblacion']; ?></p>
                            <p><strong>Fecha de Inicio:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_inicio'])); ?></p>
                            <p><strong>Fecha de Fin:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_fin'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </section>

                <section >
                    <h2>FORMACIÓN ACADÉMICA <i class="fas fa-graduation-cap"></i></h2>
                    
                        <?php foreach ($estudios as $estudio): ?>
                            <div class="formacion">
                            <p> <strong>Nombre Estudio:</strong> <?php echo $estudio['nombre_estudio']; ?> </p>
                            <p>  <strong>Nombre Instituto:</strong> <?php echo $estudio['nombre_instituto']; ?> </p>
                            </div>
                        <?php endforeach; ?>
                    
                </section>

                <section >
                    <h2>IDIOMAS <i class="fas fa-language"></i></h2>
                    
                        <?php foreach ($idiomas as $idioma): ?>
                        <div class="idiomas">
                        <p>
                            <strong>Idioma:</strong> <?php echo $idioma['nombre']; ?>
                            <strong>Nivel:</strong> <?php echo $idioma['nivel']; ?>
                        </p>
                        </div>
                        <?php endforeach; ?>
                
                </section>
            </article>
    </main>
   
        <?php include "../includes/footer.php" ?>
   

</body>

</html>
<script>
    document.getElementById('exportButton').addEventListener('click', function () {
        const confirmacion = window.confirm('¿Deseas descargar el PDF?');

        if (confirmacion) {
        
            const contenidoCuerpo = document.getElementById('maincurriculumalumno');
            html2pdf(contenidoCuerpo, {
                filename: 'curriculum.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { format: 'a4', orientation: 'portrait' }
            });
        }
    });
</script>

<script src="../../JS/tablas_alumno/crearcurriculum.js"></script>
