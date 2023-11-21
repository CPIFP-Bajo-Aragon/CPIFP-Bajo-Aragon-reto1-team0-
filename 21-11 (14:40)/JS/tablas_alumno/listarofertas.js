 // Espera a que el contenido del documento HTML esté completamente cargado
 document.addEventListener('DOMContentLoaded', function () {
    // Obtiene la tabla de ofertas de trabajo
    const tablaOfertas = document.querySelector('#tabla');

//actualizar pagina 
document.addEventListener('DOMContentLoaded', function () {
    // Obtiene el formulario y el botón de inscripción
    const formInscribir = document.getElementById('formInscribir');
    const btnInscribirme = document.getElementById('inscribirme');

    // Agrega un evento de escucha al formulario
    formInscribir.addEventListener('submit', function (event) {
        event.preventDefault(); // Evita la recarga de la página por defecto

        // Envía el formulario de manera síncrona
        formInscribir.submit();
    });
});


//filtro sector
const filtroSectorSelect = document.getElementById('sectorSelect');

// Añade un evento de cambio al menú desplegable de población
filtroSectorSelect.addEventListener('change', function () {
    // Obtiene la población seleccionada del menú desplegable
    const sectorSeleccionada = filtroSectorSelect.value;
    // Obtiene todas las ofertas (divs) dentro del contenedor
    const ofertas = document.querySelectorAll('.oferta');

    // Itera sobre cada oferta para aplicar el filtro por población
    ofertas.forEach(function (oferta) {
        // Obtiene el ID de población de la oferta
        const columnaIdsector = oferta.querySelector('.sector').getAttribute('id');

        // Muestra la oferta si coincide con el filtro, oculta si no coincide
        if (sectorSeleccionada === "" || columnaIdsector === sectorSeleccionada) {
            oferta.style.display = '';
        } else {
            oferta.style.display = 'none';
        }
    });
});

// Filtrado por población
const filtroPoblacionSelect = document.getElementById('poblacionSelect');

// Añade un evento de cambio al menú desplegable de población
filtroPoblacionSelect.addEventListener('change', function () {
    // Obtiene la población seleccionada del menú desplegable
    const poblacionSeleccionada = filtroPoblacionSelect.value;
    // Obtiene todas las ofertas (divs) dentro del contenedor
    const ofertas = document.querySelectorAll('.oferta');

    // Itera sobre cada oferta para aplicar el filtro por población
    ofertas.forEach(function (oferta) {
        // Obtiene el ID de población de la oferta
        const columnaIdPoblacion = oferta.querySelector('.poblacion').getAttribute('id');

        // Muestra la oferta si coincide con el filtro, oculta si no coincide
        if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
            oferta.style.display = '';
        } else {
            oferta.style.display = 'none';
        }
    });
});

// Filtrado por título mediante entrada de texto
const filtroTituloInput = document.getElementById('filtroTitulo');

// Añade un evento de entrada al campo de entrada de texto para el filtro por título
filtroTituloInput.addEventListener('input', function () {
    // Obtiene el texto del filtro en minúsculas
    const filtroTexto = this.value.toLowerCase();
    // Obtiene todas las ofertas (divs) dentro del contenedor
    const ofertas = document.querySelectorAll('.oferta');

    // Itera sobre cada oferta para aplicar el filtro por título
    ofertas.forEach(function (oferta) {
        // Obtiene el contenido del h2 dentro de la oferta
        const tituloOferta = oferta.querySelector('h2').textContent.toLowerCase();

        // Muestra la oferta si coincide con el filtro, oculta si no coincide
        if (tituloOferta.includes(filtroTexto)) {
            oferta.style.display = ''; // Muestra la oferta si coincide con el filtro.
        } else {
            oferta.style.display = 'none'; // Oculta la oferta si no coincide con el filtro.
        }
    });
});
});

function closeModal(modalEmpresa) {
    var modal = document.getElementById(modalEmpresa);
    modal.style.display = 'none';
}

// Asigna la función closeModal al span de cerrar modal para empresas
document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
    closeModal('modalEmpresa');
});
