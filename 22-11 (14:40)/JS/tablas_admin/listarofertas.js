// Espera a que el contenido del documento HTML esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtiene la tabla de ofertas de trabajo
    const tablaOfertas = document.querySelector('#tabla');

    // Filtrado por requerir o no carnet de conducir
    const radioButtons = document.querySelectorAll('input[name="filtroCarnet"]');

    radioButtons.forEach(function (radio) {
        // Añade un evento de cambio a cada botón de radio
        radio.addEventListener('change', function () {
            // Obtiene el valor del botón de radio seleccionado
            const filtro = this.value;
            // Obtiene todas las filas de la tabla excepto la primera (encabezados)
            const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

            // Itera sobre cada fila para aplicar el filtro
            filas.forEach(function (fila) {
                // Obtiene el contenido de la columna "Requiere Carnet de Conducir"
                const columnaCarnet = fila.querySelector('td:nth-child(5)').innerText;

                // Muestra la fila si coincide con el filtro, oculta si no coincide
                if (filtro === 'todos' || columnaCarnet.trim() === (filtro === 'conCarnet' ? 'Sí' : 'No')) {
                    fila.style.display = ''; // Muestra la fila si coincide con el filtro.
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
                }
            });
        });
    });

    // Filtrado por duración del contrato
    const inputDuracionContrato = document.getElementById('filtroDuracionContrato');
    const duracionContratoLabel = document.getElementById('duracionContratoLabel');

    // Añade un evento de entrada al control deslizante de duración del contrato
    inputDuracionContrato.addEventListener('input', function () {
        // Obtiene la duración seleccionada del control deslizante
        const duracionSeleccionada = parseInt(this.value, 10);
        // Actualiza el texto de la etiqueta para reflejar la duración seleccionada
        duracionContratoLabel.textContent = duracionSeleccionada === 0 ? "Cualquier duración" : `Menos de ${duracionSeleccionada} meses`;

        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro de duración del contrato
        filas.forEach(function (fila) {
            // Obtiene el contenido de la columna "Duración del Contrato"
            let columnaDuracion = parseInt(fila.querySelector('td:nth-child(4)').textContent);

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (duracionSeleccionada === 0 || columnaDuracion <= duracionSeleccionada) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });

    // Filtrado por población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');

    // Añade un evento de cambio al menú desplegable de población
    filtroPoblacionSelect.addEventListener('change', function () {
        // Obtiene la población seleccionada del menú desplegable
        const poblacionSeleccionada = filtroPoblacionSelect.value;
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro por población
        filas.forEach(function (fila) {
            // Obtiene el ID de población de la columna "Población"
            const columnaIdPoblacion = fila.querySelector('td:nth-child(6)').getAttribute('id');

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (poblacionSeleccionada === "" || columnaIdPoblacion === poblacionSeleccionada) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // Filtrado por título mediante entrada de texto
    const filtroTituloInput = document.getElementById('filtroTitulo');

    // Añade un evento de entrada al campo de entrada de texto para el filtro por título
    filtroTituloInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas
        const filtroTexto = this.value.toLowerCase();
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaOfertas.querySelectorAll('tr')).slice(1);

        // Itera sobre cada fila para aplicar el filtro por título
        filas.forEach(function (fila) {
            // Obtiene el contenido de la columna "Título"
            const columnaTitulo = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();

            // Muestra la fila si coincide con el filtro, oculta si no coincide
            if (columnaTitulo.includes(filtroTexto)) {
                fila.style.display = ''; // Muestra la fila si coincide con el filtro.
            } else {
                fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
            }
        });
    });
});

function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Función para cerrar la ventana modal
function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

    
    function crearInput(type, name, value) {
        var input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.value = value;
        return input;
    }

    var modalContent = document.getElementById('modal-content');
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[name="editar"]').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                var close = document.createElement('span');
                close.className = 'close';
                close.textContent = '\u00D7';
                close.onclick = function () {
                    cerrarModal('modalOfertas');
                };

                var idOferta = button.getAttribute('id').replace('editar_', '');

                var modalContent = document.getElementById('modal-content');

                modalContent.innerHTML = '';

                var h2 = document.createElement('h2');
                h2.textContent = 'Editar oferta';

                var form = document.createElement('form');
                form.action = 'ofertas-admin';
                form.method = 'POST';
    
            var inputTitulo = crearInput('text', 'titulo', idOferta);
            var inputDescripcion = crearInput('text', 'descripcion', idOferta);
            var inputDuracionContrato = crearInput('text', 'duracion_contrato', idOferta);
            var inputCarnet = crearInput('text', 'carnet', idOferta);
            var inputPoblacion = crearInput('text', 'poblacion', idOferta);
            var inputAptitud = crearInput('text', 'aptitud', idOferta);
            var inputIdOferta = crearInput('hidden', 'id_oferta', idOferta);
            var inputSubmit = document.createElement('input');
            inputSubmit.type = 'submit';
            inputSubmit.name = 'Guardar';
            inputSubmit.value = 'Guardar';
    
            inputTitulo.id = 'inputTitulo';
            inputDescripcion.id = 'inputDescripcion';
            inputDuracionContrato.id = 'inputDuracionContrato';
            inputCarnet.id = 'inputCarnet';
            inputPoblacion.id = 'inputPoblacion';
            inputAptitud.id = 'inputAptitud';
            inputIdOferta.id = 'inputIdOferta';
    
            form.appendChild(inputTitulo);
            form.appendChild(inputDescripcion);
            form.appendChild(inputDuracionContrato);
            form.appendChild(inputCarnet);
            form.appendChild(inputPoblacion);
            form.appendChild(inputAptitud);
            form.appendChild(inputIdOferta);
            form.appendChild(inputSubmit);
    
            modalContent.appendChild(close);
                modalContent.appendChild(h2);
                modalContent.appendChild(form);

                llenarDatosDesdePHP();

                openModal('modalOfertas');
            });
        });
    
    // Función para llenar datos desde PHP
    function llenarDatosDesdePHP() {
        // Asignar valores a los inputs (reemplaza esto con tus datos reales)
        document.getElementById('inputTitulo').value = datosOferta.titulo;
        document.getElementById('inputDescripcion').value = datosOferta.descripcion;
        document.getElementById('inputDuracionContrato').value = datosOferta.duracion_contrato;
        document.getElementById('inputCarnet').value = datosOferta.carnet;
        document.getElementById('inputPoblacion').value = datosOferta.poblacion;
        document.getElementById('inputAptitud').value = datosOferta.aptitud;
        document.getElementById('inputIdOferta').value = datosOferta.id_oferta;
    }
});