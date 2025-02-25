<?php
include 'conexion.php';
session_start();
$datosJSON = file_get_contents("php://input");

$datos = json_decode($datosJSON, true);

$dis = strval($datos['datosreparacion']['dispositivo']);
$sol = strval($datos['datosreparacion']['solicitante']);
$desc = strval($datos['datosreparacion']['descripcion']);
$fech = $datos['datosreparacion']['fecha'];

$query_insert = "INSERT INTO reparacion VALUES(DEFAULT,'{$dis}','{$sol}','{$desc}','{$fech}',0,'{$_SESSION['id_usuario']}')";

// Ejecutar la consulta
if (mysqli_query($con, $query_insert)) {
    echo json_encode(["status" => "success", "message" => $datos]);
} else {
    // Capturar el error
    echo json_encode(["status" => "error", "message" => mysqli_error($con)]);
    //echo "Error en la consulta: " . mysqli_error($con);
}
//echo json_encode(["status" => "success", "message" => $dis]);
