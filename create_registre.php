<?php

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//*************VALORES PARA EXCEL**************************/
$datos = [
    'usuario' => ($_POST['select-user'] == 0 ?sprintf("%s %s %s", trim($_POST["firstname"]), trim($_POST["lastname"]), trim($_POST["surname"])):$_POST['select-user']),//$_POST['select-user'],
    'dispositivo' => $_POST['dispositivo'],
    'fecha' => $_POST['fecha-registro'],
    'tipoMan' => ($_POST['option'] == "Solicitado" ? 'J9':'D9'),
];

//print_r($datos);

//********************************************************/
try {
    $fecha_convertida = date("d/m/Y", strtotime($datos['fecha']));

    // Cargar el archivo existente
    $inputFileName = 'imagenes_guardadas/plantilla.xlsx'; // Ruta al archivo existente
    $spreadsheet = IOFactory::load($inputFileName);

    // Seleccionar la hoja activa (o especificar una por índice o nombre)
    $worksheet = $spreadsheet->getActiveSheet();

    // Modificar celdas específicas
    $worksheet->setCellValue('F7', $fecha_convertida); // fecha
    $worksheet->setCellValue($datos['tipoMan'], '✓');// '✓' //TIPO DE MANTENIMIENTI
    $worksheet->setCellValue('F15', mb_convert_case($datos['usuario'], MB_CASE_TITLE, "UTF-8")); //NOMBRE PARTE SUPERIOR
    $worksheet->setCellValue('B76', mb_convert_case($datos['usuario'], MB_CASE_TITLE, "UTF-8"));//NOMBRE PARTE INFERIOR

    // Guardar los cambios en un nuevo archivo
    $outputFileName = 'imagenes_guardadas/archivo_modificado.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFileName);

    //echo "El archivo se ha modificado y guardado como '$outputFileName'.";
    header('location:firma.php');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
