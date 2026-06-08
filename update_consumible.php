<?php
header('Content-Type: application/json');
require 'conexion.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(['success' => false, 'message' => 'No input']);
    exit;
}

$id_impresora = isset($input['id_impresora']) ? intval($input['id_impresora']) : 0;
$id_consumible = isset($input['id_consumible']) ? intval($input['id_consumible']) : 0;
$ubicacion = isset($input['ubicacion']) ? $con->real_escape_string($input['ubicacion']) : '';
$marca = isset($input['marca']) ? $con->real_escape_string($input['marca']) : '';
$no_serie = isset($input['no_serie']) ? $con->real_escape_string($input['no_serie']) : '';
$modelo = isset($input['modelo']) ? $con->real_escape_string($input['modelo']) : '';
$nombre = isset($input['nombre']) ? $con->real_escape_string($input['nombre']) : '';
$cantidad_disponible = isset($input['cantidad_disponible']) ? intval($input['cantidad_disponible']) : 0;
$direccion_ip = isset($input['direccion_ip']) ? $con->real_escape_string($input['direccion_ip']) : '';

if (!$id_impresora || !$id_consumible) {
    echo json_encode(['success' => false, 'message' => 'IDs inválidos']);
    exit;
}

$success = true;
$con->begin_transaction();
try {
    $stmt = $con->prepare("UPDATE impresoras SET ubicacion = ?, marca = ?, no_serie = ?, modelo = ?, direccion_ip = ? WHERE id_impresora = ?");
    $stmt->bind_param('sssssi', $ubicacion, $marca, $no_serie, $modelo, $direccion_ip, $id_impresora);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $con->prepare("UPDATE consumibles SET nombre = ?, cantidad_disponible = ? WHERE id_consumible = ?");
    $stmt2->bind_param('sii', $nombre, $cantidad_disponible, $id_consumible);
    $stmt2->execute();
    $stmt2->close();

    $con->commit();
    echo json_encode(['success' => true, 'marca' => $marca]);
} catch (Exception $e) {
    $con->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>