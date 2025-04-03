<?php
require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../CONTROLADOR/AsignacionRutaController.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener fechas
$fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

// Obtener datos del reporte
$controlador = new AsignacionRutaControlador();
$reporte = $controlador->obtenerAsignacionesActivas($fechaInicio, $fechaFin);

// Crear documento Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$headers = ["Nº", "Ruta", "Vehículo", "Conductor", "Fecha Inicio", "Fecha Fin", "Estado"];
$sheet->fromArray([$headers], null, 'A1');

// Agregar datos al Excel
$row = 2;
foreach ($reporte as $index => $fila) {
    $sheet->fromArray([
        $index + 1,
        $fila['nombre_ruta'],
        $fila['modelo'],
        $fila['nombre_completo'],
        $fila['hora_inicio'],
        $fila['hora_fin'],
        ucfirst($fila['estado'])
    ], null, "A$row");
    $row++;
}

// Formato de Encabezado
$headerStyle = [
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
$sheet->getDefaultColumnDimension()->setWidth(20);

// Descargar archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_asignacion_rutas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
