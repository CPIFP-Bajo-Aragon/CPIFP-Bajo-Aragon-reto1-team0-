<div id="filtros">
    <div id="fbusqueda">
        <!-- Input para buscar por título -->
        <input type="text" id="filtroTitulo" placeholder="Buscador por Título">
    </div>

    <div id="fpoblacion">
        <select name="poblacionSelect" id="poblacionSelect">
            <?php listarProvinciaypoblacion($conexion, $select_name)?>
        </select>
    </div>

    <div id="fsector">
        <select name="sectorSelect" id="sectorSelect">
            <?php listarsectores($conexion, $select_name) ?>
        </select>    
    </div>
</div>