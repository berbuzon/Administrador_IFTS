<?php
include("../conexion.php");
session_start();

// Protección: solo usuarios logueados
if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

// CONSULTA: adolescentes con estado = 2 (aceptados)
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
WHERE fo.estado = 2
ORDER BY dp.apellido, dp.nombre
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Adolescentes Activos</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Listado de adolescentes activos</h1>

        <p style="text-align: right; margin-bottom: 15px;">
            <a href="/Administrador_IFTS/reportes/generar_pdf.php" class="boton">🧾 Exportar a PDF</a>
        </p>

        <p><a href="/Administrador_IFTS/crud_adolescentes/alta.php" class="boton">➕ Agregar nuevo adolescente</a></p>

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
                    <th>Acciones</th>
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
                            <td>
                                <a class="accion editar" href="/Administrador_IFTS/crud_adolescentes/editar.php?id=<?php echo $fila['id_adolescente']; ?>">✏️ Editar</a> |
                                <a class="accion eliminar" href="/Administrador_IFTS/crud_adolescentes/baja.php?id=<?php echo $fila['id_adolescente']; ?>"
                                    onclick="return confirm('¿Dar de baja a este adolescente?');">⛔ Baja</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No se encontraron adolescentes activos (estado = 2)</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

</body>
</html>
