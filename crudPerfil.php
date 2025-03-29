<?php
include 'conexion.php';

function obtenerDatos($id)
{
    global $con; // Usa la conexión global
    $id = intval($id);
    $sqlinsert = "SELECT * FROM directorio where id_user = $id";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        $datos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return ["status" => "success", "message" => $datos];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $response = ["status" => "error", "message" => "Acción no válida."];
    switch ($action) {
        case 'obtenerDatos':
            if (!empty($_POST['id'])) {
                $response = obtenerDatos($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
    }
    echo json_encode($response);
    exit;
}

// Si alguien accede directamente sin hacer una petición POST
echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
exit;
