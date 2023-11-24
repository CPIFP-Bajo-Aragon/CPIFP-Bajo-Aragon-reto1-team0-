document.addEventListener('DOMContentLoaded', function() {
    
    // Almacena la tabla de alumnos
        const tablaAlumnos = document.querySelector('#tabla');

    // Filtrador de Carnet de Conducir
        const radioButtons = document.querySelectorAll('input[name="filtroCarnet"]');
        
        radioButtons.forEach(function (radio) {
            radio.addEventListener('change', function () {
                // Almacena el valor del filtro
                const filtro = this.value;
                // Obtén todas las filas de la tabla excepto la primera (encabezados).
                const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

                filas.forEach(function (fila) {
                    // Obtiene la columna que contiene la información del Carnet de Conducir
                    const columnaCarnet = fila.querySelector('td:nth-child(5)');
                    // Comprueba si la fila cumple con el filtro
                    if (filtro === 'todos' || columnaCarnet.textContent.trim() === (filtro === 'conCarnet' ? 'Sí' : 'No')) {
                        fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                    } else {
                        fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                    }
                });
            });
        });

    // Filtrador por Población
        const filtroPoblacionSelect = document.getElementById('poblacion');

        filtroPoblacionSelect.addEventListener('change', function () {
            const poblacionSeleccionada = filtroPoblacionSelect.value;

            // Obtiene todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

            // Recorre las filas y filtra según la población seleccionada.
            filas.forEach(function (fila) {
                // Obtiene el ID de población almacenado en un atributo personalizado
                const columnaIdPoblacion = fila.querySelector('td:nth-child(8)').getAttribute('id');

                if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro de población.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });

    // Buscador
        const filtroNombreInput = document.getElementById('nombreBusqueda');

        // Agrega un evento de entrada al campo de búsqueda.
        filtroNombreInput.addEventListener('input', function () {
            // Convierte el texto del filtro a minúsculas para realizar una búsqueda insensible a mayúsculas.
            const filtroTexto = this.value.toLowerCase();

            // Obtiene todas las filas de la tabla de alumnos excluyendo la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

            // Itera sobre cada fila de la tabla.
            filas.forEach(function (fila) {
                // Obtiene el contenido de la columna de nombres (se cambió el índice a 1 para obtener el nombre).
                const columnaNombre = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();

                // Comprueba si el nombre en la fila incluye el texto de búsqueda.
                if (columnaNombre.includes(filtroTexto)) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });


});