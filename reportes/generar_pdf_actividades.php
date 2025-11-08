<?php
ob_start();

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '300');

require_once(__DIR__ . '/../libs/tcpdf/tcpdf.php');
include('../conexion.php');
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}

$sql = "
SELECT
    a.id,
    a.valor,
    a.vigente
FROM adl_admin_inscripcion.actividades a
ORDER BY a.id
";
$resultado = $conexion->query($sql);

class MYPDF extends TCPDF {
    public $usuario;

    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Listado de actividades', 0, 1, 'C');
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 8, 'Generado por: ' . $this->usuario . ' — Fecha: ' . date('d/m/Y'), 0, 1, 'C');
        $this->Ln(3);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->usuario = $_SESSION["usuario"];
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Administrador Adolescencia');
$pdf->SetTitle('Listado de actividades');
$pdf->SetMargins(10, 30, 10);
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10);

$registros_por_pagina = 300;
$contador = 0;
$html = '
<table border="1" cellpadding="4" cellspacing="0" style="table-layout:fixed; width:277mm;">
<thead>
<tr style="background-color:#f2f2f2; font-weight:bold;">
  <th width="20mm" align="center">#</th>
  <th width="197mm" align="left">Nombre de la actividad</th>
  <th width="60mm" align="center">Vigencia</th>
</tr>
</thead><tbody>';



while ($fila = $resultado->fetch_assoc()) {
    $contador++;
    $html .= '<tr>
        <td width="20mm" align="center">'.htmlspecialchars($fila["id"]).'</td>
        <td width="197mm" align="left">'.htmlspecialchars($fila["valor"]).'</td>
        <td width="60mm" align="center">'.htmlspecialchars($fila["vigente"]).'</td>
    </tr>';


    if ($contador % $registros_por_pagina == 0) {
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->AddPage();
        $html = '
        <table border="1" cellpadding="4">
        <thead>
        <tr style="background-color:#f2f2f2; font-weight:bold;">
        <th width="20mm" align="center">#</th>
        <th width="197mm" align="left">Nombre de la actividad</th>
        <th width="60mm" align="center">Vigencia</th>
        </tr>
        </thead><tbody>';

    }
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean();
$pdf->Output('Listado_Actividades.pdf', 'I');
exit;
?>
