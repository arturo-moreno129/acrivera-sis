<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//*************VALORES PARA EXCEL**************************/
$datos = [
    'usuario' => (empty($_POST['select-user']) ? sprintf("%s %s %s", trim($_POST["firstname"]), trim($_POST["lastname"]), trim($_POST["surname"])) : $_POST['select-user']),//$_POST['select-user'],
    'dispositivo' => $_POST['dispositivo'],
    'fecha' => $_POST['fecha-registro'],
    'tipoMan' => ($_POST['option'] == "Solicitado" ? 'J9' : 'D9'),
    'puesto' => $_POST['puesto'],
    'numSerie' => $_POST['Nserie'],
    'disco' => $_POST['disco'] . 'GB',
    'memoria' => $_POST['memoria'] . 'GB',

    'pantalla' => (empty($_POST['pantalla']) ? ' ' : '✓'),
    'exteriorTM' => (empty($_POST['ETR']) ? ' ' : '✓'),
    'intExtgabi' => (empty($_POST['IEG']) ? ' ' : '✓'),
    'cableado' => (empty($_POST['AC']) ? ' ' : '✓'),
    'bloqueoUSB' => (empty($_POST['BU']) ? ' ' : '✓'),
    'cookies' => (empty($_POST['EC']) ? ' ' : '✓'),
    'temporales' => (empty($_POST['ET']) ? ' ' : '✓'),

    'desk' => (empty($_POST['DESK']) ? ' ' : '✓'),
    'file' => (empty($_POST['FILE']) ? ' ' : '✓'),
    'fav' => (empty($_POST['FAV']) ? ' ' : '✓'),
    'mail' => (empty($_POST['MAIL']) ? ' ' : '✓'),
    'unidad' => (empty($_POST['UNIDAD']) ? ' ' : '✓'),

    'sistema' => (empty($_POST['SO']) ? ' ' : '✓'),
    'office' => (empty($_POST['OFFICE']) ? ' ' : '✓'),
    'anntiVirus' => (empty($_POST['AV']) ? ' ' : '✓'),
    'intelisis' => (empty($_POST['INTELISIS']) ? ' ' : '✓'),
    'utilerias' => (empty($_POST['UTIL']) ? ' ' : '✓'),
    'explorador' => (empty($_POST['EXPLO']) ? ' ' : '✓'),

];

//print_r($datos);
//para optener el ultimo valor

//********************************************************/
try {
    //********************************OBTENER EL ULTIMO VALOR***************************** */
    $query = "SELECT count(url_resguardo) as resguardos from evidencia where nombre = '{$datos['usuario']}'";
    $result = mysqli_query($con, $query);
    $maximo = mysqli_fetch_assoc($result);
    $maximo['resguardos']+=1;
    $ur_resguardo = "RESGUARDO_" . $maximo["resguardos"] . ".pdf";
    //*********************************************** */
    $query_1 = "INSERT INTO evidencia VALUES(DEFAULT,'{$datos['usuario']}','{$datos['fecha']}','{$datos['dispositivo']}','$ur_resguardo',null,'{$_SESSION['id_usuario']}',0,0)";
    $result_1 = mysqli_query($con, $query_1);

    //*********************************************************** */
    $fecha_convertida = date("d/m/Y", strtotime($datos['fecha']));
    $numeroReporte = "PM" . str_replace("/", "", $fecha_convertida);

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
    $worksheet->setCellValue("C17", $datos['puesto']);
    $worksheet->setCellValue("J17", $datos['numSerie']);
    $worksheet->setCellValue("D19", $datos['disco']);
    $worksheet->setCellValue("D21", $datos['memoria']);
    $worksheet->setCellValue("L7", $numeroReporte);

    $worksheet->setCellValue("E29", $datos['pantalla']);
    $worksheet->setCellValue("E31", $datos['exteriorTM']);
    $worksheet->setCellValue("E33", $datos['intExtgabi']);
    $worksheet->setCellValue("E35", $datos['cableado']);
    $worksheet->setCellValue("E37", $datos['bloqueoUSB']);
    $worksheet->setCellValue("L29", $datos['cookies']);
    $worksheet->setCellValue("L31", $datos['temporales']);

    $worksheet->setCellValue("F43", $datos['desk']);
    $worksheet->setCellValue("F45", $datos['file']);
    $worksheet->setCellValue("F47", $datos['fav']);
    $worksheet->setCellValue("F49", $datos['mail']);
    $worksheet->setCellValue("F51", $datos['unidad']);

    $worksheet->setCellValue("F57", $datos['sistema']);
    $worksheet->setCellValue("F59", $datos['office']);
    $worksheet->setCellValue("F61", $datos['anntiVirus']);
    $worksheet->setCellValue("F63", $datos['intelisis']);
    $worksheet->setCellValue("F65", $datos['utilerias']);
    $worksheet->setCellValue("F67", $datos['explorador']);

    // Guardar los cambios en un nuevo archivo
    $outputFileName = 'imagenes_guardadas/archivo_modificado.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFileName);

    //echo "El archivo se ha modificado y guardado como '$outputFileName'.";

    //********************************convertir archivo excel a pdf
    $rutaExcel = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/archivo_modificado.xlsx";
    $rutaPdf = "C:/xampp/htdocs/acrivera-sis/carpetas/{$datos['usuario']}/$ur_resguardo";
    // Construir el comando
    $salida = shell_exec("py excelTOpdf.py " . escapeshellarg($rutaExcel) . " " . escapeshellarg($rutaPdf));
    // Mostrar la salida del comando
    //echo "<pre>$salida</pre>";
    /************************************************************** */
    header('location:card_registro.php');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>