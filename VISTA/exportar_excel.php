<?php
// Incluir el autoload de Composer para cargar las clases de PhpSpreadsheet
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once __DIR__ . '/../CONTROLADOR/AsignacionControlador.php';

$controlador = new AsignacionControlador();
$fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

$reporte = $controlador->obtenerReporteAsignacionVehiculo($fechaInicio, $fechaFin);

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar los encabezados
$sheet->setCellValue('A1', 'No.')
      ->setCellValue('B1', 'Vehículo')
      ->setCellValue('C1', 'Conductor')
      ->setCellValue('D1', 'Fecha Inicio')
      ->setCellValue('E1', 'Fecha Fin')
      ->setCellValue('F1', 'Estado');

// Estilo para los encabezados
$styleArray = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFF'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['argb' => '4CAF50'],
    ],
];

// Aplicar el estilo a los encabezados
$sheet->getStyle('A1:F1')->applyFromArray($styleArray);

// Agregar los datos
$row = 2;
foreach ($reporte as $index => $fila) {
    $sheet->setCellValue('A' . $row, $index + 1)
          ->setCellValue('B' . $row, $fila['vehiculo'])
          ->setCellValue('C' . $row, $fila['conductor'])
          ->setCellValue('D' . $row, $fila['fecha_inicio'])
          ->setCellValue('E' . $row, $fila['fecha_fin'])
          ->setCellValue('F' . $row, $fila['estado']);
    $row++;
}

// Definir el nombre del archivo
$nombreArchivo = 'reporte_asignacion_vehiculos.xlsx';

// Escribir el archivo Excel
$writer = new Xlsx($spreadsheet);

// Forzar la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
header('Cache-Control: max-age=0');

// Guardar el archivo al navegador
$writer->save('php://output');
exit;
?>
