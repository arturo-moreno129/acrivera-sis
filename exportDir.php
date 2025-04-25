<?php
include "conexion.php";
session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Leer el contenido del request
$datosJSON = file_get_contents("php://input");
$datos = json_decode($datosJSON, true); //Decodificar el JSON

function exportarDirectorio($con)
{
    try {
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
                // Si el área cambia, imprimimos el encabezado de área
                if ($row['area'] != $area_actual) {
                    $area_actual = $row['area'];
                    $index = array_search($area_actual, $arrayAreas);
                    if ($index !== false) {
                        //crear el encabezado de cada area.
                        $worksheet->mergeCells('B' . $conta_title . ':E' . $conta_title . '')->setCellValue('A1', $arrayNombres[$index]);
                        $conta_title++;
                        $conta_usu++;
                    }
                }

                // registrar usuario en cada celda.
                $worksheet->setCellValue('B' . $conta_usu . '', $row["nom_usu"]);
                $conta_usu++;
            }
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "No se especificó ninguna acción."]);
    }
}
