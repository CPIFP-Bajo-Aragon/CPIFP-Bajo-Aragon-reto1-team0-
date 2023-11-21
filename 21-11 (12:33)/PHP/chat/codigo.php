<?php
    include("../includes/conexion.php");
    include("../includes/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
body {
  font-family: Arial, sans-serif;
}

.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
}

.modal-contenido {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.cerrar {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

    </style>
</head>
<body>
    
    <button id="mostrarModal">Abrir Empresas</button>

    <button id="mostrarModalAlumnos">Abrir Alumnos</button>

    <button id="mostrarModalAdmin">Abrir Alumnos</button>


    <!-- MODAL MOSTRAR EMPRESAS -->
    <div id="miModal" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <div id="empresachat">
                <table id="tablaempesachat">
                    <?php
                        listarempresachat($conexion);
                    ?>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL MOSTRAR ALUMNOS -->
    <div id="miModalAlumnos" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <!-- <p>¡Este es el contenido de la ventana modal!</p> -->
            <div id="alumnochat">
                <table id="tablachatalumno">
                    <?php
                        listaralumnochat($conexion);
                    ?>
                </table>
            </div>
        </div>
    </div>

        <!-- MODAL MOSTRAR ADMINISTRADORES -->
    <div id="miModalAlumnos" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <!-- <p>¡Este es el contenido de la ventana modal!</p> -->
            <div id="adminchat">
                <table id="tablachatadmin">
                    <?php
                        listaradminchat($conexion);
                    ?>
                </table>
            </div>
        </div>
    </div>







</body>
</html>
<script>
    // MODAL EMPRESAS
// Función para mostrar la ventana modal
function mostrarModal() {
  document.getElementById('miModal').style.display = 'block';
}

// Función para cerrar la ventana modal
function cerrarModal() {
  document.getElementById('miModal').style.display = 'none';
}

// Asociar la función mostrarModal al botón
document.getElementById('mostrarModal').addEventListener('click', mostrarModal);

    // MODAL ALUMNOS
// function mostrarModalAlumnos() {
//   document.getElementById('miModalAlumnos').style.display = 'block';
// }

// function cerrarModal() {
//   document.getElementById('miModalAlumnos').style.display = 'none';
// }

// document.getElementById('mostrarModalAlumnos').addEventListener('click', mostrarModal);
</script>