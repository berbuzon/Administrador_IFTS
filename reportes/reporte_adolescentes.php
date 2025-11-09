<?php
include("../conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: /Administrador_IFTS/index.php");
    exit();
}

// ============================
// 🔹 1. ADOLESCENTES POR ACTIVIDAD
// ============================
$sql_actividad = "
SELECT 
    ac.valor AS actividad,
    COUNT(a.id) AS cantidad
FROM adolescentes a
INNER JOIN formularios f ON f.id_adolescente = a.id
INNER JOIN formulario_oferta fo ON fo.formulario_id = f.id
INNER JOIN ofertas_actividades oa ON oa.id = fo.oferta_actividad_id
INNER JOIN actividades ac ON ac.id = oa.actividad_id
WHERE fo.estado IN (1, 2)
GROUP BY ac.valor
ORDER BY cantidad DESC
LIMIT 10
";

$res_actividad = $conexion->query($sql_actividad);
if (!$res_actividad) {
    die("❌ Error en consulta de actividades: " . $conexion->error);
}

$actividades = [];
$cantidades_actividad = [];
while ($fila = $res_actividad->fetch_assoc()) {
    $actividades[] = $fila['actividad'];
    $cantidades_actividad[] = (int)$fila['cantidad'];
}

// ============================
// 🔹 2. ADOLESCENTES POR INSTITUCIÓN
// ============================
$sql_institucion = "
SELECT 
    i.valor AS institucion,
    COUNT(a.id) AS cantidad
FROM adolescentes a
INNER JOIN formularios f ON f.id_adolescente = a.id
INNER JOIN formulario_oferta fo ON fo.formulario_id = f.id
INNER JOIN ofertas_actividades oa ON oa.id = fo.oferta_actividad_id
INNER JOIN instituciones i ON i.id = oa.institucion_id
WHERE fo.estado IN (1, 2)
GROUP BY i.valor
ORDER BY cantidad DESC
LIMIT 10
";

$res_institucion = $conexion->query($sql_institucion);
if (!$res_institucion) {
    die("❌ Error en consulta de instituciones: " . $conexion->error);
}

$instituciones = [];
$cantidades_institucion = [];
while ($fila = $res_institucion->fetch_assoc()) {
    $instituciones[] = $fila['institucion'];
    $cantidades_institucion[] = (int)$fila['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gráficos - Programa Adolescencia</title>
    <link rel="stylesheet" href="/Administrador_IFTS/assets/css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/header.php"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/sidebar.php"); ?>

    <main class="contenido">
        <h1>Reportes del Programa Adolescencia</h1>

        <!-- 🔹 Botones de exportación -->
        <!-- <div class="botones-exportar" style="text-align:right; margin-bottom:15px;">
            <button onclick="exportar('excel')" class="boton">📊 Exportar a Excel</button>
            <button onclick="exportar('pdf')" class="boton">🧾 Exportar a PDF</button>
        </div> -->


        <!-- 🔹 Contenedor general de gráficos -->
        <div class="contenedor-graficos">

            <div class="grafico-box">
                <h2>Adolescentes por Actividad</h2>
                <canvas id="chartActividades"></canvas>
            </div>

            <div class="grafico-box">
                <h2>Adolescentes por Institución</h2>
                <canvas id="chartInstituciones"></canvas>
            </div>

            <div class="grafico-box">
                <h2>Distribución porcentual de adolescentes por Institución</h2>
                <canvas id="chartInstitucionesDona"></canvas>
            </div>
        </div>

    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/Administrador_IFTS/includes/footer.php"); ?>

    <script>
        /* === Gráfico 1: Actividades === */
        const ctxAct = document.getElementById('chartActividades');
        new Chart(ctxAct, {
            type: 'bar',
            data: {
                labels: <?= json_encode($actividades) ?>,
                datasets: [{
                    label: 'Cantidad de adolescentes',
                    data: <?= json_encode($cantidades_actividad) ?>,
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Top 10 actividades con más adolescentes'
                    }
                },
                layout: {
                    padding: 20
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 30,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        /* === Gráfico 2: Instituciones === */
        const ctxInst = document.getElementById('chartInstituciones');
        new Chart(ctxInst, {
            type: 'bar',
            data: {
                labels: <?= json_encode($instituciones) ?>,
                datasets: [{
                    label: 'Cantidad de adolescentes',
                    data: <?= json_encode($cantidades_institucion) ?>,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Top 10 instituciones con más adolescentes'
                    }
                },
                layout: {
                    padding: 20
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 30,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        /* === Gráfico 3: Instituciones (dona porcentual) === */
        const ctxDona = document.getElementById('chartInstitucionesDona');
        new Chart(ctxDona, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($instituciones) ?>,
                datasets: [{
                    data: <?= json_encode($cantidades_institucion) ?>,
                    backgroundColor: [
                        '#1d4ed8', '#2563eb', '#3b82f6', '#60a5fa', '#93c5fd',
                        '#16a34a', '#22c55e', '#4ade80', '#86efac', '#bbf7d0'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 15
                        }
                    },
                    title: {
                        display: true,
                        text: 'Porcentaje de adolescentes por institución'
                    }
                }
            }
        });
    </script>
    <script>
        function exportar(tipo) {
            // Convertir los gráficos a imágenes Base64
            const img1 = document.getElementById("chartActividades").toDataURL("image/png");
            const img2 = document.getElementById("chartInstituciones").toDataURL("image/png");
            const img3 = document.getElementById("chartInstitucionesDona").toDataURL("image/png");

            // Crear un formulario temporal para enviar las imágenes
            const form = document.createElement("form");
            form.method = "POST";
            form.action = tipo === "excel" ?
                "/Administrador_IFTS/reportes/exportar_excel_graficos.php" :
                "/Administrador_IFTS/reportes/exportar_pdf_graficos.php";

            // Agregar las imágenes como campos ocultos
            [img1, img2, img3].forEach((img, i) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "grafico" + (i + 1);
                input.value = img;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>

</body>

</html>