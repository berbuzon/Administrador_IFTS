<?php
include("../conexion.php");
session_start();

// Protección
if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

// Validar parámetro
if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit();
}

$id_adolescente = intval($_GET["id"]);
$mensaje = "";

// Actualizar estado = 5 (baja) en formulario_oferta
$sql = "
UPDATE formulario_oferta
SET estado = 5
WHERE formulario_id IN (
    SELECT id FROM formularios WHERE id_adolescente = ?
)
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_adolescente);

if ($stmt->execute()) {
    $mensaje = "✅ Adolescente dado de baja correctamente.";
} else {
    $mensaje = "❌ Error al dar de baja: " . $conexion->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Baja de Adolescente</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>

<body>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

<main class="contenido">
    <h1>Baja de adolescente</h1>

    <p class="mensaje"><?php echo $mensaje; ?></p>

    <p>
        <a href="/Administrador_IFTS/crud_adolescentes/listar.php" class="boton-volver">← Volver al listado</a>
    </p>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

</body>
</html>
