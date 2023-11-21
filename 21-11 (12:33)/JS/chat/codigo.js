// Función para abrir la ventana modal con contenido dinámico
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Asigna la función openModal al botón de abrir modal para empresas
document.getElementById('abrirempresas').addEventListener('click', function () {
    openModal('myModalEmpresa'); // El ID del modal es 'myModal'
});

 // Asigna la función openModal al botón de abrir modal para empresas
 document.getElementById('abriralumno').addEventListener('click', function () {
    openModal('myModalAlumno'); // El ID del modal es 'myModal'
});

 // Asigna la función openModal al botón de abrir modal para empresas
 document.getElementById('adbiradmin').addEventListener('click', function () {
    openModal('myModalAdmin'); // El ID del modal es 'myModal'
});

//cerrar 
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.getElementById('myModalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function () {
        closeModal('myModalEmpresa');
    });

    // Asigna la función closeModal al span de cerrar modal para alumnos
    document.getElementById('myModalAlumno').getElementsByClassName('close')[0].addEventListener('click', function () {
        closeModal('myModalAlumno');
    });

    // Asigna la función closeModal al span de cerrar modal para administradores
    document.getElementById('myModalAdmin').getElementsByClassName('close')[0].addEventListener('click', function () {
        closeModal('myModalAdmin');
    });