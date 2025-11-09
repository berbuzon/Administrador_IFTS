<?php
include("conexion.php");

// Nombres de las bases
$origen = "adl_admin_inscripcion";
$destino = "adl_admin_inscripcion_backup";

// Crear la base destino si no existe
if (!$conexion->query("CREATE DATABASE IF NOT EXISTS `$destino` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;")) {
    die("Error creando la base destino: " . $conexion->error);
}

// Listar tablas de la base de origen
$tablas = $conexion->query("SHOW TABLES FROM `$origen`");
if (!$tablas) {
    die("Error listando tablas: " . $conexion->error);
}

while ($fila = $tablas->fetch_row()) {
    $tabla = $fila[0];
    echo "<p>🔹 Copiando tabla: <strong>$tabla</strong>...</p>";

    // Crear estructura
    $conexion->query("CREATE TABLE `$destino`.`$tabla` LIKE `$origen`.`$tabla`;");

    // Copiar datos
    $conexion->query("INSERT INTO `$destino`.`$tabla` SELECT * FROM `$origen`.`$tabla`;");
}

echo "<hr><h3>✅ Copia completada exitosamente en '$destino'.</h3>";
?>
