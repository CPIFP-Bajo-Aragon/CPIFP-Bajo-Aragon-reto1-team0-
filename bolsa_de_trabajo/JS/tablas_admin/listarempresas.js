// Espera a que se cargue completamente el DOM antes de ejecutar el código.
document.addEventListener('DOMContentLoaded', function () {
    // Almacena la referencia a la tabla con el id 'tabla'.
    const tablaEmpresa = document.querySelector('#tabla');

    // Filtrador de validado
    const radioButtons = document.querySelectorAll('input[name="filtrovalidar"]');

    // Itera sobre cada botón de radio del grupo 'filtrovalidar'.
    radioButtons.forEach(function (radio) {
        // Agrega un evento de cambio a cada botón de radio.
        radio.addEventListener('change', function () {
            // Obtiene el valor seleccionado (todos, validado, novalidado).
            const filtro = this.value;

            // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
            const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

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

    // Filtrador por población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');
    filtroPoblacionSelect.addEventListener('change', function () {
        // Obtiene la población seleccionada en el filtro.
        const poblacionSeleccionada = filtroPoblacionSelect.value;

        // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila y muestra u oculta según la población seleccionada.
        filas.forEach(function (fila) {
            // Obtiene el identificador de la población de la columna correspondiente.
            const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');

            // Muestra la fila si coincide con la población seleccionada o la oculta si no.
            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    // Buscador
    const filtroNombreInput = document.getElementById('buscador');

    // Agrega un evento de entrada al campo de búsqueda.
    filtroNombreInput.addEventListener('input', function () {
        // Obtiene el texto del campo de búsqueda y lo convierte a minúsculas.
        const filtroTexto = this.value.toLowerCase();

        // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila y muestra u oculta según el texto de búsqueda.
        filas.forEach(function (fila) {
            // Obtiene el nombre de la columna correspondiente y lo convierte a minúsculas.
            const columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();

            // Muestra la fila si el nombre incluye el texto de búsqueda o la oculta si no.
            if (columnaNombre.includes(filtroTexto)) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    // Filtrador por sector
    const filtroSectorSelect = document.getElementById('sectorSelect');
    filtroSectorSelect.addEventListener('change', function () {
        // Obtiene el sector seleccionado en el filtro.
        const sectorSeleccionado = filtroSectorSelect.value;

        // Obtiene todas las filas de la tabla excluyendo la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila y muestra u oculta según el sector seleccionado.
        filas.forEach(function (fila) {
            // Obtiene el identificador del sector de la columna correspondiente.
            const columnaIdSector = fila.querySelector('td:nth-child(10)').getAttribute('id');

            // Muestra la fila si coincide con el sector seleccionado o la oculta si no.
            if (sectorSeleccionado === "" || columnaIdSector === sectorSeleccionado) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });
});
