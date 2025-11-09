<?php
/**
 * Generador de estructura de proyecto en formato Markdown.
 * Guarda el resultado en 'estructura_proyecto.md'.
 * 
 * Autor: Bernardo Eliezer
 * Fecha: 2025
 */

function listar_directorio($ruta, $prefijo = "", $nivel = 0) {
    $excluir = ['.', '..', '.git', '.vscode', 'node_modules', 'vendor', 'test', 'estructura_proyecto.md', 'generar_estructura.php'];
    
    $carpetas = [];
    $archivos = [];

    foreach (scandir($ruta) as $item) {
        if (in_array($item, $excluir)) continue;
        $ruta_completa = $ruta . DIRECTORY_SEPARATOR . $item;
        if (is_dir($ruta_completa)) {
            $carpetas[] = $item;
        } else {
            $archivos[] = $item;
        }
    }

    $salida = "";

    // Primero carpetas
    foreach ($carpetas as $carpeta) {
        $salida .= str_repeat("│   ", $nivel) . "├── " . $carpeta . "/" . PHP_EOL;
        $salida .= listar_directorio($ruta . DIRECTORY_SEPARATOR . $carpeta, $prefijo, $nivel + 1);
    }

    // Luego archivos
    foreach ($archivos as $archivo) {
        $salida .= str_repeat("│   ", $nivel) . "│   └── " . $archivo . PHP_EOL;
    }

    return $salida;
}

// === RUTA BASE ===
$ruta_base = __DIR__;
$nombre_salida = $ruta_base . DIRECTORY_SEPARATOR . "estructura_proyecto.md";

// === Generar contenido ===
$estructura  = "## Estructura del proyecto\n\n";
$estructura .= "```\n";
$estructura .= basename($ruta_base) . "/" . PHP_EOL . "│" . PHP_EOL;
$estructura .= listar_directorio($ruta_base);
$estructura .= "```\n";

// === Guardar ===
file_put_contents($nombre_salida, $estructura);

// === Mostrar resumen ===
header('Content-Type: text/plain; charset=utf-8');
echo "✅ Archivo generado correctamente: estructura_proyecto.md\n";
echo "Ubicación: " . realpath($nombre_salida) . "\n";
?>
