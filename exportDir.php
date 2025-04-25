<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="directorio_personal.xlsx"');
header('Cache-Control: max-age=0');

// ejecutar codigo
exportarDirectorio($con);
function exportarDirectorio($con)
{
    /*try {
        $query = "SELECT * FROM directorio ORDER BY FIELD(area, 'DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN')";
        $result = mysqli_query($con, $query);

        $arrayAreas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN'];
        $arrayNombres = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos'];

        $area_actual = null;


        // Cargar el archivo existente
        $inputFileName = 'imagenes_guardadas/plantilla_directorio.xlsx'; // Ruta al archivo existente
        $spreadsheet = IOFactory::load($inputFileName);

        // Seleccionar la hoja activa (o especificar una por índice o nombre)
        $worksheet = $spreadsheet->getActiveSheet();

        // Modificar celdas específicas
        //$worksheet->setCellValue('F7', $fecha_convertida); // fecha
        //$worksheet->setCellValue($datos['tipoMan'], '✓'); // '✓' //TIPO DE MANTENIMIENTI
        $conta_title = 6;
        $conta_usu = 6;
        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_array($result)) {
                if ($row['area'] != $area_actual) {
                    $area_actual = $row['area'];
                    $index = array_search($area_actual, $arrayAreas);

                    if ($index !== false) {
                        // Encabezado de área
                        $worksheet->mergeCells('B' . $conta_title . ':E' . $conta_title);
                        $worksheet->setCellValue('B' . $conta_title, $arrayNombres[$index]);
                        $worksheet->getStyle('B' . $conta_title . ':E' . $conta_title)->applyFromArray([
                            'font' => ['bold' => true],
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BDD7EE']],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                        $conta_title++;
                        $conta_usu = $conta_title; // Igualamos porque usuarios siguen debajo
                    }
                }

                // Datos de usuario
                $worksheet->setCellValue('B' . $conta_usu, $row['nom_usu']);
                $worksheet->setCellValue('C' . $conta_usu, $row['puesto']);
                $worksheet->setCellValue('D' . $conta_usu, $row['correo']);
                $worksheet->setCellValue('E' . $conta_usu, $row['extencion']);

                $conta_title++;
                $conta_usu++;
            }
            try {
                //code...
                $outputFileName = 'imagenes_guardadas/Directorio_actualizado.xlsx';
                //$writer = new Xlsx($spreadsheet);
                //$writer->save($outputFileName);
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                echo json_encode(["status" => "success", "message" => "Exportacion Correctamente"]);
                exit;
            } catch (\Throwable $th) {
                //throw $th;
                echo json_encode(["status" => "error", "message" => "No se especificó ninguna acción."]);
            }
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "No se especificó ninguna acción."]);
    }*/
    /*require 'vendor/autoload.php';
include "conexion.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Configura los headers antes de cualquier salida
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="directorio_personal.xlsx"');
header('Cache-Control: max-age=0');*/

    // Base de datos
    $query = "SELECT * FROM directorio ORDER BY FIELD(area, 'DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN')";
    $result = mysqli_query($con, $query);

    $arrayAreas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN'];
    $arrayNombres = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos'];

    $area_actual = null;
    $spreadsheet = IOFactory::load('imagenes_guardadas/plantilla_directorio.xlsx');
    $worksheet = $spreadsheet->getActiveSheet();

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
