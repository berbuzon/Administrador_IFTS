<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

$esAdmin = isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin";

$sql = "
    SELECT
        id,
        valor,
        vigente
    FROM adl_admin_inscripcion.actividades
    ORDER BY id
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Actividades</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Listado de actividades</h1>

        <?php if ($esAdmin): ?>
            <p><a href="/Administrador_IFTS/crud_actividades/alta.php" class="boton">➕ Agregar nueva actividad</a></p>
        <?php endif; ?>

        <table class="tabla-crud">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre de la actividad</th>
                    <th>Vigencia</th>
                    <?php if ($esAdmin): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo htmlspecialchars($fila['valor']); ?></td>
                            <td><?php echo $fila['vigente'] ? 'Vigente' : 'No vigente'; ?></td>
                            <?php if ($esAdmin): ?>
                                <td>
                                    <a class="accion editar" href="/Administrador_IFTS/crud_actividades/editar.php?id=<?php echo $fila['id']; ?>">✏️ Editar</a> |
                                    <a class="accion eliminar" href="/Administrador_IFTS/crud_actividades/baja.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Dar de baja esta actividad?');">⛔ Baja</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo $esAdmin ? 4 : 3; ?>">No se encontraron actividades registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>
</body>
</html>
