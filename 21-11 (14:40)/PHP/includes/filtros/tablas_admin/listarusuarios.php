<div class="filtross">
        <!-- Filtro por nombre -->
        <div id="buscadorr">
            <input type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Buscar por el nombre">
        </div>


        <!-- Filtro por año de nacimiento
        <div id="añonacimiento">
            Año de Nacimiento desde:
            <input type="number" id="anioDesde" name="anioDesde" min="1900" max="<?php echo date("Y"); ?>">
            <br>
            Año de Nacimiento hasta:
            <input type="number" id="anioHasta" name="anioHasta" min="1900" max="<?php echo date("Y"); ?>">
            <button id="filtrarPorAnio">Filtrar por Año</button> <!-- Agregado un botón para activar el filtro
        </div> -->


        <!-- Filtro por Carnet de Conducir -->
        <div id="conducirr">
            Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
            <br>
            Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
            <br>
            Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
        </div>


        <!-- Filtro por Población -->
        <div id="poblacion">
            <select name="poblacionSelect" id="poblacionSelect">
                    <?php
                    listarProvinciaypoblacion($conexion, $select_name)
                    ?>
                </select>
        </div>
        <div id="fvalidar">
            <!-- Formulario de filtrado por validación -->
            <form action="usuarios-admin" method="post" id="filtrarValidacion">
                Validado<input type="radio" name="filtrovalidar" value="validado" id="validado">
                <br>
                Sin validar<input type="radio" name="filtrovalidar" value="sinvalidar" id="sinvalidar">
                <br>
                Todos<input type="radio" name="filtrovalidar" value="todos" id="todos">
            </form>
        </div>
    </div>