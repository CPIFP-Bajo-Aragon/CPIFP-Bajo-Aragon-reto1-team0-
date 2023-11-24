<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index.css">
    <title>Formulario de Registro de Usuario</title>
    <style>
        
        #empresa, #alumno {
            display: none;/* Oculta los elementos con id 'empresa' y 'alumno' por defecto */
        }

        /* Estilos para el contenedor del formulario de registro */
        #formulario_de_registrar {
            border: 3px solid black; /* Borde sólido negro de 3 píxeles */
            width: 50vh; /* Ancho del 50% del viewport height */
            height: 50vh; /* Altura del 50% del viewport height */
            margin-left: 36%; /* Margen izquierdo del 36% con respecto al contenedor padre */
            padding: 15px; /* Relleno interno de 15 píxeles */
            overflow: auto; /* Habilita el desplazamiento vertical si el contenido excede la altura */
            overflow-x: hidden; /* Evita el desbordamiento horizontal */
        }

        /* Estilos para el contenedor 'ser' que alberga los botones de tipo de usuario */
        #ser {
            display: flex; /* Utilizamos flexbox para alinear los elementos en línea */
        }

        /* Estilos para los botones de tipo de usuario dentro de 'ser' */
        #ser input {
            display: inline-block; /* Muestra los elementos como bloques en línea */
            width: auto; /* Ancho automático según el contenido */
            padding: 55px; /* Relleno interno de 55 píxeles */
            margin-right: 5%; /* Ajusta el espacio entre el botón y la etiqueta */
        }

        /* Estilos para las etiquetas de tipo de usuario dentro de 'ser' */
        #ser label {
            display: inline-block; /* Muestra las etiquetas como bloques en línea */
            margin-left: 20%; /* Ajusta el espacio entre la etiqueta y el próximo botón */
        }
    </style>
    
<script src="../../JS/validaciones/registrar/crearusuario.js"></script>
<script src="../../JS/registrar/crearusuario.js"></script>
</head>
<?php
    include("../includes/conexion.php");
    include("../includes/funciones/funcionesregistrar.php");
?>

<body>
    <?php
        include("../includes/cabecera.php" );
    ?>
    <div>
        <!-- ISSET -->
            <?php
                if(isset($_POST['insertarempresa'])){
                    crearempresacliente($conexion);
                }
                if(isset($_POST['insertaralumno'])){
                    insertaralumnocliente($conexion);
                }
            ?>
        <ul class="breadcrumb">
            <li><a href="inicio-sesion">Iniciar Sesión</a></li>
            <li>Crear Nuevo Usuario</li>
        </ul> 


        
        <div id="formulario_de_registrar">
        
            <form action="registrar" method="POST" id="miFormulario" onsubmit="return validarregistrodeusuarioscliente(event)">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" maxlength="50" required placeholder="Nombre Usuario">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" maxlength="50" required placeholder="Contraseña">

                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" maxlength="100" required placeholder="Correo electrónico">
                    
                <label for="">¿Quién eres?</label>
                <div id="ser">
                    <label for="">Empresa</label><input type="radio" name="usu" id="empresabtn" value="empresabtn" onclick="mostrarDiv('empresa')">

                    <label for="">Alumno</label><input type="radio" name="usu" id="alumnobtn" value="alumnobtn" onclick="mostrarDiv('alumno')">
                </div>

                <!-- Complemento para insertar empresas-->
                <div id="empresa">

                    <label for="">CIF</label>
                    <input type="text" id="CIF" name="CIF" maxlength="50" placeholder="CIF">
                        
                    <label for="">Nombre Empresa</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" maxlength="50" placeholder="Nombre Empresa">

                    <label for="">Dirección</label>
                    <input type="text" id="DIRECCION" name="direccion" maxlength="50" placeholder="Direccion">

                    <label for="">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" maxlength="50" placeholder="Descripcion">

                    <label for="">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" maxlength="9" placeholder="Telefono">

                    <label for="">Población</label>
                    <input type="text" id="poblacionempresa" name="poblacionempresa" maxlength="50" placeholder="Poblacion">

                    <label for="">Sector</label>
                    <input type="text" id="sector" name="sector" maxlength="50" placeholder="Sector">

                    <input type="submit" name="insertarempresa" id="insertarempresa" value="Crear Usuario">
                </div>

                
                <!-- Complemento para insertar alumnos-->
                <div id="alumno">
                    <label for="">DNI</label>
                    <input type="text" id="dni" name="dni" maxlength="9"  placeholder="DNI">
                        
                    <label for="">Nombre</label>
                    <input type="text" id="nombre" name="nombre" maxlength="50"  placeholder="Nombre">

                    <label for="">Apellidos</label>
                    <input type="text" id="apellido" name="apellido" maxlength="50"  placeholder="Apellidos">

                    <label for="">Fecha nacimiento</label>
                    <input type="date" id="Fecha_nacimiento" name="Fecha_nacimiento"  placeholder="Fecha Nacimiento">

                    <label for="">Teléfono</label>
                    <input type="tel" id="TELEFONO" name="TELEFONO" maxlength="9"  placeholder="Telefono">

                    <label for="">Carnet de conducir</label>
                    <input type="checkbox" id="conducir" name="conducir">

                    <label for="">Actitudes</label>
                    <input type="text" id="actitudes" name="actitudes"   placeholder="Actitudes">
                    <label for="">Aptitudes</label>
                    <input type="text" id="aptitudes" name="aptitudes"   placeholder="Aptitudes">

                    <label for="">Población</label>
                    <input type="text" id="poblacionalumno" name="poblacionalumno" maxlength="50"  placeholder="Poblacion">

                    <input type="submit" name="insertaralumno" id="insertaralumno" value="Crear Usuario">
                </div>
            </form>

        </div>
    </div>

    <?php
        include "../includes/footer.php"
    ?>
</body>

</html>



</body>

</html>