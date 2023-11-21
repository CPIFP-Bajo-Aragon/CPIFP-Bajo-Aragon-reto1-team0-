<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-2zjzftqJpq2bFA0O4d0oPy/byYo8qz60YU5T1OnF5txU5n6Z7soMKs5d5oJbcFU3Y" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/cabecera.css">
</head>

<body>
    <header>
        <div class="logoEmpresa">
            <a id="linkLogo" href="inicio"><h1><span class="naranja">BA</span>EMPLEA</h1></a>
        </div>

        <?php
          include("../login/verificarLogin.php");
            // echo "<p>HAS ACCEDIDO COMO: " . $_SESSION['tipoUsuario'] . "</p>";
            // echo "<img src='../../img/usuario.png' alt='' width='30' height='30'>" . $_SESSION['nombre_usuario'];
        ?>
        <?php $_SESSION['nombre_usuario']; ?> 
        
        <?php //$_SESSION['tipoUsuario'] = obtenerTipoUsuario();?> 

        <nav class="nav">
            <?php if ($_SESSION['tipoUsuario'] === 'alumno'): ?>
                <ul class="ulCabecera">
                    <li>
                        <i id="logoUser" class="fa fa-circle-user fa-2x"></i>
    
                        <ul id="submenu">
                        <li><a href="datos-personales-alumno">DATOS PERSONALES</a></li>
                            <li><a href="datos-academicos-alumno">DATOS ACADEMICOS</a></li>
                            <li><a href="habilidades-alumno">HABILIDADES</a></li>
                              <!-- <li><a href="habilidades-alumno">CHAT</a></li> -->
                        </ul>
                    </li>
                </ul>

            <?php elseif ($_SESSION['tipoUsuario'] === 'empresa'): ?>
                <ul class="ulCabecera">
                    <li>
                        <i id="logoUser" class="fa fa-circle-user fa-2x"></i>
                        
                        <ul id="submenu">
                            <li><a href="perfil-empresa">DATOS PERSONALES</a></li>
                            <!-- <li><a href="habilidades-alumno">CHAT</a></li> -->
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>

        <form action='verificar' method="post">
            <input class="logout" type="submit" name="logout" value="logout"/>
        </form>

        <!-- <form action='verificar' method="post">
            <button class="logout" type="submit" name="logout" >
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form> -->

       
    </header>


</body>
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
</html>