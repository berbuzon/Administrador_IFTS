<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">
  <div class="container">
    <h1>Administrador Adolescencia</h1>

    <div class="user-info">
      <?php if (isset($_SESSION["usuario"])): ?>
        <span>👤 Usuario: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></span>
        <a href="/Administrador_IFTS/logout.php" class="logout">Cerrar sesión</a>
      <?php endif; ?>
    </div>

    <nav>
      <ul>
        <!-- <li><a href="/Administrador_IFTS/inicio.php">Inicio</a></li>
        <li><a href="/Administrador_IFTS/crud_adolescentes/listar.php">Adolescentes</a></li>
        <li><a href="/Administrador_IFTS/crud_actividades/listar.php">Actividades</a></li>
        <li><a href="/Administrador_IFTS/crud_instituciones/listar.php">Instituciones</a></li>
        <li><a href="/Administrador_IFTS/reportes/generar_pdf.php">Reportes</a></li>
      </ul> -->
    </nav>
  </div>
</header>

