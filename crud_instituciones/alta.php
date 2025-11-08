<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /Administrador_IFTS/crud_instituciones/listar.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $valor = trim($_POST['valor']);
    $vigente = isset($_POST['vigente']) ? intval($_POST['vigente']) : 0;

    if ($valor !== "") {
        $sql = "INSERT INTO adl_admin_inscripcion.instituciones (valor, vigente) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $valor, $vigente);

        if ($stmt->execute()) {
            $mensaje = "✅ Institución creada correctamente.";
        } else {
            $mensaje = "❌ Error al crear la institución: " . $conexion->error;
        }

        $stmt->close();
    } else {
        $mensaje = "⚠️ El nombre de la institución es obligatorio.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Institución</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

<main class="contenido">
    <h1>Alta de nueva institución</h1>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="form-crud">
        <label>Nombre de la institución:</label>
        <input type="text" name="valor" required>

        <label>Vigencia:</label>
        <select name="vigente">
            <option value="1">Vigente</option>
            <option value="0">No vigente</option>
        </select>

        <input type="submit" value="Guardar institución">
        <a href="/Administrador_IFTS/crud_instituciones/listar.php" class="boton-volver">Volver al listado</a>
    </form>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>
</body>
</html>
