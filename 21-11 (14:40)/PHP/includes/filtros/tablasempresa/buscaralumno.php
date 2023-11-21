<div id="filtross">
        <!-- Filtro por nombre -->
        <div id="buscadorr">
            <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
        </div>

        <!-- Filtro por Carnet de Conducir -->
        <div id="conducirr">
            Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
            <br>
            Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
            <br>
            Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
        </div>

        <!-- Filtro por Población -->
        <div id="poblaciondiv">
            <select name="poblacion" id="poblacion">
                <?php    
                    listarProvinciaypoblacion($conexion)
                ?>    
            </select>
        </div>
    </div>