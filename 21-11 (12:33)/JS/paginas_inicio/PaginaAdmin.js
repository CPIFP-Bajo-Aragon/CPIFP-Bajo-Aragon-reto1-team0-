    // Función para abrir la ventana modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

    // Asigna la función openModal al botón de abrir modal para empresas
    document.getElementById('openModalBtn').addEventListener('click', function() {
        openModal('myModalEmpresa');
    });

    // Asigna la función openModal al botón de abrir modal para ofertas
    document.getElementById('openModal').addEventListener('click', function() {
        openModal('myModalOfertas');
    });

    // Asigna la función openModal al botón de abrir modal para alumnos
    document.getElementById('openBtn').addEventListener('click', function() {
        openModal('myModalAlumnos');
    });

    // Función para cerrar la ventana modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.getElementById('myModalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalEmpresa');
    });

    // Asigna la función closeModal al span de cerrar modal para ofertas
    document.getElementById('myModalOfertas').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalOfertas');
    });

    // Asigna la función closeModal al span de cerrar modal para alumnos
    document.getElementById('myModalAlumnos').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('myModalAlumnos');
    });