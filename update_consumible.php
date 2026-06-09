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
$selected_consumible_id = isset($input['selected_consumible_id']) ? intval($input['selected_consumible_id']) : 0;
$ubicacion = isset($input['ubicacion']) ? $con->real_escape_string($input['ubicacion']) : null;
$marca = isset($input['marca']) ? $con->real_escape_string($input['marca']) : null;
$no_serie = isset($input['no_serie']) ? $con->real_escape_string($input['no_serie']) : null;
$modelo = isset($input['modelo']) ? $con->real_escape_string($input['modelo']) : null;
$nombre = isset($input['nombre']) ? $con->real_escape_string($input['nombre']) : null;
$cantidad_disponible = isset($input['cantidad_disponible']) ? intval($input['cantidad_disponible']) : null;
$direccion_ip = isset($input['direccion_ip']) ? $con->real_escape_string($input['direccion_ip']) : null;

if (!$id_impresora || !$id_consumible) {
    echo json_encode(['success' => false, 'message' => 'IDs inválidos']);
    exit;
}

$success = true;
$con->begin_transaction();
try {
    if ($ubicacion !== null || $marca !== null || $no_serie !== null || $modelo !== null || $direccion_ip !== null) {
        $stmt = $con->prepare("UPDATE impresoras SET ubicacion = COALESCE(?, ubicacion), marca = COALESCE(?, marca), no_serie = COALESCE(?, no_serie), modelo = COALESCE(?, modelo), direccion_ip = COALESCE(?, direccion_ip) WHERE id_impresora = ?");
        $stmt->bind_param('sssssi', $ubicacion, $marca, $no_serie, $modelo, $direccion_ip, $id_impresora);
        $stmt->execute();
        $stmt->close();
    }

    if ($selected_consumible_id && $selected_consumible_id !== $id_consumible) {
        $stmt3 = $con->prepare("UPDATE impresoras SET id_consumible = ? WHERE id_impresora = ?");
        $stmt3->bind_param('ii', $selected_consumible_id, $id_impresora);
        $stmt3->execute();
        $stmt3->close();
    }

    if ($nombre !== null || $cantidad_disponible !== null) {
        $stmt2 = $con->prepare("UPDATE consumibles SET nombre = COALESCE(?, nombre), cantidad_disponible = COALESCE(?, cantidad_disponible) WHERE id_consumible = ?");
        $stmt2->bind_param('sii', $nombre, $cantidad_disponible, $id_consumible);
        $stmt2->execute();
        $stmt2->close();
    }

    $con->commit();
    echo json_encode(['success' => true, 'marca' => $marca]);
} catch (Exception $e) {
    $con->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>