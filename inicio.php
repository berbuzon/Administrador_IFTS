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

<main class="contenido">
    <h1>Bienvenido al sistema</h1>

    <section>
        <article>
            <h3>Panel principal</h3>
            <p>El sistema de administración de actividades para adolescentes está conectado correctamente con la base de datos <strong>adl_admin_inscripcion</strong>.</p>
            <p>Usuario actual: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></p>
        </article>
    </section>
</main>

<?php include("includes/footer.php"); ?>

</body>
</html>
