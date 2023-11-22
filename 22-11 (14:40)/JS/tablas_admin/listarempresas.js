document.addEventListener('DOMContentLoaded', function () {
    // Almacena la tabla
    const tablaEmpresa = document.querySelector('#tabla');

    // Filtrador de validado
    const radioButtons = document.querySelectorAll('input[name="filtrovalidar"]');

    radioButtons.forEach(function (radio) {
        radio.addEventListener('change', function () {
            const filtro = this.value;

            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

            filas.forEach(function (fila) {
                const columnaValidado = fila.querySelector('td:nth-child(9)').textContent.trim();

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
        const poblacionSeleccionada = filtroPoblacionSelect.value;

        // Obtén todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Recorre las filas y filtra según la población seleccionada.
        filas.forEach(function (fila) {
            const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');

            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Buscador
    const filtroNombreInput = document.getElementById('buscador');

    filtroNombreInput.addEventListener('input', function () {
        const filtroTexto = this.value.toLowerCase();
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        filas.forEach(function (fila) {
            const columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (columnaNombre.includes(filtroTexto)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Filtrador por sector
    const filtroSectorSelect = document.getElementById('sectorSelect');
    filtroSectorSelect.addEventListener('change', function () {
        const sectorSeleccionado = filtroSectorSelect.value;

        // Obtén todas las filas de la tabla excepto la primera (encabezados).
        const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

        // Recorre las filas y filtra según el sector seleccionado.
        filas.forEach(function (fila) {
            const columnaIdSector = fila.querySelector('td:nth-child(10)').getAttribute('id');

            if (sectorSeleccionado === "" || columnaIdSector === sectorSeleccionado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Función para abrir la ventana modal
   
});