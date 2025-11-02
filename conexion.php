<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "adl_admin_inscripcion";
$port = 3307;

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, $port);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>

