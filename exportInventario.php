<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$today = date('Y-m-d');

// Obtener el filtro del POST
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'todos';

exportarInventario($con, $filtro);

function exportarInventario($con, $filtro)
{
    // Crear Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Inventario');

    // Encabezados
    $sheet->setCellValue('A1', 'ID Inventario');
    $sheet->setCellValue('B1', 'Usuario Asignado');
    $sheet->setCellValue('C1', 'Tipo Equipo');
    $sheet->setCellValue('D1', 'Modelo');
    $sheet->setCellValue('E1', 'Marca');
    $sheet->setCellValue('F1', 'No. Serie');
    $sheet->setCellValue('G1', 'Nombre Host');
    $sheet->setCellValue('H1', 'Departamento');
    $sheet->setCellValue('I1', 'Estatus');

    // Estilo de encabezados
    $sheet->getStyle('A1:I1')->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000']
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'BDD7EE'
            ]
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ]
    ]);

    // Construir la consulta según el filtro
    $where = '';
    if ($filtro === 'activos') {
        $where = 'WHERE estatus = 1';
    } elseif ($filtro === 'inactivos') {
        $where = 'WHERE estatus = 0';
    }
    
    // Consulta
    $query = "
        SELECT
            id_inventario,
            usuario_asignado,
            tipo_equipo,
            modelo,
            marca,
            no_serie,
            nom_host,
            departamento,
            estatus
        FROM inventario
        $where
        ORDER BY id_inventario ASC
    ";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($con));
    }

    $fila = 2;

    while ($row = mysqli_fetch_assoc($result)) {

        $sheet->setCellValue('A' . $fila, $row['id_inventario']);
        $sheet->setCellValue('B' . $fila, $row['usuario_asignado']);
        $sheet->setCellValue('C' . $fila, $row['tipo_equipo']);
        $sheet->setCellValue('D' . $fila, $row['modelo']);
        $sheet->setCellValue('E' . $fila, $row['marca']);
        $sheet->setCellValue('F' . $fila, $row['no_serie']);
        $sheet->setCellValue('G' . $fila, $row['nom_host']);
        $sheet->setCellValue('H' . $fila, $row['departamento']);
        $sheet->setCellValue('I' . $fila, $row['estatus']);

        $fila++;
    }
    // Formato numérico para la columna F (No. Serie)
    $sheet->getStyle('F:F')
        ->getNumberFormat()
        ->setFormatCode('0');

    // Autoajustar columnas
    foreach (range('A', 'I') as $columna) {
        $sheet->getColumnDimension($columna)->setAutoSize(true);
    }

    // Congelar encabezado
    $sheet->freezePane('A2');

    // Filtro automático
    $sheet->setAutoFilter('A1:I1');

    // Descargar archivo
    $today = date('Y-m-d');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"Inventario_{$today}.xlsx\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
