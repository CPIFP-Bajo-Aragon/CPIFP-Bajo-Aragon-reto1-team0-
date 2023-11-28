<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Principal</title>
    <link rel="stylesheet" href="CSS/index.css">
    <?php
    include("PHP/includes/links.php");
    ?>
</head>

<body class="grid-container">

    <?php include "PHP/includes/cabecera.php" ?>

    <main id="mainindex">
        <aside class="mainindex">
            <div class="container">
                <h1 class="azul">
                    <div><span class="naranja">B</span>AJO <span class="naranja">A</span>RAGÓN </div>
                    <div>EMPLEA</div>
                </h1>
            </div>
            
        </aside>

        <article class="aside">
            <p>Destaca tu empresa en el Bajo Aragón publicando ofertas de trabajo. </p>
            <p>Encuentra oportunidades laborales como estudiante titulado.</p>
                <a href="inicio-sesion">
                    <button class="boton2">Iniciar sesión</button>
                </a>
        </article>
    </main>

    <?php include "PHP/includes/footer.php" ?>

</body>

</html>








