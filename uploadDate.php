<?php
include "conexion.php";
session_start();
$title = $_POST['phptitle'];
$description = $_POST['phpdescription'];
$date = $_POST['phpdate'];
$user = $_POST['phpuser'];
// Procesar los datos...
echo "Titulo: $title, Descripcion: $description, Fecha: $date, Usuario: $user";
$query = "INSERT INTO mantenimietos VALUES(default,'$title','$date','$description',1,'$user')";
$resul = mysqli_query($con, $query);
$_SESSION["alert"] = "¡Se guardo con exito!";
header("location:mantenimientos.php")
?>