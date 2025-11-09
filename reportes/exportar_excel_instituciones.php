<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

$sql = "
    SELECT 
        i.id AS ID,
        i.valor AS Institución,
        CASE WHEN i.vigente = 1 THEN 'Vigente' ELSE 'No vigente' END AS Estado
    FROM adl_admin_inscripcion.instituciones i
    ORDER BY i.valor
";

$resultado = $conexion->query($sql);

header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=instituciones.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
echo '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><body>';
echo "<table border='1'>
        <tr style='background-color:#1d3557; color:white; font-weight:bold;'>
            <th>ID</th><th>Institución</th><th>Estado</th>
        </tr>";

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        foreach ($fila as $valor) {
            echo "<td>" . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No se encontraron registros</td></tr>";
}

echo "</table></body></html>";
exit;
?>

