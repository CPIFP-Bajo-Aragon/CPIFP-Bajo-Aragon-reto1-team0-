 // Función para abrir la ventana modal
 function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Asigna la función openModal al botón de abrir modal para empresas
document.getElementById('openModalBtn').addEventListener('click', function() {
    openModal('modalEmpresa');
});

// Función para cerrar la ventana modal
function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Asigna la función closeModal al span de cerrar modal para empresas
document.getElementById('modalEmpresa').getElementsByClassName('cerrar')[0].addEventListener('click', function() {
    closeModal('modalEmpresa');
});