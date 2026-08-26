<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbHost = '140.240.13.200';
$dbName = 'bd_acrivera';
$dbUser = 'root';
$dbPass = 'Benito290496$';

$con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$con) {
    die('Error: No se pudo conectar a la base de datos. ' . mysqli_connect_error());
}

mysqli_set_charset($con, 'utf8mb4');

