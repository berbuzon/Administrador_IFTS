<?php
// ---------------------------------------------
// BACKUP COMPLETO SIN MYSQldump (compatible PHP < 7.4)
// ---------------------------------------------
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');
include("conexion.php");

$base = "adl_admin_inscripcion_backup";
$carpeta = __DIR__ . "/_db_backups";
if (!is_dir($carpeta)) mkdir($carpeta, 0777, true);

$archivo = $carpeta . "/" . $base . "_" . date("Ymd_His") . ".sql";

$tablas = [];
$res = $conexion->query("SHOW TABLES FROM `$base`");
while ($fila = $res->fetch_array()) {
    $tablas[] = $fila[0];
}

$salida = "-- Backup generado automáticamente\n";
$salida .= "-- Base: $base\n";
$salida .= "-- Fecha: " . date("Y-m-d H:i:s") . "\n\n";
$conexion->select_db($base);

foreach ($tablas as $tabla) {
    $salida .= "DROP TABLE IF EXISTS `$tabla`;\n";
    $resCreate = $conexion->query("SHOW CREATE TABLE `$tabla`");
    $rowCreate = $resCreate->fetch_assoc();
    $salida .= $rowCreate['Create Table'] . ";\n\n";

    $resData = $conexion->query("SELECT * FROM `$tabla`");
    if ($resData && $resData->num_rows > 0) {
        while ($fila = $resData->fetch_assoc()) {
            $cols = array_map(function($v) { return "`" . $v . "`"; }, array_keys($fila));
            $vals = array_map(function($v) use ($conexion) { 
                return "'" . $conexion->real_escape_string($v) . "'"; 
            }, array_values($fila));
            $salida .= "INSERT INTO `$tabla` (" . implode(",", $cols) . ") VALUES (" . implode(",", $vals) . ");\n";
        }
        $salida .= "\n";
    }
}

file_put_contents($archivo, $salida);
$conexion->close();

if (file_exists($archivo)) {
    echo "<h3>✅ Backup exportado correctamente</h3>";
    echo "<p>Archivo guardado en:<br><strong>$archivo</strong></p>";
} else {
    echo "<h3>❌ Error: no se pudo generar el archivo.</h3>";
}
?>
