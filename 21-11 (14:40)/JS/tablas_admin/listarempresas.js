document.addEventListener('DOMContentLoaded', function () {
    Event.preventDefault();
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
// Filtrador por sector
const filtroSectorSelect = document.getElementById('sectorSelect');
filtroSectorSelect.addEventListener('change', function () {
    

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


 // Función para abrir la ventana modal
function openModal(modalId) {
 var modal = document.getElementById(modalId);
 modal.style.display = 'block';
}

// Asigna la función openModal al botón de abrir modal para empresas
document.getElementById('editar').addEventListener('click', function (event) {
    // Asignar valores a los campos de la modal
    document.getElementById('nombre_empresa_modal').value = datosEmpresa.nombre;
    document.getElementById('cif_modal').value = datosEmpresa.cif;
    document.getElementById('direccion_modal').value = datosEmpresa.direccion;
    document.getElementById('correo_modal').value = datosEmpresa.correo;
    document.getElementById('poblacion_modal').value = datosEmpresa.poblacion;
    document.getElementById('sector_modal').value = datosEmpresa.sector;
    document.getElementById('telefono_modal').value = datosEmpresa.telefono;

    // Crear el contenido de la modal dinámicamente
    var modalContent = document.createElement('div');
    modalContent.className = 'modal-content';
        // Crear el contenido de la modal dinámicamente
        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
    
        var closeButton = document.createElement('span');
        closeButton.className = 'close';
        closeButton.innerHTML = '&times;';
        closeButton.onclick = function () {
            cerrarModal('modalEmpresa');
        };
    
        var modalTitle = document.createElement('h2');
        modalTitle.textContent = 'Detalles de la Empresa';
    
        // Agregar los campos a la modal
        var form = document.createElement('form');
        form.id = 'formularioEmpresa';
    
        var campos = ['nombre_empresa_modal', 'cif_modal', 'direccion_modal', 'correo_modal', 'poblacion_modal', 'sector_modal', 'telefono_modal'];
    
        campos.forEach(function (campo) {
            var label = document.createElement('label');
            label.for = campo;
            label.textContent = campo.replace('_modal', '').replace('_', ' ');
    
            var input = document.createElement('input');
            input.type = 'text'; // Ajusta el tipo según el campo (puedes usar 'email' para correo, etc.)
            input.id = campo;
            input.name = campo;
            input.required = true;
    
            form.appendChild(label);
            form.appendChild(input);
        });
    
        modalContent.appendChild(closeButton);
        modalContent.appendChild(modalTitle);
        modalContent.appendChild(form);
    
     // Obtener el contenedor de la modal y agregar el contenido
     var modal = document.getElementById('modalEmpresa');
     modal.innerHTML = ''; // Limpiar el contenido actual
     modal.appendChild(modalContent);
 
     // Mostrar la modal
     openModal('modalEmpresa');
 
     event.preventDefault(); // Mover event.preventDefault() al final de la función
 });



// Función para cerrar la ventana modal
function cerrarModal(modalId) {
var modal = document.getElementById(modalId);
modal.style.display = 'none';
}

// Asigna la función cerrarModal al span de cerrar modal para empresas
document.getElementById('modalEmpresa').getElementsByClassName('close')[0].addEventListener('click', function() {
cerrarModal('modalEmpresa');
});



});

