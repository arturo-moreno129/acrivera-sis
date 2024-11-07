<?php
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
    $mail->Username = 'sistemas1@acrivera.com.mx';  // Tu dirección de Outlook
    $mail->Password = 'tu_contraseña';         // Tu contraseña de Outlook
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('tucorreo@outlook.com', 'Tu Nombre');
    $mail->addAddress('atolex69@gmail.com');   // Dirección del destinatario
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es el mensaje de prueba enviado desde mi página web local.';

    // Enviar correo
    $mail->send();
    echo 'El correo ha sido enviado con éxito';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
