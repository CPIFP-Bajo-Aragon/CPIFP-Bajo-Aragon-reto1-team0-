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