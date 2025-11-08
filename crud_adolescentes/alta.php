<?php
include("../conexion.php");
session_start();

// Protección
if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos personales
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $numero_doc = trim($_POST["numero_doc"]);
    $genero = $_POST["genero"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];

    // Validación simple
    if ($nombre && $apellido && $numero_doc && $genero && $fecha_nacimiento) {

        // 1️⃣ Insertar en datos_personales
        $sql_dp = "INSERT INTO datos_personales (nombre, apellido, numero_doc, genero, fecha_nacimiento)
               VALUES (?, ?, ?, ?, ?)";
        $stmt_dp = $conexion->prepare($sql_dp);
        $stmt_dp->bind_param("sssss", $nombre, $apellido, $numero_doc, $genero, $fecha_nacimiento);

        if ($stmt_dp->execute()) {
            $id_datos_personales = $conexion->insert_id;

            // 2️⃣ Insertar en adolescentes
            $sql_ad = "INSERT INTO adolescentes (id_datos_personales, ingreso_programa)
                   VALUES (?, CURDATE())";
            $stmt_ad = $conexion->prepare($sql_ad);
            $stmt_ad->bind_param("i", $id_datos_personales);

            if ($stmt_ad->execute()) {
                $id_adolescente = $conexion->insert_id;

                // 3️⃣ Insertar en formularios
                $sql_form = "INSERT INTO formularios (id_adolescente, confirmado)
                         VALUES (?, 0)";
                $stmt_form = $conexion->prepare($sql_form);
                $stmt_form->bind_param("i", $id_adolescente);

                if ($stmt_form->execute()) {
                    $id_formulario = $conexion->insert_id;

                    // 4️⃣ Insertar en formulario_oferta (estado = 1 = pendiente)
                    $sql_fo = "INSERT INTO formulario_oferta (formulario_id, oferta_actividad_id, estado)
                            VALUES (?, ?, 1)";
                    $stmt_fo = $conexion->prepare($sql_fo);
                    $oferta_actividad_id = 1; // ID de una actividad por defecto o "sin asignar"
                    $stmt_fo->bind_param("ii", $id_formulario, $oferta_actividad_id);

                    if ($stmt_fo->execute()) {
                        $mensaje = "✅ Adolescente agregado correctamente (estado 1).";
                    } else {
                        $mensaje = "❌ Error al crear formulario_oferta: " . $stmt_fo->error;
                    }
                } else {
                    $mensaje = "❌ Error al crear formulario: " . $stmt_form->error;
                }
            } else {
                $mensaje = "❌ Error al crear adolescente: " . $stmt_ad->error;
            }
        } else {
            $mensaje = "❌ Error al crear datos personales: " . $stmt_dp->error;
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
    <title>Alta de Adolescente</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Alta de nuevo adolescente</h1>

        <?php if ($mensaje): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form action="alta.php" method="POST" class="form-crud">
            <fieldset>
                <legend>Datos personales</legend>

                <label>Nombre:</label>
                <input type="text" name="nombre" required>

                <label>Apellido:</label>
                <input type="text" name="apellido" required>

                <label>DNI:</label>
                <input type="text" name="numero_doc" required>

                <label>Género:</label>
                <select name="genero" required>
                    <option value="">Seleccione...</option>
                    <option value="varon">Varón</option>
                    <option value="mujer">Mujer</option>
                    <option value="no_contesta">No contesta</option>
                </select>

                <label>Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" required>
            </fieldset>

            <input type="submit" value="Guardar adolescente">
            <a href="/Administrador_IFTS/crud_adolescentes/listar.php" class="boton-volver">Volver al listado</a>
        </form>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

</body>

</html>