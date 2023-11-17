
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        /* Estilos para el encabezado */
        header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        /* Contenedor principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
        }
        /* Título */
        .container h1 {
            text-align: center;
            font-size: 24px;
            color: #007bff;
        }
        /* Estilos para el chat */
        #chat {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        #chat-window {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
        }
        #message {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        /* Estilos para botones */
        .button-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            flex-basis: 48%;
        }
        .button-container button {
            width: 100%;
            padding: 10px 20px;
            background-color: #149414;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container button:hover {
            background-color: #146414;
        }
    </style>
    <?php
    session_start();

        if (isset($_POST['mensaje_send'])) {
            $mensaje = $_POST['mensaje'];
            $id_usuario = $_SESSION['id_usuario'];
            $id_receptor = $_POST['id_receptor'];
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');

            $sql = "INSERT INTO `mensaje`(`id_usuario`, `receptor`, `mensaje`, `fecha`, `hora`) VALUES (:id_usuario, :id_receptor, :mensaje, :fecha, :hora)";

            $consulta = $conexion->prepare($sql);

            // Bind de los parámetros
            $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $consulta->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
            $consulta->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $consulta->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->bindParam(':hora', $hora, PDO::PARAM_STR);

            // Ejecuta la consulta
            $consulta->execute();
        }
    ?>

</head>
<body>



<!-- Contenido del chat y otros elementos -->
<div class="container">
        <h1>Mi Título</h1>
        <!-- Chat -->
        <div id="chat">
            <div id="chat-window"></div>
            <form method="post" action="chat">
                <input type="hidden" id="id_receptor" name="id_receptor" value="2" >
                <input type="text" id="mensaje" name="mensaje" onkeyup="checkEnter(event)" placeholder="Escribe tu mensaje">
                <button type="submit" id="mensaje_send" name="mensaje_send">Enviar</button>
            </form>
        </div>    
    </div>
<script>
   

// Llama a openChatModal cuando se hace clic en el botón "Abrir Chat"
    document.getElementById('openChatModal').addEventListener('click', openChatModal);
        // Función para actualizar el chat
        function updateChat() {
            const chatWindow = document.getElementById('chat-window');
            fetch('messages.txt')
                .then(response => response.text())
                .then(data => {
                    chatWindow.innerHTML = data;
                    // Hacer auto-scroll hacia abajo
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                })
                .catch(error => {
                    console.error('Error al actualizar el chat:', error);
                });
        }
        // Función para manejar la pulsación de Enter
        function checkEnter(event) {
            if (event.key === "Enter") {
                // Simular un clic en el botón cuando se presiona Enter
                document.getElementById("mensaje_send").click();
            }
        }
        setInterval(updateChat, 100); // Adjust the interval as needed
    </script>
</body>
</html>