<?php
include("conexion.php");
session_start();

$idUsuario = $_SESSION['id_usuario'];

$query = "SELECT id_mantenimiento,usuario_final, fecha, horaInicio, horaFin from mantenimientos
WHERE id_usuario = $idUsuario and estatus = 1";

$result = mysqli_query($con, $query);

$notificaciones = [];

while ($row = mysqli_fetch_assoc($result)) {
    $notificaciones[] = $row;
}

echo json_encode($notificaciones);


//tomar las ultimas 5 notificaciones no leidas y leidas del usuario logueado
//ordenadas por leidas primero y luego por fecha de creacion descendente
