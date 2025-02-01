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
if ($datos && $datos['datosfinale']['datos']) {
    foreach ($datos['datosfinale']['datos'] as $fila) {
        echo "Cantidad: " . $fila["cantidad"] . "<br>";
        echo "Descripción: " . $fila["descripcion"] . "<br>";
        echo "Marca: " . $fila["marca"] . "<br>";
        echo "Modelo: " . $fila["modelo"] . "<br>";
        echo "Serie: " . $fila["serie"] . "<br>";
        echo "Físico: " . $fila["fisico"] . "<br>";
        echo "---------------------------<br>";
    }
    //para tener el ultimo resguardo y hacer consecutivo
    echo json_encode(["status" => "success", "message" => "Datos guardados correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se recibieron datos"]);
}
?>