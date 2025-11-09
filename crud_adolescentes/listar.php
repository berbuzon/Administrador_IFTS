<?php
include("../conexion.php");
session_start();

// Protección: solo usuarios logueados
if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

$esAdmin = isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin";

// CONSULTA: adolescentes con estado = 2 (aceptados) y = 1 (pendientes)
$sql = "
SELECT 
    a.id AS id_adolescente,
    dp.nombre,
    dp.apellido,
    dp.numero_doc,
    dp.genero,
    dp.fecha_nacimiento,
    a.ingreso_programa,
    fo.estado
FROM adolescentes a
INNER JOIN datos_personales dp ON dp.id = a.id_datos_personales
INNER JOIN formularios f ON f.id_adolescente = a.id
INNER JOIN formulario_oferta fo ON fo.formulario_id = f.id
WHERE fo.estado IN (1, 2)
ORDER BY dp.id
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Adolescentes Inscriptos</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Listado de adolescentes</h1>

        <p style="text-align: right; margin-bottom: 15px;">
            <?php if ($esAdmin): ?>
                <a href="/Administrador_IFTS/crud_adolescentes/alta.php" class="boton">➕ Agregar nuevo adolescente</a>
            <?php endif; ?>
            <a href="/Administrador_IFTS/reportes/generar_pdf_adolescentes.php" class="boton">🧾 Exportar a PDF</a>
            <a href="/Administrador_IFTS/reportes/exportar_excel_adolescentes.php" class="boton" style="background-color: #107c41;">📊 Exportar a Excel</a>
        </p>




        <table class="tabla-crud">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Género</th>
                    <th>Fecha Nac.</th>
                    <th>Ingreso Programa</th>
                    <?php if ($esAdmin): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila["id_adolescente"]; ?></td>
                            <td><?php echo htmlspecialchars($fila["apellido"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["numero_doc"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["genero"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["fecha_nacimiento"]); ?></td>
                            <td><?php echo htmlspecialchars($fila["ingreso_programa"]); ?></td>
                            <?php if ($esAdmin): ?>
                                <td>
                                    <a class="accion editar" href="/Administrador_IFTS/crud_adolescentes/editar.php?id=<?php echo $fila['id_adolescente']; ?>">✏️ Editar</a> |
                                    <a class="accion eliminar" href="/Administrador_IFTS/crud_adolescentes/baja.php?id=<?php echo $fila['id_adolescente']; ?>" onclick="return confirm('¿Dar de baja a este adolescente?');">⛔ Baja</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo $esAdmin ? 8 : 7; ?>">No se encontraron adolescentes activos (estado = 2)</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

</body>

</html>