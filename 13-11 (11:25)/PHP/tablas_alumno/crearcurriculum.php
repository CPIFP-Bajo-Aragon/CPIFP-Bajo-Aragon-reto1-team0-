<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu Currículum</title>
<link rel="stylesheet" href="../../CSS/curriculum.css">
</head>
<body>
    <?php include("../includes/funcionesAlumno.php"); ?>
    <header>
        <?php include("../includes/cabecera_alumno.php"); ?>

    </header>

    <main>
        <aside>
            <section>
            <div class="imagen">

            </div>
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
                    <label for="direccion">Direccion:</label>
                    <input type="text" id="direccion" name="direccion">
                </div>

                <div>
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad">
                </div>

                <div>
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad">
                </div>

                <div>
                    <label for="edad">Carnet de Conducir:</label>
                    <input type="text" name="carnet" placeholder="Carnet" value="<?php echo $mostrar['carnet_conducir'] ?>">                </div>
            </section>
            
            <section>
                <h2>APTITUDES</h2>
                <div>
                    <label for="actitudes">Aptitud:</label>
                    <textarea id="actitudes" name="actitudes" rows="4" cols="50"  value="<?php echo $mostrar['actitudes'] ?>"></textarea>
                </div>
                <button>Añadir</button>

            </section>
            <section>
                <h2>ACTITUDES</h2>
                <div>
                    <label for="actitud">Actitudes:</label>
                    <input type="text" name="actitud" placeholder="Actitud" value="<?php echo $mostrar['actitudes'] ?>">
                </div>
                <button>Añadir</button>

            </section>
        </aside>
        
        <article>
            <section>
            <div class="unionEuropea">
            <img src="../../img/unionEuropea.png" alt="Logo Unión Europea" width="200px" height="50px">   
             </div>

                <h2>EXPERIENCIA LABORAL</h2>
                <div>
                    <label for="cargo">Nombre Cargo:</label>
                    <input type="text" id="cargo" name="cargo">
                </div>

                <div>
                    <label for="empresa">Nombre de la Empresa:</label>
                    <input type="text" id="empresa" name="empresa">
                </div>

                <div>
                    <label for="descripcion">Descripcion:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea>
                </div>

                <div>
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha">
                </div>

                <div>
                    <label for="poblacion">Poblacion:</label>
                    <input type="text" id="poblacion" name="poblacion">
                </div>

                <button>Añadir</button>
            </section>

            <section>
                <h2>FORMACIÓN ACADÉMICA</h2>
                <div>
                    <label for="estudio">Nombre Estudio:</label>
                    <input type="text" id="estudio" name="estudio">
                </div>

                <div>
                    <label for="institucion">Nombre institucion:</label>
                    <input type="text" id="institucion" name="institucion">
                </div>

                <div>
                    <label for="fecha_formacion">Fecha:</label>
                    <input type="date" id="fecha_formacion" name="fecha_formacion">
                </div>

                <div>
                    <label for="poblacion_formacion">Poblacion:</label>
                    <input type="text" id="poblacion_formacion" name="poblacion_formacion">
                </div>
                <button>Añadir</button>
            </section>

            <section>
                <h2>IDIOMAS</h2>
                <div>
                    <label for="idiomas">Idiomas:</label>
                    <textarea id="idiomas" name="idiomas" rows="4" cols="50"></textarea>
                </div>
                <button>Añadir</button>

            </section>
        </article>
    </main>
</body>
</html>