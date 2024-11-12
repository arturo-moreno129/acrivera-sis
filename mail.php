<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\GenericProvider;

require 'vendor/autoload.php';

// Configura el proveedor OAuth2
$provider = new GenericProvider([
    'clientId'                => '4af8c540-9cfd-4891-99c4-5b6ec821f227',
    'clientSecret'            => '85183de5-22b1-4def-9f03-65a8d4d9b295',
    'redirectUri'             => 'https://127.0.0.1/oauth2callback',
    'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
    'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',  // URL de detalles del usuario, aunque no siempre se utiliza
    'scopes'                  => 'https://outlook.office365.com/.default'
]);

// Paso 1: Verificar si ya tenemos el código de autorización
if (!isset($_GET['code'])) {
    // Si no tenemos el código, redirigir para autorizar la aplicación
    $authorizationUrl = $provider->getAuthorizationUrl();
    header('Location: ' . $authorizationUrl);
    exit;
}

// Paso 2: Intercambiar el 'authorization_code' por un 'access_token' una vez que se obtiene el código de autorización
try {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Ahora puedes usar el accessToken en PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->AuthType = 'XOAUTH2';
    $mail->setOAuth(new OAuth([
        'provider' => $provider,
        'clientId' => '4af8c540-9cfd-4891-99c4-5b6ec821f227',
        'clientSecret' => '85183de5-22b1-4def-9f03-65a8d4d9b295',
        'accessToken' => $accessToken->getToken(),
        'userName' => 'atolex-04@hotmail.com'
    ]));
    
    // Configuración del correo
    $mail->setFrom('atolex-04@hotmail.com', 'Tu Nombre');
    $mail->addAddress('atolex69@gmail.com');
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es un mensaje de prueba enviado desde PHP usando OAuth2 en Outlook SMTP.';
    
    // Enviar el correo
    $mail->send();
    echo 'Correo enviado exitosamente';
} catch (Exception $e) {
    echo "Error al obtener el token de acceso o enviar el correo: " . $e->getMessage();
}
?>

