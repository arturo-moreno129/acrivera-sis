<?php
session_start();
include('conexion.php');

$eventos = [];

$sql = "
  SELECT m.*
  FROM mantenimientos m
  WHERE m.id_usuario = {$_SESSION['id_usuario']} AND m.estatus != 2
  UNION
  SELECT m.*
  FROM mantenimientos m
  JOIN compartidos c ON m.id_mantenimiento = c.id_cita
  WHERE c.id_usuario_compartido = {$_SESSION['id_usuario']} AND m.estatus != 2
";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {

  $puedeEditar = ($row['estatus'] == 1 && $row['id_usuario'] == $_SESSION['id_usuario']) ? true : false;

  $eventos[] = [
    "id" => $row['id_mantenimiento'],
    "title" => $row['usuario_final'],
    "start" => $row['fecha'] . "T" . $row['horaInicio'],
    "end" => $row['fecha'] . "T" . $row['horaFin'],
    "color" => ($row['estatus'] == 1) ? "#60c4f3" : "red",
    "editable" => $puedeEditar,
    "groupId" => $puedeEditar ? 1 : 0,
    "extendedProps" => [
      "description" =>
        "Titulo: {$row['usuario_final']}\n" .
        "Fecha: {$row['fecha']}\n" .
        "Hora: {$row['horaInicio']} - {$row['horaFin']}\n" .
        "Detalles: {$row['dispositivo']}\n" .
        "Realizado por: {$row['correo']}"
    ]
  ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($eventos);
