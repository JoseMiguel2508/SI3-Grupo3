<?php
ob_start(); // Evita salidas previas

require_once __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que TCPDF esté correctamente instalado
require_once __DIR__ . '/../CONTROLADOR/AsignacionRutaController.php';

$fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

$controlador = new AsignacionRutaControlador();
$reporte = $controlador->obtenerAsignacionesActivas($fechaInicio, $fechaFin);

// Crear PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Reporte de Asignación de Rutas');
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

// Título
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Asignación de Rutas', 0, 1, 'C');

// Filtros de fecha
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0, 10, "Fecha Inicio: $fechaInicio", 0, 1);
$pdf->Cell(0, 10, "Fecha Fin: $fechaFin", 0, 1);

// Tabla
$pdf->Ln(10);
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(10, 10, '#', 1, 0, 'C');
$pdf->Cell(40, 10, 'Ruta', 1, 0, 'C');
$pdf->Cell(40, 10, 'Vehículo', 1, 0, 'C');
$pdf->Cell(40, 10, 'Conductor', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha Inicio', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha Fin', 1, 0, 'C');
$pdf->Cell(30, 10, 'Estado', 1, 1, 'C');

// Datos
foreach ($reporte as $index => $fila) {
    $pdf->Cell(10, 10, $index + 1, 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['nombre_ruta'], 1, 0, 'L');
    $pdf->Cell(40, 10, $fila['modelo'], 1, 0, 'L');
    $pdf->Cell(40, 10, $fila['nombre_completo'], 1, 0, 'L');
    $pdf->Cell(40, 10, $fila['hora_inicio'], 1, 0, 'L');
    $pdf->Cell(40, 10, $fila['hora_fin'], 1, 0, 'L');
    $pdf->Cell(30, 10, $fila['estado'], 1, 1, 'L');
}

// Limpiar salida previa y enviar PDF
ob_end_clean();
$pdf->Output('reporte_asignacion_rutas.pdf', 'I');
?>
