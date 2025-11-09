<?php
// anonimizar_datos_personales.php
// Uso: php anonimizar_datos_personales.php [--dry-run] [--limit=N]

$dryRun = in_array('--dry-run', $argv);
$limit = null;
foreach ($argv as $a) {
    if (strpos($a, '--limit=') === 0) $limit = intval(substr($a, 8));
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'adl_admin_inscripcion';
$port = 3307;

$mysqli = new mysqli($host, $user, $pass, $db, $port);
if ($mysqli->connect_errno) {
    echo "Error conexión MySQL: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}
$mysqli->set_charset('utf8mb4');

// Listas de nombres y apellidos (podés ampliar)
$nombres = [
    'Juan','Luis','Carlos','Matías','Santiago','Mateo','Diego','Lucas','Joaquín','Tomás',
    'María','Laura','Lucía','Sofía','Valentina','Camila','Martina','Carla','Ana','Florencia'
];

$apellidos = [
    'Pérez','González','Rodríguez','Gómez','López','Martínez','Sosa','Ramírez','Torres','Fernández',
    'Silva','Rossi','Alvarez','Morales','Méndez','Suárez','Vega','Costa','Herrera','Ruiz'
];

// Función para generar DNI pseudo-aleatorio de 8 dígitos
function generarDNI($mysqli) {
    $tries = 0;
    do {
        $dni = strval(rand(10000000, 99999999));
        // verificar unicidad
        $stmt = $mysqli->prepare("SELECT 1 FROM datos_personales WHERE numero_doc = ? LIMIT 1");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        $tries++;
        if ($tries > 50) {
            // fallback: generar con prefijo único por microtime
            $dni = substr(strval((int)(microtime(true)*10000)), -8);
            break;
        }
    } while ($exists);
    return $dni;
}

// Selección de ids a anonimizar
$sql_select = "SELECT id FROM datos_personales";
if ($limit && is_int($limit)) {
    $sql_select .= " LIMIT " . intval($limit);
}
$res = $mysqli->query($sql_select);
if (!$res) {
    echo "Error al leer ids: " . $mysqli->error . PHP_EOL;
    exit(1);
}

$ids = [];
while ($row = $res->fetch_assoc()) $ids[] = $row['id'];
$res->free();

echo "Se procesarán " . count($ids) . " registros." . PHP_EOL;
if ($dryRun) echo "(modo dry-run: no se aplicarán cambios)" . PHP_EOL;

// Preparar statement de actualización
$updateStmt = $mysqli->prepare("UPDATE datos_personales SET nombre = ?, apellido = ?, numero_doc = ? WHERE id = ?");
if (!$updateStmt) {
    echo "Error preparar UPDATE: " . $mysqli->error . PHP_EOL;
    exit(1);
}

// Empezar transacción (para poder revertir si no te gusta)
$mysqli->begin_transaction();

try {
    foreach ($ids as $id) {
        // Generar nombre y apellido aleatorios
        $nombre = $nombres[array_rand($nombres)];
        // mezclar para más diversidad: a veces segundo nombre
        if (rand(0, 10) > 7) {
            $nombre .= ' ' . $nombres[array_rand($nombres)];
        }
        $apellido = $apellidos[array_rand($apellidos)];
        // a veces apellido compuesto
        if (rand(0, 10) > 8) {
            $apellido .= ' ' . $apellidos[array_rand($apellidos)];
        }

        // DNI único
        $dni = generarDNI($mysqli);

        if ($dryRun) {
            echo "ID {$id} -> {$nombre} {$apellido} / DNI: {$dni}" . PHP_EOL;
        } else {
            $updateStmt->bind_param("sssi", $nombre, $apellido, $dni, $id);
            if (!$updateStmt->execute()) {
                throw new Exception("Error update id {$id}: " . $updateStmt->error);
            }
        }
    }

    if ($dryRun) {
        $mysqli->rollback();
        echo "Dry-run completado. No se realizaron cambios." . PHP_EOL;
    } else {
        $mysqli->commit();
        echo "Anonimización completada correctamente." . PHP_EOL;
    }

} catch (Exception $e) {
    $mysqli->rollback();
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$updateStmt->close();
$mysqli->close();
