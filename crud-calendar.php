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
function finalizarEvento($id_mantenimiento)
{
    global $con; // Usa la conexión global
    $id_mantenimiento = intval($id_mantenimiento); // Convierte a entero para seguridad
    $sqlFinalizarTarea = "UPDATE mantenimientos SET estatus = 0 WHERE id_mantenimiento = '$id_mantenimiento'";
    $resultadoFinal = mysqli_query($con, $sqlFinalizarTarea);
    if ($resultadoFinal) {
        return ["status" => "success", "message" => "Elemento finalizado correctamente."];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
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

function updateDate($id, $fexhaupdate, $usuRec)
{
    global $con;
    $idrepa = intval($id);
    $fexhaupdate = mysqli_real_escape_string($con, $fexhaupdate);
    $usuRec = mysqli_real_escape_string($con, $fexhaupdate);

    $query = "UPDATE reparacion set nom_recepcion = '$usuRec', fecha_entrega = '$fexhaupdate',estatus=1 where id_repa = $idrepa";
    $result = mysqli_query($con, $query);
    if ($result) {
        return ["status" => "success", "message" => "Elemento actualizado correctamente."];
    } else {
        return ["status" => "error", "message" => "Error al actualizar el elemento."];
    }
}
function obtenerDatos($idDir)
{
    global $con; // Usa la conexión global
    $idDir = intval($idDir); // Convierte a entero para seguridad
    $sqlselect = "SELECT * FROM directorio WHERE id_user = {$idDir}";
    $resultadoFinal = mysqli_query($con, $sqlselect);
    if ($resultadoFinal) {
        $datos = mysqli_fetch_all($resultadoFinal, MYSQLI_ASSOC); //Convierte el resultado en array asociativo
        return ["status" => "success", "message" => $datos];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function updateDir($id, $nom, $puesto, $correo, $extension)
{
    global $con; // Usa la conexión global
    $id = intval($id); // Convierte a entero para seguridad
    $sqlupdate = "UPDATE directorio set nom_usu = '$nom',puesto = '$puesto',correo = '$correo',extencion = '$extension' where id_user = $id";
    $result = mysqli_query($con, $sqlupdate);
    if ($result) {
        return ["status" => "success", "message" => "Se actualizo correctamente el directorio"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function insertDir($nom, $puesto, $correo, $extension, $area)
{
    global $con; // Usa la conexión global
    $sqlinsert = "INSERT into directorio values(default,'$nom','$puesto','$correo','$extension','$area')";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Se inserto correctamente al directorio"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
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
        case 'finalizarTarea':
            # code...
            if (isset($_POST['id'])) {
                $response = finalizarEvento($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'updateDate':
            # code...
            if (isset($_POST['id']) && isset($_POST['fecha']) && isset($_POST['usurecep'])) {
                $response = updateDate($_POST['id'], $_POST['fecha'], $_POST['usurecep']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'obtenerDatos':
            # code...
            if (isset($_POST['id'])) {
                $response = obtenerDatos($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'updateDir':
            # code...
            if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['puesto']) && isset($_POST['correo']) && isset($_POST['extension'])) {
                $response = updateDir($_POST['id'], $_POST['nombre'], $_POST['puesto'], $_POST['correo'], $_POST['extension']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'insertDir':
            # code...
            if (isset($_POST['nombre']) && isset($_POST['puesto']) && isset($_POST['correo']) && isset($_POST['extension']) && isset($_POST['area'])) {
                $response = insertDir($_POST['nombre'], $_POST['puesto'], $_POST['correo'], $_POST['extension'], $_POST['area']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
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
