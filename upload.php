<?php
include "header.php";
session_start();
$nombre = $_POST["firstname"];
$apellidoP = $_POST["lastname"];
$apellidoM = $_POST["surname"];
$fechaRegistro = $_POST["fecha-registro"];
$dateTime = DateTime::createFromFormat('Y-m-d', $fechaRegistro);
$formattedDate = $dateTime->format('d/m/Y');
echo $nombre, $apellidoP, $apellidoM, $formattedDate;


//archivo resguardo
if (isset($_FILES['file'])) {
    $uploadDir = 'archivos/mipruebita/'; // Cambia esto por tu ruta deseada
    $tempFile = $_FILES['file']['tmp_name']; // Archivo temporal
    $newFileName = 'resguardo1.pdf'; // Nombre nuevo

    // Mover y renombrar el archivo al mismo tiempo
    if (move_uploaded_file($tempFile, $uploadDir . $newFileName)) {
        $_SESSION["alert"] = "Se guardo correctamente el registro";
        header("location: registro.php");
    } else {
        $_SESSION["alert"] = "Error al subor archivo";
        header("location: registro.php");
    }
} else {
    $_SESSION["alert"] = "Error al subor archivo";
    header("location: registro.php");
}
//archivo mantenimiento
if (isset($_FILES['file1'])) {
    $uploadDir = 'archivos/mipruebita/'; // Cambia esto por tu ruta deseada
    $tempFile = $_FILES['file1']['tmp_name']; // Archivo temporal
    $newFileName = 'mantenimiento1.pdf'; // Nombre nuevo

    // Mover y renombrar el archivo al mismo tiempo
    if (move_uploaded_file($tempFile, $uploadDir . $newFileName)) {
        $_SESSION["alert"] = "Se guardo correctamente el registro";
        header("location: registro.php");
    } else {
        $_SESSION["alert"] = "Error al subor archivo";
        header("location: registro.php");
    }
} else {
    $_SESSION["alert"] = "Error al subor archivo";
    header("location: registro.php");
}






/*********************ESTE ES PARA SUBIR MULTIPLES ARCHIVOS********************/
/*foreach ($_FILES['file']['name'] as $i => $name) {

    //strlen método de php pues devuelve la longitud de una cadena
    if (strlen($_FILES['file']['name'][$i]) > 1) {

        $fileName = $_FILES['file']['name'][$i];
        $temporal = $_FILES['file']['tmp_name'][$i];
        $directorio = "archivos/mipruebita";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777);
        }
        $dir = opendir($directorio);
        $ruta = $directorio . '/' . $fileName;
        if (move_uploaded_file($temporal, $ruta)) {
            echo "el archivo $fileName se almaceno correctamente";
        } else {
            echo "Ha ocurrido un error";
        }
        closedir($dir);
    }
}*/
include "footer.php";
