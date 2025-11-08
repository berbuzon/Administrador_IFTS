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

$sql = "SELECT id, valor, vigente FROM adl_admin_inscripcion.actividades WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$actividad = $resultado->fetch_assoc();
$stmt->close();

if (!$actividad) {
    $mensaje = "⚠️ Actividad no encontrada.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $actividad) {
    $valor = trim($_POST['valor']);
    $vigente = isset($_POST['vigente']) ? intval($_POST['vigente']) : 0;

    if ($valor !== "") {
        $sql_update = "UPDATE adl_admin_inscripcion.actividades SET valor = ?, vigente = ? WHERE id = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("sii", $valor, $vigente, $id);

        if ($stmt_update->execute()) {
            $mensaje = "✅ Actividad actualizada correctamente.";
            $actividad['valor'] = $valor;
            $actividad['vigente'] = $vigente;
        } else {
            $mensaje = "❌ Error al actualizar la actividad: " . $conexion->error;
        }

        $stmt_update->close();
    } else {
        $mensaje = "⚠️ El nombre de la actividad es obligatorio.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Actividad</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

<main class="contenido">
    <h1>Editar actividad</h1>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if ($actividad): ?>
        <form action="" method="POST" class="form-crud">
            <label>Nombre de la actividad:</label>
            <input type="text" name="valor" value="<?php echo htmlspecialchars($actividad['valor']); ?>" required>

            <label>Vigencia:</label>
            <select name="vigente">
                <option value="1" <?php echo $actividad['vigente'] ? 'selected' : ''; ?>>Vigente</option>
                <option value="0" <?php echo !$actividad['vigente'] ? 'selected' : ''; ?>>No vigente</option>
            </select>

            <input type="submit" value="Guardar cambios">
            <a href="/Administrador_IFTS/crud_actividades/listar.php" class="boton-volver">Volver al listado</a>
        </form>
    <?php endif; ?>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>
</body>
</html>
