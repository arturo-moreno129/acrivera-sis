<?php
header('Content-Type: application/json');

// Ruta de la unidad compartida
$ruta = "//140.240.13.164/D$"; 

// Verifica si se puede acceder
if (is_dir($ruta)) {
    echo json_encode(["activo" => true]);
} else {
    echo json_encode(["activo" => false]);
}
