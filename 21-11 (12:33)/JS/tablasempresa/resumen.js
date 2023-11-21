    
    // Función para abrir la ventana modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

    // Asigna la función openModal al botón de abrir modal para empresas
    document.querySelectorAll('.btn_inscritos').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var modalId = this.getAttribute('data-modal-id');
        openModal(modalId);
    });
});

     // Función para cerrar la ventana modal
     function cerrarModalInscritos(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.querySelectorAll('.closeI').forEach(function(closeBtn) {
    closeBtn.addEventListener('click', function() {
        var modalId = this.closest('.modal').getAttribute('id');
        cerrarModalInscritos(modalId);
    });
});