<aside class="filtros">
        <div id="divfiltros">
            <div id="foblacion">
                <form action="resumen.php" method="post" id="filtrarpoblacion">
                <select name="poblacion" id="poblacion">
                <?php    
                listarProvinciaypoblacion($conexion, "poblacion")
                ?>    
                </select>
                    <input type="hidden" id="poblacionHidden" name="poblacionHidden" value="">
                    <input type="submit" name="filtrarporpoblacion" value="Filtrar">
                </form>
            </div>
            <div id="fsector">
                <form action="resumen.php" method="post">
                    <select id="sectorSelect" name="sectorSelect">
                        <?php listarsectores($conexion) ?>
                    </select>
                    <input type="hidden" id="sectorHidden" name="sectorHidden" value="">
                    <input type="submit" name="filtrarsector" value="Filtrar">
                </form>
            </div>
        </div>
    </aside>