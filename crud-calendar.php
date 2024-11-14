<?php
include('conexion.php'); // Incluye la conexión a la base de datos

// Función para eliminar un evento
function eliminarEvento($id_mantenimiento)
{
    global $con; // Usa la conexión global
    $id_mantenimiento = intval($id_mantenimiento); // Convierte a entero para seguridad

    $sqlEliminar = "DELETE FROM mantenimientos WHERE id_mantenimiento = $id_mantenimiento";
    $resultEliminar = mysqli_query($con, $sqlEliminar);

    if ($resultEliminar) {
        return ["status" => "success", "message" => "Elemento eliminado correctamente."];
    } else {
        return ["status" => "error", "message" => "Error al eliminar el elemento."];
    }
}

// Función para actualizar un evento
function actualizarEvento($id_mantenimiento, $nuevoDato)
{
    global $con;
    $id_mantenimiento = intval($id_mantenimiento);
    $nuevoDato = mysqli_real_escape_string($con, $nuevoDato); // Escapa el valor para seguridad

    $sqlActualizar = "UPDATE mantenimientos SET columna = '$nuevoDato' WHERE id_mantenimiento = $id_mantenimiento";
    $resultActualizar = mysqli_query($con, $sqlActualizar);

    if ($resultActualizar) {
        return ["status" => "success", "message" => "Elemento actualizado correctamente."];
    } else {
        return ["status" => "error", "message" => "Error al actualizar el elemento."];
    }
}

// Maneja la acción solicitada
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'eliminar':
            if (isset($_POST['id'])) {
                $response = eliminarEvento($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;

        case 'actualizar':
            if (isset($_POST['id']) && isset($_POST['nuevo_dato'])) {
                $response = actualizarEvento($_POST['id'], $_POST['nuevo_dato']);
            } else {
                $response = ["status" => "error", "message" => "Parámetros insuficientes para actualizar."];
            }
            break;

        default:
            $response = ["status" => "error", "message" => "Acción no válida."];
            break;
    }

    // Retorna la respuesta como JSON
    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "No se especificó ninguna acción."]);
}
