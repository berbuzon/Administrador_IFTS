<?php
include("conexion.php");
session_start();

$mensaje = "";

// Cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $rol = $_POST["rol"];

    // Generar hash seguro de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en la tabla usuarios
    $sql = "INSERT INTO usuarios (usuario, password_hash, rol) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $usuario, $password_hash, $rol);

    if ($stmt->execute()) {
        $mensaje = "Usuario creado correctamente.";
    } else {
        $mensaje = "Error al crear el usuario: " . $conexion->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar nuevo usuario</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Registrar nuevo usuario</h1>

        <form action="" method="POST">
            <label for="usuario">Nombre de usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="admin">Administrador</option>
                <option value="usuario">Usuario</option>
            </select>

            <input type="submit" value="Crear usuario">

            <?php if ($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>
        </form>

        <p style="text-align:center; margin-top:10px;">
            <a href="index.php">Volver al login</a>
        </p>
    </div>
</body>
</html>
