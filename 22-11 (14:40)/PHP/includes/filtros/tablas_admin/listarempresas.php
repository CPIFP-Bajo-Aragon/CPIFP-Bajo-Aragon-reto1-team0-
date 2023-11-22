<div id="divfiltros">
        <div id="fbuscador">
            <!-- Formulario de búsqueda por nombre de empresas -->
            <form method="POST" action="empresas-admin">
                <input type="text" name="buscador" id="buscador" placeholder="Buscar empresas">
            </form>
        </div>
        <div id="foblacion">
            <!-- Formulario de filtrado por población -->
            <form action="empresas-admin" method="post" id="filtrarpoblacion">
                <select name="poblacionSelect" id="poblacionSelect">
                <?php
                listarProvinciaypoblacion($conexion, "poblacionSelect")
                ?>
                </select>
            </form>
        </div>
        <div id="fsector">
            <!-- Formulario de filtrado por sector -->
            <form action="empresas-admin" method="post">
                <select id="sectorSelect" name="sectorSelect">
                    <?php listarsectores($conexion) ?>
                </select>
            </form>
        </div>
        <div id="fvalidar">
            <!-- Formulario de filtrado por validación -->
            <form action="empresas-admin" method="post" id="filtrarValidacion">
                Validado<input type="radio" name="filtrovalidar" value="validado" id="validado">
                <br>
                Sin validar<input type="radio" name="filtrovalidar" value="sinvalidar" id="sinvalidar">
                <br>
                Todos<input type="radio" name="filtrovalidar" value="todos" id="todos">
            </form>
        </div>
    </div>