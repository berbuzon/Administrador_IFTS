<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

$sql = "
    SELECT 
        a.id AS ID,
        dp.apellido AS Apellido,
        dp.nombre AS Nombre,
        dp.numero_doc AS DNI,
        dp.genero AS Género,
        dp.fecha_nacimiento AS 'Fecha de nacimiento',
        a.ingreso_programa AS 'Ingreso al Programa'
    FROM adl_admin_inscripcion.adolescentes a
    INNER JOIN adl_admin_inscripcion.datos_personales dp 
        ON dp.id = a.id_datos_personales
    ORDER BY dp.apellido, dp.nombre
";

$resultado = $conexion->query($sql);

header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=adolescentes.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
echo '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><body>';
echo "<table border='1'>
        <tr style='background-color:#1d3557; color:white; font-weight:bold;'>
            <th>ID</th><th>Apellido</th><th>Nombre</th><th>DNI</th>
            <th>Género</th><th>Fecha de nacimiento</th><th>Ingreso al Programa</th>
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
    echo "<tr><td colspan='7'>No se encontraron registros</td></tr>";
}

echo "</table></body></html>";
exit;
?>
