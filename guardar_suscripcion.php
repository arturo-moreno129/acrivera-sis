<?php
$data = file_get_contents("php://input");
if (!$data) exit("Sin datos");

$file = 'suscripciones.json';
$nueva = json_decode($data, true);

if (!$nueva) {
    exit("Error: JSON inválido");
}

// Cargar suscripciones existentes
$subs = [];
if (file_exists($file)) {
    $contenido = file_get_contents($file);
    $subs = json_decode($contenido, true);
    if (!is_array($subs)) {
        $subs = [];
    }
}

// Evitar duplicados
$yaExiste = false;
foreach ($subs as $sub) {
    if ($sub['endpoint'] === $nueva['endpoint']) {
        $yaExiste = true;
        break;
    }
}

if (!$yaExiste) {
    $subs[] = $nueva;
    file_put_contents($file, json_encode($subs, JSON_PRETTY_PRINT));
}

echo "Suscripción guardada correctamente.";
