
<?php
// Inicia la sesión, permitiendo el uso de variables de sesión.
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Estilos generales para el cuerpo de la página */
        body {
            font-family: Arial, sans-serif; /* Tipo de fuente principal */
            background-color: #f2f2f2; /* Color de fondo */
            margin: 0; /* Elimina los márgenes predeterminados */
            padding: 0; /* Elimina el relleno predeterminado */
        }

        /* Estilos para el encabezado de la página */
        header {
            background-color: #007bff; /* Color de fondo del encabezado */
            color: #fff; /* Color del texto en el encabezado */
            text-align: center; /* Centra el texto en el encabezado */
            padding: 10px; /* Espaciado interno del encabezado */
        }

        /* Estilos para el contenedor principal */
        .container {
            max-width: 800px; /* Ancho máximo del contenedor principal */
            margin: 0 auto; /* Centra el contenedor en la página */
            padding: 20px; /* Espaciado interno del contenedor */
            background-color: #fff; /* Color de fondo del contenedor */
            border: 1px solid #ccc; /* Borde del contenedor */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra del contenedor */
            border-radius: 10px; /* Bordes redondeados del contenedor */
            margin-top: 20px; /* Margen superior del contenedor */
        }

        /* Estilos para el título dentro del contenedor principal */
        .container h1 {
            text-align: center; /* Centra el texto del título */
            font-size: 24px; /* Tamaño de fuente del título */
            color: #007bff; /* Color del texto del título */
        }

        /* Estilos para el área del chat */
        #chat {
            background-color: #f9f9f9; /* Color de fondo del área del chat */
            padding: 20px; /* Espaciado interno del área del chat */
            border-radius: 10px; /* Bordes redondeados del área del chat */
            margin-top: 20px; /* Margen superior del área del chat */
            max-width: 400px; /* Ancho máximo del área del chat */
            margin: 0 auto; /* Centra el área del chat en la página */
        }

        /* Estilos para la ventana del chat */
        #chat-window {
            height: 300px; /* Altura de la ventana del chat */
            overflow-y: scroll; /* Agrega una barra de desplazamiento vertical cuando sea necesario */
            border: 1px solid #ccc; /* Borde de la ventana del chat */
            padding: 10px; /* Espaciado interno de la ventana del chat */
            border-radius: 5px; /* Bordes redondeados de la ventana del chat */
            background-color: #fff; /* Color de fondo de la ventana del chat */
        }

        /* Estilos para el cuadro de mensaje en el área del chat */
        #message {
            width: 70%; /* Ancho del cuadro de mensaje */
            padding: 10px; /* Espaciado interno del cuadro de mensaje */
            border: 1px solid #ccc; /* Borde del cuadro de mensaje */
            border-radius: 5px; /* Bordes redondeados del cuadro de mensaje */
            margin-right: 10px; /* Margen derecho del cuadro de mensaje */
        }

        /* Estilos para el contenedor de botones */
        .button-container {
            display: flex; /* Establece el contenedor de botones como un flex container */
            justify-content: space-between; /* Distribuye el espacio entre los botones */
            flex-wrap: wrap; /* Permite que los botones se envuelvan a la siguiente línea si no hay suficiente espacio */
            margin-top: 20px; /* Margen superior del contenedor de botones */
        }

        /* Estilos para los enlaces dentro del contenedor de botones */
        .button-container a {
            text-decoration: none; /* Elimina la subrayado de los enlaces */
            flex-basis: 48%; /* Establece el tamaño base de los enlaces en el 48% del contenedor */
        }

        /* Estilos para los botones dentro del contenedor de botones */
        .button-container button {
            width: 100%; /* Ancho completo de los botones */
            padding: 10px 20px; /* Espaciado interno de los botones */
            background-color: #149414; /* Color de fondo de los botones */
            color: #fff; /* Color del texto de los botones */
            border: none; /* Elimina el borde de los botones */
            border-radius: 5px; /* Bordes redondeados de los botones */
            cursor: pointer; /* Cambia el cursor al pasar sobre los botones */
            transition: background-color 0.3s; /* Agrega una transición suave al color de fondo de los botones */
        }

        /* Estilos para el estado de hover (paso del ratón) de los botones */
        .button-container button:hover {
            background-color: #146414; /* Cambia el color de fondo al pasar el ratón sobre los botones */
        }
        .enviado {
            float: right;
            background-color: #DCF8C6; /* Color de fondo para enviado (puedes ajustar el color) */
        }

        .recibido {
            float: left;
            background-color: #FFD2D2; /* Color de fondo para recibido (puedes ajustar el color) */
        }
    </style>

    <?php
        

        // Obtiene el ID del usuario actual desde la sesión.
        $id_usuario = $_SESSION['id_usuario'];

        // Obtiene el ID del receptor de los mensajes desde los datos POST.
        $id_receptor = $_POST['id_receptor'];

        // Incluye el archivo de conexión a la base de datos.
        include("../includes/conexion.php");

        // Define una función llamada 'listarmensajes' que toma como parámetros la conexión a la base de datos, el ID del receptor y el ID del usuario.
        function listarmensajes($conexion, $id_receptor, $id_usuario) {
            // Construye la consulta SQL para seleccionar mensajes entre el usuario actual y el receptor, ordenados por fecha.
            $sql = "SELECT * FROM mensaje WHERE (id_usuario = :id_usuario AND receptor = :id_receptor) OR (id_usuario = :id_receptor AND receptor = :id_usuario) ORDER BY hora";

        
            // Prepara la consulta SQL.
            $consulta = $conexion->prepare($sql);
        
            // Vincula los parámetros.
            $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $consulta->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
        
            // Ejecuta la consulta SQL.
            if ($consulta->execute()) {
                // La consulta se ejecutó correctamente.
            } else {
                // Muestra un mensaje si la consulta no se ejecutó correctamente.
                echo "No ha cogido bien los mensajes";
            }
        
            // Itera sobre los resultados de la consulta.
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Determina la clase CSS del mensaje según si el remitente es el usuario actual.
                if($fila->id_usuario=$id_usuario && $fila->receptor = $id_receptor){
                    echo "<div class='enviado'>" . $id_usuario . "</div>";
                }else{
                    echo "<div class='recibido'>" . $fila->mensaje . "</div>";
                }
                // Muestra el mensaje con la clase CSS correspondiente.
        
                // Imprime un salto de línea después de cada mensaje.
                echo "</br>";
            }
        }
        
    ?>


</head>
<body>

<!--ISSETS-->
    <?php
        // Verifica si se ha enviado el formulario con un mensaje
        if (isset($_POST['mensaje_send'])) {
            // Obtiene el mensaje desde los datos del formulario
            $mensaje = $_POST['mensaje'];

            // Obtiene el ID del usuario actual desde la sesión
            $id_usuario = $_SESSION['id_usuario'];

            // Obtiene el ID del receptor desde los datos del formulario
            $id_receptor = $_POST['id_receptor'];

            // Obtiene la fecha actual en formato 'Y-m-d'
            $fecha = date('Y-m-d');

            // Obtiene la hora actual en formato 'H:i:s'
            $hora = date('H:i:s');

            // Construye la consulta SQL para insertar un nuevo mensaje en la tabla 'mensaje'
            $sql = "INSERT INTO `mensaje`(`id_usuario`, `receptor`, `mensaje`, `fecha`, `hora`) VALUES (:id_usuario, :id_receptor, :mensaje, :fecha, :hora)";

            // Prepara la consulta SQL
            $consulta = $conexion->prepare($sql);

            // Bind de los parámetros para evitar inyección de SQL
            $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $consulta->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
            $consulta->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $consulta->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->bindParam(':hora', $hora, PDO::PARAM_STR);

            // Ejecuta la consulta SQL para insertar el mensaje en la base de datos
            $consulta->execute();
        }
    ?>


<!-- Contenido del chat y otros elementos -->
    <div class="container">
        <h1>Mi Título</h1>
        <!-- Chat -->
        <div id="chat">
            <div id="chat-window">
                <?php
                    // Se llama a la función listarmensajes para mostrar los mensajes en el chat.
                    listarmensajes($conexion, $id_receptor, $id_usuario);
                ?>
            </div>
            <!-- Formulario para enviar mensajes -->
            <form method="post" action="chatea">
                <!-- Campo oculto para almacenar el ID del receptor -->
                <input type="hidden" id="id_receptor" name="id_receptor" value="<?php echo ($id_receptor) ?>">
                <!-- Campo de entrada de texto para escribir el mensaje -->
                <input type="text" id="mensaje" name="mensaje" onkeyup="checkEnter(event)" placeholder="Escribe tu mensaje">
                <!-- Botón para enviar el mensaje -->
                <button type="submit" id="mensaje_send" name="mensaje_send">Enviar</button>
            </form>
        </div>
    </div>



<script src="../../JS/chat/chat.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Selecciona todos los elementos con la clase 'message'
        var messages = document.querySelectorAll('.message');

        // Itera sobre cada mensaje y aplica estilos según su clase CSS
        messages.forEach(function (message) {
            // Verifica si el mensaje tiene la clase 'sent'
            if (message.classList.contains('sent')) {
                // Establece estilos para mensajes enviados
                message.style.backgroundColor = '#4CAF50'; // verde para mensajes enviados
                message.style.float = 'right'; // alinea a la derecha
                message.style.marginLeft = '10px'; // añade un margen a la izquierda
                message.style.marginRight = '0'; // restablece el margen a la derecha
            } 
            // Verifica si el mensaje tiene la clase 'received'
            else if (message.classList.contains('received')) {
                // Establece estilos para mensajes recibidos
                message.style.backgroundColor = '#d3ffd3'; // verde más claro para mensajes recibidos
                message.style.float = 'left'; // alinea a la izquierda
                message.style.marginRight = '10px'; // añade un margen a la derecha
                message.style.marginLeft = '0'; // restablece el margen a la izquierda
            }
        });
    });

</script>
</body>
</html>