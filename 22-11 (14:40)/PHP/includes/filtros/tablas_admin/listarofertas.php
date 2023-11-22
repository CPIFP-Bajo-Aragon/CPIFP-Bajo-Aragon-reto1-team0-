<div id="filtros">
        <div id="fbusqueda">
            <!-- Input para buscar por título -->
            <input type="text" id="filtroTitulo" placeholder="Buscador por Título">
        </div>
        <div id="fpoblacion">
            <select name="poblacionSelect" id="poblacionSelect">
                    <?php
                    listarProvinciaypoblacion($conexion, $select_name)
                    ?>
                    </select>
        </div>
        <div id="meses">
            <!-- Filtro para la duración del contrato -->
            <label for="">Duración del Contrato:</label>
            <input type="range" id="filtroDuracionContrato" min="0" max="24" step="1" value="0">
            <span id="duracionContratoLabel">Cualquier duración</span>
        </div>  
        <div id="conducir">
            <!-- Filtros para requerir carnet de conducir -->
            Con Carnet de Conducir<input type="radio" name="filtroCarnet" value="conCarnet" id="conCarnet">
            <br>
            Sin Carnet de Conducir<input type="radio" name="filtroCarnet" value="sinCarnet" id="sinCarnet">
            <br>
            Todos<input type="radio" name="filtroCarnet" value="todos" id="todos">
        </div>
    </div>