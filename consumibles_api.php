<?php
header('Content-Type: application/json');
require 'conexion.php';
session_start();

if (!isset($_SESSION['ususario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'list';

switch ($action) {
    case 'list':
        $result = mysqli_query($con, "SELECT id_consumible, nombre, cantidad_disponible, descripcion FROM consumibles ORDER BY id_consumible ASC");
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'create':
        $nombre = isset($_POST['nombre']) ? $con->real_escape_string($_POST['nombre']) : '';
        $cantidad = isset($_POST['cantidad_disponible']) ? intval($_POST['cantidad_disponible']) : 0;
        $descripcion = isset($_POST['descripcion']) ? $con->real_escape_string($_POST['descripcion']) : '';

        if ($nombre === '') {
            echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio']);
            break;
        }

        $stmt = $con->prepare("INSERT INTO consumibles (nombre, cantidad_disponible, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $nombre, $cantidad, $descripcion);
        $executed = $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        if ($executed) {
            echo json_encode(['success' => true, 'id_consumible' => $insertId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo crear el consumible']);
        }
        break;

    case 'update':
        $id = isset($_POST['id_consumible']) ? intval($_POST['id_consumible']) : 0;
        $nombre = isset($_POST['nombre']) ? $con->real_escape_string($_POST['nombre']) : '';
        $cantidad = isset($_POST['cantidad_disponible']) ? intval($_POST['cantidad_disponible']) : 0;
        $descripcion = isset($_POST['descripcion']) ? $con->real_escape_string($_POST['descripcion']) : '';

        if (!$id || $nombre === '') {
            echo json_encode(['success' => false, 'message' => 'ID o nombre inválido']);
            break;
        }

        $stmt = $con->prepare("UPDATE consumibles SET nombre = ?, cantidad_disponible = ?, descripcion = ? WHERE id_consumible = ?");
        $stmt->bind_param('sisi', $nombre, $cantidad, $descripcion, $id);
        $executed = $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => $executed]);
        break;

    case 'delete':
        $id = isset($_POST['id_consumible']) ? intval($_POST['id_consumible']) : 0;
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            break;
        }

        $stmt = $con->prepare("DELETE FROM consumibles WHERE id_consumible = ?");
        $stmt->bind_param('i', $id);
        $executed = $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => $executed]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}
