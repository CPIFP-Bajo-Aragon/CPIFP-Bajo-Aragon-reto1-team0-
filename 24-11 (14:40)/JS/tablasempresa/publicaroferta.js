
    function agregarElemento(contenedorId) {
        var contenedor = document.getElementById(contenedorId);
        var nuevoElemento = contenedor.firstElementChild.cloneNode(true);
        contenedor.appendChild(nuevoElemento);
    }

    function eliminarElemento(contenedorId) {
        var contenedor = document.getElementById(contenedorId);
        var hijos = contenedor.children;
        if (hijos.length > 1) {
            contenedor.removeChild(hijos[hijos.length - 1]);
        }
    }
