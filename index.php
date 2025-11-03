<?php
include("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Buscamos el usuario en la tabla "usuarios"
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        // Verificamos la contraseña
        if (password_verify($password, $fila["password_hash"])) {
            $_SESSION["usuario"] = $fila["usuario"];
            header("Location: inicio.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="login-container">
    <h1>Administrador Adolescencia</h1>
    <form action="" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Ingresar">
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>

    <p style="text-align:center; margin-top:10px;">
        <a href="crear_usuario.php">Crear nuevo usuario</a>
    </p>
</div>
</body>
</html>
