<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

// Verificamos si se pasó el ID del adolescente
if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit();
}

$id_adolescente = intval($_GET["id"]);
$mensaje = "";

// Obtener los datos actuales
$sql = "
SELECT 
    a.id AS id_adolescente,
    dp.id AS id_datos_personales,
    dp.nombre,
    dp.apellido,
    dp.numero_doc,
    dp.genero,
    dp.fecha_nacimiento,
    a.ingreso_programa
FROM adolescentes a
INNER JOIN datos_personales dp ON dp.id = a.id_datos_personales
WHERE a.id = ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_adolescente);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

if (!$datos) {
    $mensaje = "⚠️ Adolescente no encontrado.";
}

// Cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $numero_doc = trim($_POST["numero_doc"]);
    $genero = $_POST["genero"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $ingreso_programa = $_POST["ingreso_programa"];
    $id_datos_personales = intval($_POST["id_datos_personales"]);

    if ($nombre && $apellido && $numero_doc && $genero && $fecha_nacimiento && $ingreso_programa) {
        // Actualizar datos_personales
        $sql_dp = "UPDATE datos_personales
                   SET nombre=?, apellido=?, numero_doc=?, genero=?, fecha_nacimiento=?
                   WHERE id=?";
        $stmt_dp = $conexion->prepare($sql_dp);
        $stmt_dp->bind_param("sssssi", $nombre, $apellido, $numero_doc, $genero, $fecha_nacimiento, $id_datos_personales);

        // Actualizar adolescentes
        $sql_ad = "UPDATE adolescentes
                   SET ingreso_programa=?
                   WHERE id=?";
        $stmt_ad = $conexion->prepare($sql_ad);
        $stmt_ad->bind_param("si", $ingreso_programa, $id_adolescente);

        if ($stmt_dp->execute() && $stmt_ad->execute()) {
            $mensaje = "✅ Datos actualizados correctamente.";
        } else {
            $mensaje = "❌ Error al actualizar: " . $conexion->error;
        }
    } else {
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Adolescente</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>

<body>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

<main class="contenido">
    <h1>Editar adolescente</h1>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if ($datos): ?>
        <form action="" method="POST" class="form-crud">
            <input type="hidden" name="id_datos_personales" value="<?php echo $datos['id_datos_personales']; ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required>

            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($datos['apellido']); ?>" required>

            <label>DNI:</label>
            <input type="text" name="numero_doc" value="<?php echo htmlspecialchars($datos['numero_doc']); ?>" required>

            <label>Género:</label>
            <select name="genero" required>
                <option value="varon" <?php if($datos['genero']=="varon") echo "selected"; ?>>Varón</option>
                <option value="mujer" <?php if($datos['genero']=="mujer") echo "selected"; ?>>Mujer</option>
                <option value="no_contesta" <?php if($datos['genero']=="no_contesta") echo "selected"; ?>>No contesta</option>
            </select>

            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="<?php echo $datos['fecha_nacimiento']; ?>" required>

            <label>Ingreso al programa:</label>
            <input type="date" name="ingreso_programa" value="<?php echo $datos['ingreso_programa']; ?>" required>

            <input type="submit" value="Guardar cambios">
            <a href="/Administrador_IFTS/crud_adolescentes/listar.php" class="boton-volver">Volver al listado</a>
        </form>
    <?php endif; ?>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

</body>
</html>
