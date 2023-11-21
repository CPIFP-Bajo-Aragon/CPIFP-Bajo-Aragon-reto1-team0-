document.addEventListener('DOMContentLoaded', function() {
   
    // Almacena la tabla de alumnos
    const tablaAlumnos = document.querySelector('#tabla');


    // Filtrador de validado
    const radioButtonsValidar = document.querySelectorAll('input[name="filtrovalidar"]');
   
    radioButtonsValidar.forEach(function (radio) {
        radio.addEventListener('change', function () {
            const filtro = this.value;


            // Obtén todas las filas de la tabla excepto la primera (encabezados).
            const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


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


    // // Filtrar por año de nacimiento
    // document.getElementById('filtrarPorAnio').addEventListener('click', function() {
    //     filtrarPorAnio();
    // });


    // function filtrarPorAnio() {
    //     // Obtiene los valores de los campos de año desde y año hasta
    //     const anioDesde = parseInt(document.getElementById('anioDesde').value) || 0; // Si no se ingresa un valor, asumimos 0.
    //     const anioHasta = parseInt(document.getElementById('anioHasta').value) || 9999; // Si no se ingresa un valor, asumimos un año alto.


    //     // Obtiene todas las filas de la tabla excepto la primera (encabezados).
    //     const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);


    //     filas.forEach(function(fila) {
    //         // Obtiene el valor de la fecha de nacimiento en formato de año
    //         const fechaNacimiento = parseInt(fila.querySelector('td:nth-child(3)').textContent);
    //         // Comprueba si la fila cumple con el filtro de año de nacimiento
    //         if (fechaNacimiento >= anioDesde && fechaNacimiento <= anioHasta) {
    //             fila.style.display = ''; // Muestra la fila si coincide con el filtro de año de nacimiento.
    //         } else {
    //             fila.style.display = 'none'; // Oculta la fila si no coincide con el filtro.
    //         }
    //     });
    // }


    // // Agrega eventos para el filtrado inicial al cargar la página
    // filtrarPorAnio();
    // radioButtons.forEach(function (radio) {
    //     radio.checked = true;
    //     radio.dispatchEvent(new Event('change'));
    // });


    // Filtrador por Población
    const filtroPoblacionSelect = document.getElementById('poblacionSelect');


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

    //Filtrar por el buscador de manera asincrona


    const filtroNombreInput = document.getElementById('nombreBusqueda');

    filtroNombreInput.addEventListener('input', function () {
        // Obtiene el texto del filtro en minúsculas
        const filtroTexto = this.value.toLowerCase();
        // Obtiene todas las filas de la tabla excepto la primera (encabezados)
        const filas = Array.from(tablaAlumnos.querySelectorAll('tr')).slice(1);

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



    function closeModal(modalEmpresa) {
        var modal = document.getElementById(modalEmpresa);
        modal.style.display = 'none';
    }

    // Asigna la función closeModal al span de cerrar modal para empresas
    document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
        closeModal('modalEmpresa');
    });


