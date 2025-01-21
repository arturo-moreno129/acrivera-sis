<?php

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    $fecha = date('d/m/Y');



    // Cargar el archivo existente
    $inputFileName = 'archivo.xlsx'; // Ruta al archivo existente
    $spreadsheet = IOFactory::load($inputFileName);

    // Seleccionar la hoja activa (o especificar una por índice o nombre)
    $worksheet = $spreadsheet->getActiveSheet();

    // Modificar celdas específicas
    $worksheet->setCellValue('F7', $fecha); // Modificar celda A1
    $worksheet->setCellValue('E29', '✓');              // Modificar celda B2
    $worksheet->setCellValue('E31', '✓');     // Insertar fórmula en C3

    // Guardar los cambios en un nuevo archivo
    $outputFileName = 'archivo_modificado.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFileName);

    echo "El archivo se ha modificado y guardado como '$outputFileName'.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
