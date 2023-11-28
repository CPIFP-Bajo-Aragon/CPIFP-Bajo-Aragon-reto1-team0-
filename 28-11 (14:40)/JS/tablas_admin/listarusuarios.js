// Se ejecuta cuando se ha cargado completamente el DOM.
document.addEventListener('DOMContentLoaded', function() {
   
    // Almacena la referencia a la tabla de alumnos con el id 'tabla'.
    const tablaAlumnos = document.querySelector('#tabla');

    // Filtrador de validado
    const radioButtonsValidar = document.querySelectorAll('input[name="filtrovalidar"]');
   
    // Itera sobre cada botón de radio del grupo 'filtrovalidar'.
    radioButtonsValidar.forEach(function (radio) {
        // Agrega un evento de cambio a cada botón de radio.
        radio.addEventListener('change', function () {
            // Obtiene el valor seleccionado (todos, validado, novalidado).
            const filtro = this.value;

            // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

            // Itera sobre cada fila y aplica el filtro según el estado de validación.
            filas.forEach(function (fila) {
                // Obtiene el contenido de la columna que indica el estado de validación.
                const columnaValidado = fila.querySelector('td:nth-child(9)').textContent.trim();

                // Muestra la fila si coincide con el filtro o la oculta si no.
                if (filtro === 'todos' || columnaValidado === (filtro === 'validado' ? 'validado' : 'novalidado')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });

    // Filtrador de Carnet de Conducir
    const radioButtons = document.querySelectorAll('input[name="filtroCarnet"]');
   
    // Itera sobre cada botón de radio del grupo 'filtroCarnet'.
    radioButtons.forEach(function (radio) {
        // Agrega un evento de cambio a cada botón de radio.
        radio.addEventListener('change', function () {
            // Almacena el valor del filtro (todos, conCarnet, sinCarnet).
            const filtro = this.value;

            // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

            // Itera sobre cada fila y aplica el filtro según la información del Carnet de Conducir.
            filas.forEach(function (fila) {
                // Obtiene la columna que contiene la información del Carnet de Conducir.
                const columnaCarnet = fila.querySelector('td:nth-child(5)');

                // Muestra la fila si coincide con el filtro o la oculta si no.
                if (filtro === 'todos' || columnaCarnet.textContent.trim() === (filtro === 'conCarnet' ? 'Sí' : 'No')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });

    // Filtrador por Población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');

    // Agrega un evento de cambio al filtro de población.
    filtroPoblacionSelect.addEventListener('change', function () {
        // Obtiene la población seleccionada en el filtro.
        const poblacionSeleccionada = filtroPoblacionSelect.value;

        // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila y muestra u oculta según la población seleccionada.
        filas.forEach(function (fila) {
            // Obtiene el ID de población almacenado en un atributo personalizado.
            const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');

            // Muestra la fila si coincide con el filtro de población o la oculta si no.
            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    // Filtrar por el buscador de manera asincrona
    const filtroNombreInput = document.getElementById('nombreBusqueda');

    // Agrega un evento de entrada al campo de búsqueda.
    filtroNombreInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas.
        const filtroTexto = this.value.toLowerCase();

        // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro por título.
        filas.forEach(function (fila) {
            // Obtiene el contenido de la columna "Título" y lo convierte a minúsculas.
            const columnaTitulo = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();

            // Muestra la fila si el título incluye el texto de búsqueda o la oculta si no.
            if (columnaTitulo.includes(filtroTexto)) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });
});

// Función para cerrar un modal específico por su ID.
function closeModal(modalEmpresa) {
    // Obtiene el modal por su ID.
    var modal = document.getElementById(modalEmpresa);

    // Oculta el modal.
    modal.style.display = 'none';
}

// Asigna la función closeModal al span de cerrar modal para empresas.
document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
    closeModal('modalEmpresa');
});
