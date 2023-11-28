// Llama a openChatModal cuando se hace clic en el botón "Abrir Chat"
document.getElementById('openChatModal').addEventListener('click', openChatModal);

// Función para actualizar el chat
function updateChat() {
    // Obtener la ventana del chat por su ID
    const chatWindow = document.getElementById('chat-window');

    // Realizar una solicitud fetch al archivo 'messages.txt' para obtener los mensajes
    fetch('messages.txt')
        .then(response => response.text()) // Convertir la respuesta a texto
        .then(data => {
            // Actualizar el contenido de la ventana del chat con los datos obtenidos
            chatWindow.innerHTML = data;

            // Hacer auto-scroll hacia abajo para mostrar los mensajes más recientes
            chatWindow.scrollTop = chatWindow.scrollHeight;
        })
        .catch(error => {
            // Manejar errores en caso de que la solicitud falle
            console.error('Error al actualizar el chat:', error);
        });
}

// Función para manejar la pulsación de Enter
function checkEnter(event) {
    // Verificar si la tecla presionada es "Enter"
    if (event.key === "Enter") {
        // Simular un clic en el botón de enviar mensaje cuando se presiona Enter
        document.getElementById("mensaje_send").click();
    }
}

// Establecer un intervalo para llamar a la función updateChat cada 100 milisegundos
// Ajusta el intervalo según sea necesario para equilibrar la frecuencia de actualización
setInterval(updateChat, 1);
