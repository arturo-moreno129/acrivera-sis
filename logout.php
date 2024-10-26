<?php
session_start(); // Inicia la sesión

// Código para cerrar sesión
if (isset($_SESSION['ususario'])) {
    // Destruye todas las variables de sesión
    $_SESSION = []; // Limpiar las variables de sesión
    session_destroy(); // Destruir la sesión

    // Redirigir a la página de inicio o de login
    header("location: index.php");
    exit();
}
?>