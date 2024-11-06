<?php
include "conexion.php";
session_start();
$name = $_POST['phptitle'];
$date = $_POST['phpdate'];
$user = $_POST['phpuser'];
$tipoMan = $_POST['phpRadio'];
$dispo = $_POST['phpdispo'];
// Procesar los datos...
//echo "Titulo: $title, Descripcion: $description, Fecha: $date, Usuario: $user";
$query = "INSERT INTO mantenimietos VALUES(default,'$name','$date','$dispo','$tipoMan',1,'$user')";
$resul = mysqli_query($con, $query);
$_SESSION['pop-up'] = 1;
header("location:calendario.php")
?>