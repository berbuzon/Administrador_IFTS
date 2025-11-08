<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /Administrador_IFTS/crud_actividades/listar.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = intval($_GET['id']);
$mensaje = "";

$sql = "UPDATE adl_admin_inscripcion.actividades SET vigente = 0 WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $mensaje = "✅ Actividad dada de baja correctamente.";
} else {
    $mensaje = "❌ Error al dar de baja la actividad: " . $conexion->error;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Baja de Actividad</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

<main class="contenido">
    <h1>Baja de actividad</h1>

    <p class="mensaje"><?php echo $mensaje; ?></p>

    <p>
        <a href="/Administrador_IFTS/crud_actividades/listar.php" class="boton-volver">← Volver al listado</a>
    </p>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>
</body>
</html>
