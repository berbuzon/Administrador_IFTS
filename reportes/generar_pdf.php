<?php
ob_start(); // Evita salida previa

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '300');

require_once(__DIR__ . '/../libs/tcpdf/tcpdf.php');
include('../conexion.php');
session_start();

// Verificación de sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}

// Consulta
$sql = "
SELECT 
    dp.apellido,
    dp.nombre,
    dp.numero_doc,
    dp.genero,
    dp.fecha_nacimiento,
    a.ingreso_programa
FROM adolescentes a
INNER JOIN datos_personales dp ON dp.id = a.id_datos_personales
INNER JOIN formularios f ON f.id_adolescente = a.id
INNER JOIN formulario_oferta fo ON fo.formulario_id = f.id
WHERE fo.estado = 2
ORDER BY dp.apellido, dp.nombre
limit 10
";
$resultado = $conexion->query($sql);

// Clase para encabezado y pie
class MYPDF extends TCPDF {
    public $usuario;

    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Listado de adolescentes activos', 0, 1, 'C');
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 8, 'Generado por: ' . $this->usuario . ' — Fecha: ' . date('d/m/Y'), 0, 1, 'C');
        $this->Ln(3);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->usuario = $_SESSION["usuario"];
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Administrador Adolescencia');
$pdf->SetTitle('Listado de adolescentes activos');
$pdf->SetMargins(10, 30, 10);
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10);

// Configuración de paginación
$registros_por_pagina = 300;
$contador = 0;
$html = '
<table border="1" cellpadding="4">
<thead>
<tr style="background-color:#f2f2f2; font-weight:bold;">
  <th>Apellido</th>
  <th>Nombre</th>
  <th>DNI</th>
  <th>Género</th>
  <th>Fecha Nac.</th>
  <th>Ingreso Programa</th>
</tr>
</thead><tbody>';

while ($fila = $resultado->fetch_assoc()) {
    $contador++;
    $html .= '<tr>
        <td>'.htmlspecialchars($fila["apellido"]).'</td>
        <td>'.htmlspecialchars($fila["nombre"]).'</td>
        <td>'.htmlspecialchars($fila["numero_doc"]).'</td>
        <td>'.htmlspecialchars($fila["genero"]).'</td>
        <td>'.htmlspecialchars($fila["fecha_nacimiento"]).'</td>
        <td>'.htmlspecialchars($fila["ingreso_programa"]).'</td>
    </tr>';

    // Cada 300 registros imprime y agrega nueva página
    if ($contador % $registros_por_pagina == 0) {
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->AddPage();
        $html = '
        <table border="1" cellpadding="4">
        <thead>
        <tr style="background-color:#f2f2f2; font-weight:bold;">
          <th>Apellido</th>
          <th>Nombre</th>
          <th>DNI</th>
          <th>Género</th>
          <th>Fecha Nac.</th>
          <th>Ingreso Programa</th>
        </tr>
        </thead><tbody>';
    }
}
$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Salida final
ob_end_clean();
$pdf->Output('Listado_Adolescentes_Activos.pdf', 'I');
exit;
?>
