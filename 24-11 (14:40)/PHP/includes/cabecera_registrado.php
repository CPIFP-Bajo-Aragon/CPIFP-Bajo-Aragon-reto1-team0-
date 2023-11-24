

    <!-- Sección de encabezado -->
    <header>

        <script src="../../JS/chat/codigo.js"></script>
        <div class="logoEmpresa">
            <!-- Enlace al inicio con un logotipo -->
            <a id="linkLogo"><h1><span class="naranja">BA</span>EMPLEA</h1></a>
        </div>

        <?php
            // Inclusión del archivo verificarLogin.php para manejar el inicio de sesión
            include("../login/verificarLogin.php");
            
            // echo "<p>HAS ACCEDIDO COMO: " . $_SESSION['tipoUsuario'] . "</p>";
            // echo "<img src='../../img/usuario.png' alt='' width='30' height='30'>" . $_SESSION['nombre_usuario'];
        ?>

        <!-- Se muestra el nombre del usuario (posiblemente falta un echo) -->
        <?php $_SESSION['nombre_usuario']; ?> 
        
        <?php
            // $_SESSION['tipoUsuario'] = obtenerTipoUsuario();
        ?> 

        <!-- Menú de navegación condicional -->
        <nav class="nav">
            <?php if ($_SESSION['tipoUsuario'] === 'alumno'): ?>
                <!-- Menú para usuarios tipo alumno -->
                <ul class="ulCabecera">
                    <li>
                        <!-- Icono de usuario -->
                        <i id="logoUser" class="fa fa-circle-user fa-2x"></i>
    
                        <!-- Submenú para alumnos -->
                        <ul id="submenu">
                            <li><a href="datos-personales-alumno">DATOS PERSONALES</a></li>
                            <li><a href="datos-academicos-alumno">DATOS ACADEMICOS</a></li>
                            <li><a href="habilidades-alumno">HABILIDADES</a></li>
                            <li>
                                <a href="chat">CHAT</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            <?php elseif ($_SESSION['tipoUsuario'] === 'empresa'): ?>
                <!-- Menú para usuarios tipo empresa -->
                <ul class="ulCabecera">
                    <li>
                        <!-- Icono de usuario -->
                        <i id="logoUser" class="fa fa-circle-user fa-2x"></i>
                        
                        <!-- Submenú para empresas -->
                        <ul id="submenu">
                            <li><a href="perfil-empresa">DATOS PERSONALES</a></li>
                            <!-- <li><a href="habilidades-alumno">CHAT</a></li> -->
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>

        <!-- Formulario para realizar logout -->
        <div id="logout">
            <form action='verificar' method="post">
                <input class="logout" type="submit" name="logout" value="logout"/>
            </form>
        </div>

        <!-- Script JavaScript para funciones de ventana modal -->
        <script>
            // Función para abrir la ventana modal
            function openChatModal() {
                document.getElementById('myModal').style.display = 'block';
            }

            // Función para cerrar la ventana modal
            function closeChatModal() {
                document.getElementById('myModal').style.display = 'none';
            }
        </script>
    </header>
