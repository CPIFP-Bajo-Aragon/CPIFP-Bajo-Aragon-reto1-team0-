 // Función para abrir la ventana modal
 function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Función para cerrar la ventana modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Asigna la función closeModal al span de cerrar modal para estudio
document.getElementById('myModalEstudio').getElementsByClassName('close')[0].addEventListener('click', function () {
    closeModal('myModalEstudio');
});