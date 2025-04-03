<?php
// Incluir el autoload de Composer para cargar TCPDF
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir TCPDF directamente (no se necesita el use)
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

require_once __DIR__ . '/../CONTROLADOR/AsignacionControlador.php';

$controlador = new AsignacionControlador();
$fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

$reporte = $controlador->obtenerReporteAsignacionVehiculo($fechaInicio, $fechaFin);

// Crear un objeto TCPDF
$pdf = new TCPDF();

// Establecer título del documento
$pdf->SetTitle('Reporte de Asignación de Vehículos');

// Agregar una página
$pdf->AddPage();

// Establecer el color de fondo blanco
$pdf->SetFillColor(255, 255, 255); // Blanco
$pdf->Rect(0, 0, 210, 297, 'F'); // Dibuja un rectángulo blanco (toda la página)

// Establecer el color del texto a negro
$pdf->SetTextColor(0, 0, 0); // Negro

// Establecer el encabezado (título del reporte)
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Asignación de Vehículos', 0, 1, 'C');

// Agregar un salto de línea
$pdf->Ln(10);

// Establecer la fuente para el contenido de la tabla
$pdf->SetFont('helvetica', '', 12);

// Establecer las cabeceras de la tabla con color de fondo blanco y texto negro
$pdf->SetFillColor(200, 200, 200); // Gris claro
$pdf->Cell(10, 10, '#', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Vehículo', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Conductor', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Fecha Inicio', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Fecha Fin', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Estado', 1, 1, 'C', 1);

// Establecer color de texto negro para el contenido
$pdf->SetTextColor(0, 0, 0); // Negro

// Agregar los datos de cada fila en la tabla
$pdf->SetFont('helvetica', '', 10);
foreach ($reporte as $index => $fila) {
    $pdf->Cell(10, 10, $index + 1, 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['vehiculo'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['conductor'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['fecha_inicio'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['fecha_fin'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['estado'], 1, 1, 'C');
}

// Generar el archivo PDF
$nombreArchivo = 'reporte_asignacion_vehiculos.pdf';

// Evitar cualquier salida previa
ob_end_clean();

// Enviar el archivo PDF al navegador
$pdf->Output($nombreArchivo, 'I');  // 'I' para mostrar en el navegador, 'D' para descargar
exit;
?>
