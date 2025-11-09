<?php
include("conexion.php");

$base = "adl_admin_inscripcion_backup";

// Tablas que querés conservar
$tablas_a_conservar = [
    'adolescentes',
    'formularios',
    'formulario_oferta',
    'ofertas_actividades',
    'actividades',
    'instituciones',
    'datos_personales',
    'usuarios'
];

$result = $conexion->query("SHOW TABLES FROM $base");
while ($fila = $result->fetch_row()) {
    $tabla = $fila[0];
    if (!in_array($tabla, $tablas_a_conservar)) {
        echo "🗑 Eliminando tabla: $tabla<br>";
        $conexion->query("DROP TABLE `$base`.`$tabla`");
    }
}

echo "<hr><strong>✅ Limpieza completa: solo quedaron las tablas esenciales.</strong>";
?>
