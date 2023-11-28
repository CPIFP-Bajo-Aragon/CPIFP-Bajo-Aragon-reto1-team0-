<?php
// Función para mostrar el nombre de una población
    function mostrarPoblacion($conexion, $id_poblacion){
        // Consulta SQL para obtener el nombre de la población con el ID proporcionado
        $sql = "SELECT nombre FROM poblacion where id_poblacion = :id_poblacion";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_poblacion con el parámetro proporcionado
        $consulta->bindParam(':id_poblacion', $id_poblacion, PDO::PARAM_INT);
    
        // Ejecuta la consulta
        if($consulta->execute()){
            
            // Itera a través de los resultados y obtiene el nombre de la población
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nombre;
            }

            // Retorna el nombre de la población
            return $nombre;
        }
    }

// Función para mostrar el nombre de un sector
    function mostrarsector($conexion, $id_sector){
        // Consulta SQL para obtener el nombre del sector con el ID proporcionado
        $sql = "SELECT nombre_sector FROM sector where id_sector = :id_sector";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_sector con el parámetro proporcionado
        $consulta->bindParam(':id_sector', $id_sector, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre del sector
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nombre_sector;
            }

            // Retorna el nombre del sector
            return $nombre;
        }
    }


// Función para mostrar el nombre de empresas asociadas a un usuario
    function mostrarempresas($conexion, $id_usuario){
        // Inicializa la variable $nombre para evitar el error "Undefined variable"
        $nombre = "";
        
        // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
        $sql = "SELECT nombre_empresa FROM empresa where id_usuario = :id_usuario";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre de la empresa
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nombre_empresa;
            }

            // Retorna el nombre de la empresa
            return $nombre;
        }
    }


    function mostrarestudios($conexion, $id_estudios){
        $nombre = "";
        
        // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
        $sql = "SELECT nombre_estudio FROM estudio where id_estudio = :id_estudio";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_estudio', $id_estudios, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre de la empresa
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nombre_estudio;
            }

            // Retorna el nombre de la empresa
            return $nombre;
        }
    }

    function mostraridioma($conexion, $id_idioma){
        $nombre = "";
        
        // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
        $sql = "SELECT nombre FROM idioma where id_idioma = :id_idioma";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_idioma', $id_idioma, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre de la empresa
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nombre;
            }

            // Retorna el nombre de la empresa
            return $nombre;
        }
    }

    function mostrarnivel($conexion, $id_nivel){
        $nombre = "";
        
        // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
        $sql = "SELECT nivel FROM nivel where id_nivel = :id_nivel";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_nivel', $id_nivel, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre de la empresa
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->nivel;
            }

            // Retorna el nombre de la empresa
            return $nombre;
        }
    }

    function mostrarexperiencia($conexion, $id){
        $nombre = "";
        
        // Consulta SQL para obtener el nombre de la empresa con el ID de usuario proporcionado
        $sql = "SELECT puesto_trabajo FROM oficio where id_oficio = :id_oficio";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_oficio', $id, PDO::PARAM_INT);

        // Ejecuta la consulta
        if($consulta->execute()){
            // Itera a través de los resultados y obtiene el nombre de la empresa
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $nombre= $fila->puesto_trabajo;
            }

            // Retorna el nombre de la empresa
            return $nombre;
        }
    }
?>