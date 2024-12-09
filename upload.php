<?php
include "conexion.php";
session_start();
$selectUser = $_POST["select-user"];
$nombre = $_POST["firstname"];
$apellidoP = $_POST["lastname"];
$apellidoM = $_POST["surname"];
$fechaRegistro = $_POST["fecha-registro"];
$dis = $_POST["dispositivo"];
$dateTime = DateTime::createFromFormat('Y-m-d', $fechaRegistro);
$formattedDate = $dateTime->format('d/m/Y');
$nomCompleto = sprintf("%s %s %s", trim($nombre), trim($apellidoP), trim($apellidoM));

/*******realizamo la consulta***********/
$query = "SELECT count(url_resguardo) as resguardos, count(url_mantenimiento) as mantenimiento from evidencia where nombre = '$nomCompleto'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result); // Obtiene los datos como un array asociativo

if (!empty($_FILES['file']['name']) && empty($_FILES['file1']['name'])) {
    //echo $nombre, $apellidoP, $apellidoM, $formattedDate, $_FILES['file']['name'];
    /*resguardo("file");
    $_SESSION["alert"] = "entro";
    header("location: registro.php");*/
    echo "docume resguardo";
    $myarray = [
        [
            "dato" => "file",
            "cant" => $data["resguardos"],
            "tipo" => "RESGUARDO"
        ]
    ];
    resguardo($myarray, $nomCompleto, $formattedDate, $dis, $con,"R");
} elseif (empty($_FILES['file']['name']) && !empty($_FILES['file1']['name'])) {
    /*$_SESSION["alert"] = "entro";
    header("location: registro.php");*/
    echo "docume mantenimiento";
    $myarray = [
        [
            "dato" => "file1",
            "cant" => $data["mantenimiento"],
            "tipo" => "MANTENIMIENTO"
        ]
    ];
    resguardo($myarray, $nomCompleto, $formattedDate, $dis, $con,"M");
} elseif (empty($_FILES['file']['name']) && empty($_FILES['file1']['name'])) {
    echo "SIN DOCUMENTOS";
    insert($nomCompleto, $formattedDate, $dis, null, $con,null);
} elseif (!empty($_FILES['file']['name']) && !empty($_FILES['file1']['name'])) {
    /*$_SESSION["alert"] = "no entro";
    header("location: registro.php");*/
    echo "AMBOS documento";
    $myarray = [
        [
            "dato" => "file",
            "cant" => $data["resguardos"],
            "tipo" => "RESGUARDO"
        ],
        [
            "dato" => "file1",
            "cant" => $data["mantenimiento"],
            "tipo" => "MANTENIMIENTO"
        ]
    ];
    resguardo($myarray, $nomCompleto, $formattedDate, $dis, $con,"A");
}

function resguardo($array, $urlinsert, $mydate, $mydevice, $mycon,$myflag)
{
    $arrayNew = [];
    for ($i = 0; $i < count($array); $i++) {
        # code...
        //archivo
        if (isset($_FILES[$array[$i]['dato']]) && $_FILES[$array[$i]['dato']]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'carpetas/' . $urlinsert . "/"; // Cambia esto por tu ruta deseada
            $tempFile = $_FILES[$array[$i]['dato']]['tmp_name']; // Archivo temporal
            $newFileName = strval($array[$i]['tipo']) . '_' . strval($array[$i]['cant'] + 1) . '.pdf'; // Nombre nuevo
            //comprobamos si exite la carpeta con ese nombre
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777);
            }
            // Mover y renombrar el archivo al mismo tiempo
            if (move_uploaded_file($tempFile, $uploadDir . $newFileName)) {
                $_SESSION["alert"] = "¡Se guardo con exito!";
                //header("location: registro.php");
            } else {
                $_SESSION["alert"] = "¡Error al subor archivo!";
                //header("location: registro.php");
            }
            array_push($arrayNew, $newFileName);
        }
    }
    print_r($arrayNew);
    insert($urlinsert, $mydate, $mydevice, $arrayNew, $mycon,$myflag);
}
function insert($nom, $fecha, $dispo, $url, $conetion,$flag)
{
   switch ($flag) {
    case 'R':
        # code...
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo','$url[0]',null,1,1)";
        mysqli_query($conetion, $query);
        break;
    case 'M':
        # code...
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo',null,'$url[1]',1,1)";
        mysqli_query($conetion, $query);
        break;
    case 'A':
        # code...
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo','$url[0]','$url[1]',1,1)";
        mysqli_query($conetion, $query);
        break;
    default:
        # code...
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo',null,null,1,1)";
        mysqli_query($conetion, $query);
        $_SESSION["alert"] = "¡Se guardo con exito!";
        break;
   }
   header("location: registro.php");
    /*if (str_starts_with($url, 'R')) {
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo','$url',null,1,1)";
        mysqli_query($conetion, $query);
    } else {
        $query = "INSERT INTO evidencia VALUES(DEFAULT,'$nom','$fecha','$dispo',null,'$url',1,1)";
        mysqli_query($conetion, $query);
    }*/
}

/*function mantenimiento()
{
    //archivo mantenimiento
    if (isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK) {
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
    }
}*/
//header("location: registro.php");



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
//include "footer.php";
