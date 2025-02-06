<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Leer el contenido del request
$datosJSON = file_get_contents("php://input");

// Mostrar el JSON recibido para depuración
/*file_put_contents("debug.txt", $datosJSON . PHP_EOL, FILE_APPEND); // Guarda el JSON en un archivo para revisar
var_dump($datosJSON); // Para ver qué llega al servidor*/

//Decodificar el JSON
$datos = json_decode($datosJSON, true);
//print_r($datos['datosfinale']['datos']);

/** INICIA LA CONSTRUCCION DEL EXCEL********************* */
$inputFileName = 'imagenes_guardadas/plantilla_resguardo.xlsx'; // Ruta al archivo existente
$spreadsheet = IOFactory::load($inputFileName);
// Seleccionar la hoja activa (o especificar una por índice o nombre)
$worksheet = $spreadsheet->getActiveSheet();

//********************PARA EL NUMERO DE RESGUARDO */
$query = "SELECT COUNT(url_resguardo) as resguardos from evidencia where fecha > date('2024-12-31')";
$result = mysqli_query($con, $query);
$maximo = mysqli_fetch_assoc($result);
$maximo['resguardos'] += 1;
$dispositivo = $datos['datosfinale']['dispositivo'];
//********************************obtener la fecha*************** */
$fecha = $datos['datosfinale']['fecha'];
$fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
$meses = [
    "01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL",
    "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO",
    "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE"
];

// Obtener el día, mes y año en el formato requerido
$dia = $fecha_obj->format('d');
$mes = $meses[$fecha_obj->format('m')];
$año = $fecha_obj->format('Y');

// Resultado final
$fecha_formateada = "$dia-$mes-$año";
//************************************************************ */
$celdaEquipo =  ($datos['datosfinale']['equipo']==1?'C19':'H19');
$numFolio = ($maximo['resguardos'] < 99 ? '0'.$maximo['resguardos'].'-00 '.$dispositivo:$maximo['resguardos'].'-00 '.$dispositivo);
$usuario = $datos['datosfinale']['nombre'];
$puesto = $datos['datosfinale']['puesto'];
//***************************************************/
 
// Modificar celdas específicas
$worksheet->setCellValue('C7', $numFolio); // numero de serie
$worksheet->setCellValue('L7', $fecha_formateada);
$worksheet->setCellValue($celdaEquipo, 'X');
$worksheet->setCellValue('B56', mb_convert_case($usuario, MB_CASE_TITLE, "UTF-8"));
$worksheet->setCellValue('B58', mb_convert_case($puesto, MB_CASE_TITLE, "UTF-8"));

$celdainit = 22;
if ($datos && $datos['datosfinale']['datos']) {
    foreach ($datos['datosfinale']['datos'] as $fila) {
        $celdaCant = 'B';
        $celdaDes = 'C';
        $celdaMarca = 'G';
        $celdaModelo = 'K';
        $celdaNumSerie = 'L';
        $celdaNa = 'M';
        echo "Cantidad: " . $fila["cantidad"] . "<br>";
        echo "Descripción: " . $fila["descripcion"] . "<br>";
        echo "Marca: " . $fila["marca"] . "<br>";
        echo "Modelo: " . $fila["modelo"] . "<br>";
        echo "Serie: " . $fila["serie"] . "<br>";
        echo "Físico: " . $fila["fisico"] . "<br>";
        echo "---------------------------<br>";
        $celdaCant = $celdaCant.$celdainit;
        $celdaDes = $celdaDes.$celdainit;
        $celdaMarca = $celdaMarca.$celdainit;
        $celdaModelo = $celdaModelo.$celdainit;
        $celdaNumSerie = $celdaNumSerie.$celdainit;
        $celdaNa = $celdaNa.$celdainit;

        $worksheet->setCellValue($celdaCant,$fila["cantidad"]);
        $worksheet->setCellValue($celdaDes,$fila["descripcion"]);
        $worksheet->setCellValue($celdaMarca,$fila["marca"]);
        $worksheet->setCellValue($celdaModelo,$fila["modelo"]);
        $worksheet->setCellValue($celdaNumSerie,$fila["serie"]);
        $worksheet->setCellValue($celdaNa,'N/A');
        $celdainit++;
        echo "celda:".$celdaCant;
    }
    //para tener el ultimo resguardo y hacer consecutivo
    $outputFileName = 'imagenes_guardadas/archivo_modificado_RESGUARDO.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFileName);
    //************************INSERAR DATOS***************** */
    $query_select = "SELECT count(url_resguardo) as resguardos from evidencia where nombre = '$usuario'";
    $result_select = mysqli_query($con, $query_select);
    $maximo_select = mysqli_fetch_assoc($result_select);
    $maximo_select['resguardos']+=1;
    $ur_resguardo = "RESGUARDO_" . $maximo_select["resguardos"] . ".pdf";

    $query_insert = "INSERT INTO VALUES(DEFAULT, '$usuario','$fecha')";
    ///***************convertir a pdf */
    $rutaExcel = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/archivo_modificado_RESGUARDO.xlsx";
    $rutaPdf = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/{$ur_resguardo}";
    // Construir el comando
    $salida = shell_exec("py excelTOpdf.py " . escapeshellarg($rutaExcel) . " " . escapeshellarg($rutaPdf));

    echo json_encode(["status" => "success", "message" => "Datos guardados correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se recibieron datos"]);
}
?>