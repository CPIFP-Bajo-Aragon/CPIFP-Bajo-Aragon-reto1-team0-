<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum</title>
    <link rel="stylesheet" href="../../CSS/curriculum.css">
</head>
<?php include("../includes/funcionesAlumno.php"); ?>
<?php include("../includes/cabecera_registrado.php"); ?>
<?php include("../login/cabecera_registrado.php"); ?>

<body>
    <!-- Navegación de migas de pan -->
    <ul class="breadcrumb">
        <li><a href="../paginas_inicio/PaginaAlumno.php">Menú</a></li>
        <li>Curriculum</li>
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
                    <input type="text" name="carnet" placeholder="Carnet" value="<?php echo $mostrar['carnet_conducir'] ?>"> </div>
            </section>

            <section>
                <h2>APTITUDES</h2>
                <!-- <button onclick="crear('crear1')"><i class='fas fa-plus'></i></button> -->
                <!-- <button onclick="eliminar('crear1')"><i class='fas fa-trash'></i></button> -->
                <div id="crear1">
                    <label for="actitudes">Aptitud:</label>
                    <textarea id="aptitudes" name="aptitudes" rows="4" cols="50" style="width: 10px;  border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['aptitudes'];?></textarea>
                </div>
              
            </section>
            <section>
                <h2>ACTITUDES</h2>
                <!-- <button onclick="crear('crear2')"><i class='fas fa-plus'></i></button> -->
                <!-- <button onclick="eliminar('crear2')"><i class='fas fa-trash'></i></button> -->
                <div id="crear2">
                    <label for="actitud">Actitudes:</label>
                    <textarea id="actitudes" name="actitudes" rows="4" cols="50" style="width: 10px;  border: 1px solid black; margin-top: 8px;"><?php echo $mostrar['actitudes'];?></textarea>
                </div>
          
            </section>
        </aside>

        <article>
            <section>
                <div class="unionEuropea">
                    <img src="../../img/unionEuropea.png" alt="Logo Unión Europea" width="200px" height="50px">
                </div>

                <h2>EXPERIENCIA LABORAL</h2>
                <button onclick="crear('crear3')"><i class='fas fa-plus'></i></button>
                <button onclick="eliminar('crear3')"><i class='fas fa-trash'></i></button>
                <div id="crear3">

                    <p> 
                    <label for="cargo">Nombre Cargo:</label>
                    <input type="text" id="cargo" name="cargo">
                </p>

                <p id="crear4">
                    <label for="empresa">Nombre de la Empresa:</label>
                    <input type="text" id="empresa" name="empresa">
                </p>

                <p id="crear5">
                    <label for="descripcion">Descripcion:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea>
                </p>

                <p id="crear6">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha">
                </p>

                <p id="crear7">
                    <label for="poblacion">Poblacion:</label>
                    <input type="text" id="poblacion" name="poblacion">
                </p>
                </div>
               
            </section>

            <section>
                <h2>FORMACIÓN ACADÉMICA</h2>

                <button onclick="crear('crear8')"><i class='fas fa-plus'></i></button>
                <button onclick="eliminar('crear8')"><i class='fas fa-trash'></i></button>
                <div id="crear8">
                    <label for="estudio">Nombre Estudio:</label>
                    <input type="text" id="estudio" name="estudio">
                </div>

                <div id="crear9">
                    <label for="institucion">Nombre institucion:</label>
                    <input type="text" id="institucion" name="institucion">
                </div>

                <div id="crear10">
                    <label for="fecha_formacion">Fecha:</label>
                    <input type="date" id="fecha_formacion" name="fecha_formacion">
                </div>

                <div id="crear11">
                    <label for="poblacion_formacion">Poblacion:</label>
                    <input type="text" id="poblacion_formacion" name="poblacion_formacion">
                </div>

               
            </section>

            <section>
                <h2>IDIOMAS</h2>
                <button onclick="crear('crear12')"><i class='fas fa-plus'></i></button>
                <button onclick="eliminar('crear12')"><i class='fas fa-trash'></i></button>
                <div id="crear12">
                    <label for="idiomas">Idiomas:</label>
                    <textarea id="idiomas" name="idiomas" rows="4" cols="50"></textarea>

                </div>
                
            </section>
        </article>
    </main>
</body>

</html>

<script>
        function crear(divId) {
            let originalDiv = document.getElementById(divId);
            let clonarDiv = originalDiv.cloneNode(true);

            let textarea = clonarDiv.querySelector("textarea");
            if (textarea) {
                textarea.value = '';
            }

            originalDiv.parentNode.appendChild(clonarDiv);
        }

        function eliminar(divId) {
            let container = document.getElementById(divId).parentNode;

            container.removeChild(container.lastChild);
            
        }

        
    </script>
