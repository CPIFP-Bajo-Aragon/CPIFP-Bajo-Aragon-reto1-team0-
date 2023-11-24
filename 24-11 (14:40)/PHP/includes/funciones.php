

<?php

    function paginar($max_filas_por_pagina, $conexion, $total_filas) {
            
        // Calcula el número total de páginas necesarias
        $total_paginas = ceil($total_filas / $max_filas_por_pagina);

        // Imprime el inicio del menú desplegable
        echo ('Página: <select name="pagina" id="pagina" onchange="this.form.submit()">');

        // Itera a través de las páginas y genera opciones para el menú desplegable
        for ($i = 1; $i <= $total_paginas; $i++) {
            // Verifica si la página actual es la seleccionada
            $selected = ($_POST['pagina'] == $i) ? 'selected' : '';

            // Imprime la opción del menú desplegable
            echo ("<option value='$i' $selected>$i</option>");
        }

        // Cierra el menú desplegable
        echo ('</select>');
    }


// Función para verificar un usuario antes se llamava validarusuario
    function verificarusuario($conexion, $nombre_usuario, $password){
        // Verifica si la solicitud es de tipo POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $sql = "SELECT * FROM usuario WHERE nombre_usuario = ? and password = ?"; 
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(1, $nombre_usuario);
            $consulta->bindParam(2, $password);
            $consulta->execute();
            $numFilas = $consulta->rowCount();

            // Retorna la cantidad de filas encontradas
            return $numFilas;
        }
    }

// Función para validar el registro un usuario
    function validarregistro($conexion, $id_usuario) {

        // Prepara la consulta SQL para actualizar el campo 'validado' a 1
        $sql = "UPDATE usuario SET validado = 1 WHERE id_usuario = :id_usuario";

        // Prepara la consulta utilizando la conexión proporcionada
        $consulta = $conexion->prepare($sql);

        // Asocia el valor de :id_usuario con el parámetro proporcionado
        $consulta->bindParam(':id_usuario', $id_usuario);

        // Ejecuta la consulta para actualizar el estado de validación
        $consulta->execute();
    }

//OBTENER NOMBRES A TRAVES DEL ID
include("funciones/funcionesnombre_id.php");

//Funciones de select
include("funciones/funcionselects.php");

//Funciones de alumno
include("funciones/funcionesalumnos.php");

//Funciones de empresas

include("funciones/funcionesempresa.php");

//Funciones de admin
include("funciones/funcionesadmin.php");

include("funciones/funcioneschat.php");
?>
