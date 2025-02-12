<?php
include('conexion.php');
$datos = json_decode(file_get_contents("php://input"), true);

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
        echo "Imagen guardada exitosamente en: $rutaDestino\n"." y el id es: {$datos['id_usu']}."." y la card es:{$datos['cards']}";
        $array_info = consultaSQL($datos['id_usu'],$con,$datos['cards']);
        incrustacion($array_info);
    } else {
        echo "Error al guardar la imagen.";
    }
} else {
    echo "No se recibió ninguna imagen.";
}

function consultaSQL($idUsr,$conectio,$card){
    $query_show = "SELECT * FROM evidencia WHERE id_evidencia = {$idUsr}";
    $result_show = mysqli_query($conectio,$query_show);
    $array_datos = [];
    if (mysqli_num_rows($result_show) > 0){
        while ($row = mysqli_fetch_array($result_show)) {
            array_push($array_datos, $row['nombre']);
            if($card==0){
                array_push($array_datos, $row['url_resguardo']);
            }
            else{
                array_push($array_datos, $row['url_mantenimiento']);
            }
        }
    }
    return $array_datos;
}
function incrustacion($array){
    // Rutas del archivo Excel y el archivo PDF de salida
    //$rutaExcel = "C:/xampp/htdocs/acrivera-sis/imagenes_guardadas/archivo_con_firma.xlsx";
    $directorio = 'carpetas/'.$array[0].'/';
    $document = $array[1];
    $rutaPdf = $directorio.$document;//"C:/xampp/htdocs/acrivera-sis/{$directorio}/{$document}";
    // Construir el comando
    echo $rutaPdf;
    $salida = shell_exec("py prueba_firma_pdf.py " . escapeshellarg($rutaPdf));

    // Mostrar la salida del comando
    echo "<pre>$salida</pre>";
}

?>