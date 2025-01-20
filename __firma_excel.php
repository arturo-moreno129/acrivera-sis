<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Cargar el archivo Excel existente
$inputFileName = "imagenes/prueba_firma.xlsx";
$spreadsheet = IOFactory::load($inputFileName);

// Seleccionar la hoja donde se agregará la firma
$sheet = $spreadsheet->getActiveSheet();

// Crear un objeto de dibujo para insertar la imagen de la firma
$drawing = new Drawing();
$drawing->setName('Firma');
$drawing->setDescription('Firma digital');
$drawing->setPath('imagenes/chek.png'); // Ruta de la imagen
$drawing->setHeight(20); // Altura en píxeles
$drawing->setCoordinates('B74'); // Celda donde se colocará la firma (por ejemplo, B10)
$drawing->setWorksheet($sheet);
$drawing->setOffsetX(70); // Desplazamiento horizontal (en píxeles)
$drawing->setOffsetY(10); // Desplazamiento vertical (en píxeles)

// Guardar el archivo Excel con la firma
$outputFileName = "archivo_con_firma.xlsx";
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($outputFileName);

echo "Firma agregada y archivo guardado como $outputFileName.";

?>
