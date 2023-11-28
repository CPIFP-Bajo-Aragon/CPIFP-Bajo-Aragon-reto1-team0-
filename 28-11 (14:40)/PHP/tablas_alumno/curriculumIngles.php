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
include("../includes/links.php");
include("../includes/funciones.php"); 
include("../includes/cabecera_registrado.php");

$experiencias = obtenerExperienciaLaboral($conexion, $id_usuario);
$estudios = obtenerEstudios($conexion, $id_usuario);
$idiomas = obtenerIdiomas($conexion, $id_usuario);

?>

<body class="curriculum">

    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul>
    <div class="button-container">
    <button id="exportButton" class="btncv"><i class="fas fa-file-pdf"></i> PDF</button>
    <a href="curriculum-alumno" class="btncv">Español</a>
</div>

    <main id="maincurriculumalumno">

<aside class="asidecurriculum">
    <section>
        <h2>PROFILE <i class="far fa-user"></i> </h2>

        <div>
            <label for="nombre">Name:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $mostrar['nombre'] ?>" readonly style="border: none">
        </div>

        <div>
            <label for="apellidos">Last Name:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $mostrar['apellidos'] ?>" readonly style="border: none">
        </div>

        <div>
            <label for="fecha_nacim">Date of Birth:</label>
            <input type="date" id="fecha_nacim" name="fecha_nacim"
                value="<?php echo date('Y-m-d', strtotime($mostrar['fecha_nacim'])); ?>" readonly style="border: none">
        </div>
    </section>
    <section>
        <h2>CONTACT <i class="fas fa-address-book"></i></h2>
        <div>
            <label for="telefono"><i class="fas fa-phone-alt"></i> Phone:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo $mostrar['telefono'] ?>" readonly style="border: none">
        </div>

        <div>
            <label for="gmail"><i class="far fa-envelope"></i> Gmail:</label>
            <input type="email" id="gmail" name="gmail" value="<?php echo $mostrar['correo'] ?>" readonly style="border: none">
        </div>

        <div>
            <label for="direccion"><i class="fas fa-map-marker-alt"></i> Location:</label>
            <?php
            $idpoblacion = $mostrar['id_poblacion'];
            $nombrepoblacion = mostrarPoblacion($conexion, $idpoblacion);
            ?>
            <input type="text" id="poblacion" name="poblacion" value="<?php echo $nombrepoblacion ?>" readonly style="border: none">
        </div>

    </section>

    <section>

        <h2>SKILLS <i class="far fa-check-square"></i></h2>
        <div>
            <label for="carnet"> Driving License:</label>
            <?php if ($mostrar['carnet_conducir'] == 1): ?>
            <input type="text" value="Yes" readonly>
            <?php else: ?>
            <input type="text" value="No" readonly>
            <?php endif; ?>
        </div>


        <div id="crear1">
            <label for="aptitudes"> Skills:</label>
            <textarea id="aptitudes" name="aptitudes" rows="4"
                readonly><?php echo $mostrar['aptitudes'];?></textarea>
        </div>

    </section>
    <section>
        <h2>ATTITUDES <i class="far fa-thumbs-up"></i></h2>

        <div id="crear2">
            <label for="actitudes"> Attitudes:</label>
            <textarea id="actitudes" name="actitudes" rows="4"
                readonly><?php echo $mostrar['actitudes'];?></textarea>

        </div>

    </section>
</aside>

<article class="articlecurriculum">
    <section>
        <h2>WORK EXPERIENCE <i class="fas fa-briefcase"></i></h2>
        <?php foreach ($experiencias as $experiencia): ?>
            <div class="experiencia">
                <p class="tituloexperiencia"><strong>Job Title:</strong> <?php echo $experiencia['puesto_trabajo']; ?> </p>
                <p><strong>Company Name:</strong> <?php echo $experiencia['nombre_empresa']; ?></p>
                <p><strong>Location:</strong> <?php echo $experiencia['poblacion']; ?></p>
                <p><strong>Starting Date:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_inicio'])); ?></p>
                <p><strong>Ending Date:</strong><?php echo date('d/m/Y', strtotime($experiencia['fecha_fin'])); ?></p>
            </div>
        <?php endforeach; ?>
    </section>

    <section>
        <h2>EDUCATION <i class="fas fa-graduation-cap"></i></h2>

        <?php foreach ($estudios as $estudio): ?>
            <div class="formacion">
            <p> <strong>Study Name:</strong> <?php echo $estudio['nombre_estudio']; ?> </p>
            <p> <strong>Institute Name:</strong> <?php echo $estudio['nombre_instituto']; ?> </p>
            </div>
        <?php endforeach; ?>

    </section>

    <section>
        <h2>LANGUAGES <i class="fas fa-language"></i></h2>

        <?php foreach ($idiomas as $idioma): ?>
        <div class="idiomas">
        <p>
            <strong>Language:</strong> <?php echo $idioma['nombre']; ?>
            <strong>Level:</strong> <?php echo $idioma['nivel']; ?>
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
