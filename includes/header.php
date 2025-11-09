<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">
  <div class="header-wrapper">

    <div class="header-center">
      <h1>Administrador Adolescencia</h1>
    </div>

    <div class="header-right">
      <?php if (isset($_SESSION["usuario"])): ?>
        <span>👤 Usuario: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></span>
        <a href="/Administrador_IFTS/logout.php" class="logout">Cerrar sesión</a>
      <?php endif; ?>
    </div>

  </div>
</header>




