<?php
include("conexion.php");
session_start();

$idUsuario = $_SESSION['id_usuario'];

$query = "SELECT id_notificacion, texto, leida, url, creada_en 
FROM notificaciones 
WHERE usuario_id = $idUsuario OR usuario_id = 19
ORDER BY leida ASC, creada_en DESC
LIMIT 5";

$result = mysqli_query($con, $query);

$notificaciones = [];

while ($row = mysqli_fetch_assoc($result)) {
    $notificaciones[] = $row;
}

echo json_encode($notificaciones);
