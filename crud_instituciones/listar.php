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
        i.id,
        i.valor,
        i.vigente
    FROM adl_admin_inscripcion.instituciones i
    ORDER BY i.id
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Instituciones</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Listado de instituciones</h1>


        <p style="text-align: right; margin-bottom: 15px;">
            <a href="/Administrador_IFTS/reportes/generar_pdf_adolescentes.php" class="boton">🧾 Exportar a PDF</a>
        </p>

        <?php if ($esAdmin): ?>
            <p><a href="/Administrador_IFTS/crud_instituciones/alta.php" class="boton">➕ Agregar nueva institución</a></p>
        <?php endif; ?>

        <table class="tabla-crud">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre de la institución</th>
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
                            <td class="<?php echo $fila['vigente'] ? 'vigente' : 'no-vigente'; ?>">
                            <?php echo $fila['vigente'] ? 'Vigente' : 'No vigente'; ?>
                            </td>
                            <?php if ($esAdmin): ?>
                                <td>
                                    <a class="accion editar" href="/Administrador_IFTS/crud_instituciones/editar.php?id=<?php echo $fila['id']; ?>">✏️ Editar</a> |
                                    <a class="accion eliminar" href="/Administrador_IFTS/crud_instituciones/baja.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Dar de baja esta institución?');">⛔ Baja</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo $esAdmin ? 4 : 3; ?>">No se encontraron instituciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>
</body>
</html>
