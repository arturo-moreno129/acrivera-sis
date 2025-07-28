<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
$today = date('Y-m-d'); // Resultado: 2025-04-28


//************************ESTO ES SUSTITUIDO EN EL MODULO JAVASCCRIPT scriptPopUP.js********** */
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header("Content-Disposition: attachment;filename=\"directorio{$today}.xlsx\"");
//header('Cache-Control: max-age=0');

// ejecutar codigo
exportarDirectorio($con);
function exportarDirectorio($con)
{

    // Base de datos
    $query = "SELECT * FROM directorio WHERE ESTATUS = 1 ORDER BY FIELD(area, 'DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN','SA','SAT','ST')";
    $result = mysqli_query($con, $query);

    $arrayAreas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN','SA','SAT','ST'];
    $arrayNombres = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos','Sucursal Apizaco','Sucursal Alliance Tehuacán - 238 383 8745','Sucursal Teziutlán'];

    $area_actual = null;
    $spreadsheet = IOFactory::load('imagenes_guardadas/plantilla_directorio.xlsx');
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle('Personal ACR');

    $conta_title = 6;
    $conta_usu = 6;

    while ($row = mysqli_fetch_array($result)) {
        if ($row['area'] != $area_actual) {
            $area_actual = $row['area'];
            $index = array_search($area_actual, $arrayAreas);
            if ($index !== false) {
                $worksheet->mergeCells('B' . $conta_title . ':E' . $conta_title);
                $worksheet->setCellValue('B' . $conta_title, $arrayNombres[$index]);
                $worksheet->getStyle('B' . $conta_title . ':E' . $conta_title)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BDD7EE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $conta_title++;
                $conta_usu = $conta_title;
            }
        }

        $worksheet->setCellValue('B' . $conta_usu, $row['nom_usu']);
        $worksheet->setCellValue('C' . $conta_usu, $row['puesto']);
        $worksheet->setCellValue('D' . $conta_usu, $row['correo']);
        $worksheet->setCellValue('E' . $conta_usu, $row['extencion']);

        $conta_title++;
        $conta_usu++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
