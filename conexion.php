<?php
/*$dbHost='127.0.0.1';
    $dbName='bd_acrivera';
    $dbUser='root';
    $dbPass="";
    $con=mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
    try{
        if(isset($con)){
            return $con;
			echo"conexion yes";
        }
    }catch(Exception $ex){
        //echo $ex=getMessage();
        echo 'error';
    }*/
mysqli_report(MYSQLI_REPORT_OFF); // Desactiva los errores fatales de MySQLi

$dbHost = '140.240.13.200';
$dbName = 'bd_acrivera';
$dbUser = 'root';
$dbPass = "Benito290496$";

$con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$con) {
    echo "<script>alert('Error: No se pudo conectar a la base de datos');</script>";
    header('Location: error.php');
    define('NO_DB_ACCESS', true);
    //return false; // Devuelve false si no se conecta
}

return $con; // Retorna la conexión si es exitosa*/
