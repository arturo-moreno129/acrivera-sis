<?php
$datos = json_decode(file_get_contents("php://input"), true);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($datos['imagen'])) {
    // Obtener la imagen en Base64 y decodificarla
    $base64 = $datos['imagen'];

    // Quitar el prefijo del tipo de contenido (por ejemplo, "data:image/png;base64,")
    $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);

    // Decodificar el Base64
    $imagenDecodificada = base64_decode($base64);

    // Definir la ruta donde se guardará la imagen
    $rutaDestino = 'imagenes_guardadas/firma.png';

    // Verificar que la carpeta de destino exista, o crearla
    $directorio = dirname($rutaDestino);
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Guardar la imagen en el servidor
    if (file_put_contents($rutaDestino, $imagenDecodificada)) {
        echo "Imagen guardada exitosamente en: $rutaDestino\n";
        incrustacion($rutaDestino);
    } else {
        echo "Error al guardar la imagen.";
    }
} else {
    echo "No se recibió ninguna imagen.";
}

function incrustacion($ruta_img)
{
    // Cargar el archivo Excel existente
    $inputFileName = "imagenes_guardadas/prueba_firma.xlsx";
    $spreadsheet = IOFactory::load($inputFileName);

    // Seleccionar la hoja donde se agregará la firma
    $sheet = $spreadsheet->getActiveSheet();

    // Crear un objeto de dibujo para insertar la imagen de la firma
    $drawing = new Drawing();
    $drawing->setName('Firma');
    $drawing->setDescription('Firma digital');
    $drawing->setPath($ruta_img); // Ruta de la imagen
    $drawing->setHeight(54); // Altura en píxeles
    $drawing->setCoordinates('B74'); // Celda donde se colocará la firma (por ejemplo, B10)
    $drawing->setWorksheet($sheet);
    $drawing->setOffsetX(30); // Desplazamiento horizontal (en píxeles)
    $drawing->setOffsetY(6); // Desplazamiento vertical (en píxeles)

    // Guardar el archivo Excel con la firma
    $outputFileName = "imagenes_guardadas/archivo_con_firma.xlsx";
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($outputFileName);

    echo "Firma agregada y archivo guardado como $outputFileName.\n";

    // Convertir el archivo Excel a PDF
    convertirExcelAPdf();
    //script2();
}

function convertirExcelAPdf()
{

    // Rutas del archivo Excel y el archivo PDF de salida
    $rutaExcel = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/archivo_con_firma.xlsx";
    $rutaPdf = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/salida.pdf";
    
    // Construir el comando
    $salida = shell_exec("py excelTOpdf.py " . escapeshellarg($rutaExcel) . " " . escapeshellarg($rutaPdf));
    
    
    // Mostrar la salida del comando
    echo "<pre>$salida</pre>";
    
}
?>
