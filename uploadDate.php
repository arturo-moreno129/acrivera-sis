<?php
include "conexion.php";
session_start();
$name = $_POST['phptitle'];
$date = $_POST['phpdate'];
$user = $_POST['phpuser'];
$tipoMan = $_POST['phpRadio'];
$dispo = $_POST['phpdispo'];
$correo = "correo@oulook.com";//$_POST['phpmail'];
// Procesar los datos...
//echo "Titulo: $title, Descripcion: $description, Fecha: $date, Usuario: $user";
$query = "INSERT INTO mantenimietos VALUES(default,'$name','$date','$dispo','$tipoMan',1,'$correo','$user')";
$resul = mysqli_query($con, $query);
$_SESSION['pop-up'] = 1;
header("location:mantenimientos.php");
/*
// Incluye el archivo de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Outlook
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'soporte1@acrivera.com.mx';  // Tu dirección de Outlook
    $mail->Password = 'PUE.ZcSh4GRQd7tV*Mayo2024';         // Tu contraseña de Outlook
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('soporte1@acrivera.com.mx', 'Tu Nombre');
    $mail->addAddress('atolex69@gmail.com');   // Dirección del destinatario
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es el mensaje de prueba enviado desde mi página web local.';

    // Enviar correo
    $mail->send();
    echo 'El correo ha sido enviado con éxito';
    //header("location:mantenimientos.php");
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}*/
?>