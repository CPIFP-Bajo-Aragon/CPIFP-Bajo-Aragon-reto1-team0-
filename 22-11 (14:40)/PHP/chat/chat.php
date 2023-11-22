
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
    $id_usuario=$_SESSION['id_usuario'];
    $id_receptor = $_POST['id_receptor'];
    include("../includes/conexion.php");
    include("../includes/isset/chat/chat.php");

    function listarmensajes($conexion, $id_receptor, $id_usuario){
        $sql = "SELECT * FROM mensaje WHERE (id_usuario = $id_usuario AND receptor = $id_receptor) ORDER BY fecha";
        $consulta = $conexion->prepare($sql);
        if($consulta->execute()){
        }else{
            echo "no ha cogido bien los mensajes";
        }
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $clase_css = ($fila->id_usuario == $_SESSION['id_usuario']) ? 'sent' : 'received';
            echo "<div class='message $clase_css'>" . $fila->mensaje . "</div>";
            echo "</br>";
        }
    }

    ?>

</head>
<body>
<!-- Contenido del chat y otros elementos -->
<div class="container">
        <h1>Mi Título</h1>
        <!-- Chat -->
        <div id="chat">
            <div id="chat-window">
                <?php
                    listarmensajes($conexion, $id_receptor, $id_usuario);
                ?>
            </div>
            <form method="post" action="chatea">
                <input type="hidden" id="id_receptor" name="id_receptor" value="<?php echo ($id_receptor) ?>" >
                <input type="text" id="mensaje" name="mensaje" onkeyup="checkEnter(event)" placeholder="Escribe tu mensaje">
                <button type="submit" id="mensaje_send" name="mensaje_send">Enviar</button>
            </form>
        </div>    
</div>
<script src="../../JS/chat/chat.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // ... (tu código existente)
    // Agrega estilos a los mensajes según la clase CSS
    var messages = document.querySelectorAll('.message');
    messages.forEach(function (message) {
        if (message.classList.contains('sent')) {
            message.style.backgroundColor = '#4CAF50'; // verde para mensajes enviados
            message.style.float = 'right';
            message.style.marginLeft = '10px';
            message.style.marginRight = '0';
        } else if (message.classList.contains('received')) {
            message.style.backgroundColor = '#d3ffd3'; // verde más claro para mensajes recibidos
            message.style.float = 'left';
            message.style.marginRight = '10px';
            message.style.marginLeft = '0';
        }
    });
    
});
</script>
</body>
</html>