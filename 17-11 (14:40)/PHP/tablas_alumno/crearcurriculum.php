<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum</title>
    <link rel="stylesheet" href="../../CSS/curriculum.css">
    <link rel="stylesheet" href="../../CSS/index.css">

</head>

<?php 
include("../includes/funciones/funcionesalumnos.php"); 
 include("../includes/cabecera_registrado.php"); 
 
 $experiencias = obtenerExperienciaLaboral($conexion, $id_usuario);
 $estudios = obtenerEstudios($conexion, $id_usuario);
 $idiomas = obtenerIdiomas($conexion, $id_usuario);

 ?>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="pagina-alumno">Menú</a></li>
        <li>Buscar Ofertas</li>
    </ul> 
    <main>
        <aside>
            <section>
                <h2>PERFIL</h2>

                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $mostrar['nombre'] ?>">
                </div>

                <div>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $mostrar['apellidos'] ?>">
                </div>
            </section>
            <section>
                <h2>CONTACTO</h2>
                <div>
                    <label for="telefono">Telefono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo $mostrar['telefono'] ?>">
                </div>

                <div>
                    <label for="gmail">Gmail:</label>
                    <input type="email" id="gmail" name="gmail" value="<?php echo $mostrar['correo'] ?>">
                </div>

                <div>
                    <label for="direccion">Poblacion:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $mostrar['id_poblacion'] ?>">
                </div>


                <div>
                    <label for="fecha_nacim">Fecha Nacimiento:</label>
                    
                    <input type="date" id="fecha_nacim" name="fecha_nacim" value="<?php echo $mostrar['fecha_nacim'] ?> ">
                </div>

                <div>
                    <label for="edad">Carnet de Conducir:</label>
                    <input type="text" name="carnet" placeholder="Carnet" value="<?php echo $mostrar['carnet_conducir'] ?>"> 
                </div>
            </section>

            <section>
                <h2>APTITUDES</h2>
                
                <div id="crear1">
                    <label for="actitudes">Aptitud:</label>
                    <textarea id="aptitudes" name="aptitudes" rows="4" cols="50" style="width: 10px;  border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['aptitudes'];?></textarea>
                </div>
              
            </section>
            <section>
                <h2>ACTITUDES</h2>
               
                <div id="crear2">
                    <label for="actitud">Actitudes:</label>
                    <textarea id="actitudes" name="actitudes" rows="4" cols="50" style="width: 10px;  border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['actitudes'];?></textarea>
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
                        <strong>Poblacion:</strong> <?php echo $experiencia['nombre_poblacion']; ?><br>
                        <strong>Fecha de Inicio:</strong> <?php echo $experiencia['fecha_inicio']; ?><br>
                        <strong>Fecha de Fin:</strong> <?php echo $experiencia['fecha_fin']; ?><br>
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

</html>
