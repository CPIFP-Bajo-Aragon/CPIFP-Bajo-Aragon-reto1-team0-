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

        // Asigna la función closeModal al span de cerrar modal para experiencia
        document.getElementById('myModalExperiencia').getElementsByClassName('close')[0].addEventListener('click', function() {
            closeModal('myModalExperiencia');
        });