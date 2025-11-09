<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrador Adolescencia</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>

    <?php include("includes/header.php"); ?>
    <?php include("includes/sidebar.php"); ?>

    <main class="contenido inicio">
        <h1 class="titulo-principal">Programa Adolescencia</h1>

        <div class="intro-texto">
            <p>
                Es una iniciativa pensada para estimular las potencialidades y la capacidad creadora de los adolescentes a través de la expresión artística, del acceso a las nuevas tecnologías de información y comunicación como una herramienta de integración social, y de la práctica de actividades físicas y deportivas orientadas al desarrollo de la personalidad, el trabajo en equipo y el cuidado de la salud.
                Está destinado a adolescentes entre 13 y 18 años de edad que integran hogares en situación de vulnerabilidad social en la Ciudad de Buenos Aires.
            </p>
        </div>

        <div class="intro-imagen">
            <img src="assets/img/Adolescentes.png" alt="Programa Adolescencia - GCBA">
        </div>

        <section class="usuario-actual">
            <article>
                <p>Usuario actual: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></p>
            </article>
        </section>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>
