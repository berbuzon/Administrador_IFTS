<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Programa Adolescencia</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>

<?php include('conexion.php'); ?>

<header>
    <div class="container">
        <h1>Administrador Programa Adolescencia</h1>
        <nav>
            <ul>
                <li><a href="#" class="activo">Inicio</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">Reportes</a></li>
                <li><a href="#">Contactos</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <aside>
        <h2>Panel lateral</h2>
        <ul>
            <li><a href="#">Estado de conexión</a></li>
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
            <p>Desde este panel podrás realizar las operaciones CRUD, visualizar reportes y administrar usuarios.</p>
        </article>
    </section>
</main>

<footer>
    <p>© 2025 IFTS N°4 — TP Integrador (HTML + CSS + PHP) | Desarrollado sin frameworks</p>
</footer>

</body>
</html>
