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
       
        const poblacionSeleccionada = document.getElementById('poblacionSelect').value;

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
            const columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Cambié el índice a 3 para obtener el nombre de usuario

            if (columnaNombre.includes(filtroTexto)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    // const buscadorForm = document.getElementById('fbuscador');
    // buscadorForm.addEventListener('submit', function (event) {
    //     event.preventDefault();


    //     // Obtén todas las filas de la tabla excepto la primera (encabezados).
    //     const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

    //     const terminoBusqueda = document.getElementById('buscador').value.toLowerCase();
    //     // Recorre las filas y filtra según el término de búsqueda.
    //     filas.forEach(function (fila) {

    //         filas.forEach(function (fila) {
    //             var columnaNombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
    //             var columnaDireccion = fila.querySelector('td:nth-child(4)').textContent.toLowerCase();
    //             var columnaNombreUsu = fila.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
    //             if (columnaNombre.includes(terminoBusqueda) || columnaNombreUsu.includes(terminoBusqueda) || columnaDireccion.includes(terminoBusqueda)) {
    //                 fila.style.display = '';
    //             } else {
    //                 fila.style.display = 'none';
    //             }
    //         });

            

            
    //     });
    // });
// Filtrador por sector
const filtroSectorSelect = document.getElementById('sectorSelect');
filtroSectorSelect.addEventListener('change', function () {
    event.preventDefault();

    const sectorSeleccionado = document.getElementById('sectorSelect').value;


    // Obtén todas las filas de la tabla excepto la primera (encabezados).
    const filas = Array.from(tablaEmpresa.querySelectorAll('tr')).slice(1);

    // Recorre las filas y filtra según el sector seleccionado.
    filas.forEach(function (fila) {
        const columnaIdSector = fila.querySelector('td:nth-child(10)').getAttribute('id');

        console.log('Sector en la fila:', columnaIdSector);

        if (sectorSeleccionado === "" || columnaIdSector === sectorSeleccionado) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });

});
});

 // Función para abrir la ventana modal
function openModal(modalId) {
 var modal = document.getElementById(modalId);
 modal.style.display = 'block';
}

// Asigna la función openModal al botón de abrir modal para empresas
document.getElementById('editar').addEventListener('click', function() {
 openModal('modalEmpresa');
});

// // Función para cerrar la ventana modal
function cerrarModal(modalId) {
var modal = document.getElementById(modalId);
modal.style.display = 'none';
}

// Asigna la función cerrarModal al span de cerrar modal para empresas
document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
cerrarModal('modalEmpresa');
});



function abrirModalEditarEmpresa(id, nombre_usuario, nombre, cif, direccion, correo, poblacion, sector, telefono) {
    // Crea el modal
    var modal = document.createElement('div');
    modal.id = 'modalEmpresa';
    modal.className = 'modal';
    modal.style.display = 'block';

    // Crea el contenido del modal
    var modalContent = document.createElement('div');
    modalContent.className = 'modal-content';

    // Crea el botón de cierre
    var closeButton = document.createElement('span');
    closeButton.className = 'close';
    closeButton.innerHTML = '&times;';
    closeButton.onclick = function () {
        cerrarModal('modalEmpresa');
    };

    // Crea el título
    var title = document.createElement('h2');
    title.innerHTML = 'Editar empresa';

    // Crea el formulario
    var form = document.createElement('form');
    form.action = 'empresas-admin';
    form.method = 'POST';

    // Crea los campos del formulario
    var fields = [
        { type: 'text', name: 'nombre_usuario', value: nombre_usuario },
        { type: 'text', name: 'nombre', value: nombre },
        { type: 'text', name: 'cif', value: cif },
        { type: 'text', name: 'direccion', value: direccion },
        { type: 'text', name: 'correo', value: correo }
    ];

    fields.forEach(function (field) {
        var input = document.createElement('input');
        input.type = field.type;
        input.name = field.name;
        input.value = field.value;
        form.appendChild(input);
    });

    // Crea el campo de población
    var poblacionSelect = document.createElement('select');
    poblacionSelect.name = 'poblacionSelect';
    poblacionSelect.id = 'poblacionSelect';

    var poblacionOption = document.createElement('option');
    poblacionOption.value = poblacion;
    poblacionOption.innerHTML = obtenerNombrePoblacion(poblacion);
    poblacionSelect.appendChild(poblacionOption);

    // Agrega la lista de provincias y poblaciones
    var provinciasYPoblaciones = obtenerListaProvinciasYPoblaciones('poblacionSelect');
    poblacionSelect.innerHTML += provinciasYPoblaciones;

    // Crea el campo de sector
    var sectorSelect = document.createElement('select');
    sectorSelect.name = 'id_sector';

    var sectorOption = document.createElement('option');
    sectorOption.value = sector;
    sectorOption.innerHTML = obtenerNombreSector(sector);
    sectorSelect.appendChild(sectorOption);

    // Agrega la lista de sectores
    var sectores = obtenerListaSectores();
    sectorSelect.innerHTML += sectores;

    // Crea el campo de teléfono
    var telefonoInput = document.createElement('input');
    telefonoInput.type = 'text';
    telefonoInput.name = 'telefono';
    telefonoInput.value = telefono;

    // Crea el campo oculto para el ID de usuario
    var idUsuarioInput = document.createElement('input');
    idUsuarioInput.type = 'hidden';
    idUsuarioInput.name = 'id_usuario';
    idUsuarioInput.value = id;

    // Crea el botón de guardar
    var guardarButton = document.createElement('input');
    guardarButton.type = 'submit';
    guardarButton.name = 'guardar';
    guardarButton.value = 'Guardar';

    // Agrega los elementos al formulario
    form.appendChild(poblacionSelect);
    form.appendChild(sectorSelect);
    form.appendChild(telefonoInput);
    form.appendChild(idUsuarioInput);
    form.appendChild(guardarButton);

    // Agrega los elementos al contenido del modal
    modalContent.appendChild(closeButton);
    modalContent.appendChild(title);
    modalContent.appendChild(form);

    // Agrega el contenido del modal al modal
    modal.appendChild(modalContent);

    // Agrega el modal al cuerpo del documento
    document.body.appendChild(modal);
}

// Resto de las funciones se mantienen igual

