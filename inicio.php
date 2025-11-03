<?php
session_start();
if(!isset($_SESSION["usuario"])){
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

<header>
    <div class="container">
        <h1>Administrador Adolescencia</h1>
        <p style="text-align:right;">Usuario: <strong><?php echo $_SESSION["usuario"]; ?></strong> |
           <a href="logout.php" class="boton-salir">Cerrar sesión</a></p>
        <nav>
            <ul>
                <li><a href="#" class="activo">Inicio</a></li>
                <li><a href="#">Reportes</a></li>
                <li><a href="#">Usuarios</a></li>
                <li><a href="#">Contactos</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <aside>
        <h2>Panel lateral</h2>
        <ul>
            <li><a href="#">Gestión de usuarios</a></li>
            <li><a href="#">Actividades</a></li>
            <li><a href="#">Adolescentes</a></li>
        </ul>
    </aside>

    <section>
        <h2>Panel principal</h2>
        <article>
            <h3>Bienvenido al sistema</h3>
            <p>El sistema de administración de actividades para adolescentes está conectado correctamente con la base de datos <strong>adl_admin_inscripcion</strong>.</p>
        </article>
    </section>
</main>

<footer>
    <p>© 2025 IFTS N°4 — TP Integrador (HTML + CSS + PHP)</p>
</footer>

</body>
</html>
