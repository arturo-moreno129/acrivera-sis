<?php
include('conexion.php'); // Incluye la conexión a la base de datos
session_start(); //se debe de poner siempre donde se usan sesiones
// Función para eliminar un evento
function eliminarEvento($id_mantenimiento)
{
    global $con; // Usa la conexión global
    $id_mantenimiento = intval($id_mantenimiento); // Convierte a entero para seguridad

    $sqlEliminar = "UPDATE mantenimientos SET estatus = 2 WHERE id_mantenimiento = '$id_mantenimiento'";
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
function updateDir($id, $nom, $puesto, $correo, $extension, $area)
{
    global $con; // Usa la conexión global
    $id = intval($id); // Convierte a entero para seguridad
    $sqlupdate = "UPDATE directorio set nom_usu = '$nom',puesto = '$puesto',correo = '$correo',extencion = '$extension',area = '$area' where id_user = $id";
    $result = mysqli_query($con, $sqlupdate);
    if ($result) {
        return ["status" => "success", "message" => "Se actualizo correctamente el directorio"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function updateInv($id, $usr, $equipo, $modelo, $marca, $no_serie, $nom_host, $departamento, $slect2)
{
    global $con; // Usa la conexión global
    $id = intval($id); // Convierte a entero para seguridad
    $sqlupdate = "UPDATE inventario set usuario_asignado = '$usr',tipo_equipo = '$equipo',modelo = '$modelo',marca = '$marca',no_serie = '$no_serie',nom_host = '$nom_host',departamento = '$departamento',estatus = '$slect2' where id_inventario = $id";
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
    $sqlinsert = "INSERT into directorio values(default,'$nom','$puesto','$correo','$extension','$area',1)";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Se inserto correctamente al directorio"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function deleteDir($id_DIR)
{
    global $con; // Usa la conexión global
    $id_DIR = intval($id_DIR);
    $sqlinsert = "UPDATE directorio set estatus = 0 where id_user =$id_DIR";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Se elimino correctamente"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function deleteInv($id_DIR)
{
    global $con; // Usa la conexión global
    $id_DIR = intval($id_DIR);
    $sqlinsert = "UPDATE inventario set estatus = 2 where id_inventario =$id_DIR";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Se elimino correctamente"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function obtenerImpresoras($idDir)
{
    global $con; // Usa la conexión global
    $idDir = intval($idDir); // Convierte a entero para seguridad
    $sqlselect = "SELECT * FROM impresoras WHERE id_impresora = {$idDir}";
    $resultadoFinal = mysqli_query($con, $sqlselect);
    if ($resultadoFinal) {
        $datos = mysqli_fetch_all($resultadoFinal, MYSQLI_ASSOC); //Convierte el resultado en array asociativo
        return ["status" => "success", "message" => $datos];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}

function obtenerDatosInventario($idDir)
{
    global $con; // Usa la conexión global
    $idDir = intval($idDir); // Convierte a entero para seguridad
    $sqlselect = "SELECT * FROM inventario WHERE id_inventario = {$idDir}";
    $resultadoFinal = mysqli_query($con, $sqlselect);
    if ($resultadoFinal) {
        $datos = mysqli_fetch_all($resultadoFinal, MYSQLI_ASSOC); //Convierte el resultado en array asociativo
        return ["status" => "success", "message" => $datos];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}

function insertarInventario($txtname, $txtequipo, $txtmodelo, $txtmarca, $txtno_serie, $txtnom_host, $txtdepartamento)
{
    global $con; // Usa la conexión global
    $sqlinsert = "INSERT into inventario values(default,'$txtname','$txtequipo','$txtmodelo','$txtmarca','$txtno_serie','$txtnom_host','$txtdepartamento',1)";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Se inserto correctamente al inventario"];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}

function obtenerUsuarios()
{
    global $con; // Usa la conexión global
    $usuario_encontrado = $_SESSION['id_usuario'];
    $sqlinsert = "SELECT * FROM usuario WHERE id_usuario != '{$usuario_encontrado}'";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        $datos = mysqli_fetch_all($result, MYSQLI_ASSOC); //Convierte el resultado en array asociativo
        return ["status" => "success", "message" => $datos];
    } else {
        return ["status" => "error", "message" => "Error al finalizar el elemento."];
    }
}
function compartirEvento($id_mantenimiento, $id_usuario_compartido)
{
    global $con; // Usa la conexión global
    $id_mantenimiento = intval($id_mantenimiento);
    $id_usuario_compartido = intval($id_usuario_compartido);
    $sqlinsert = "INSERT INTO compartidos (id_compartido, id_cita, id_usuario_compartido) VALUES (default, $id_mantenimiento, $id_usuario_compartido)";
    $result = mysqli_query($con, $sqlinsert);
    if ($result) {
        return ["status" => "success", "message" => "Evento compartido correctamente"];
    } else {
        return ["status" => "error", "message" => "Error al compartir el evento. El evento ya fue compartido con este usuario."];
    }
}
function actualizarFecha($id_evento, $nuevaFecha)
{
    global $con; // Usa la conexión global
    $id_evento = intval($id_evento);
    $nuevaFecha = mysqli_real_escape_string($con, $nuevaFecha);
    $sqlupdate = "UPDATE mantenimientos SET fecha = '$nuevaFecha' WHERE id_mantenimiento = $id_evento";
    $result = mysqli_query($con, $sqlupdate);
    if ($result) {
        return ["status" => "success", "message" => "Fecha actualizada correctamente"];
    } else {
        return ["status" => "error", "message" => "Error al actualizar la fecha."];
    }
}

function actualizarConsumibles($id_consumible, $cantidad, $tipo)
{
    global $con; // Usa la conexión global
    $id_consumible = intval($id_consumible);
    $cantidad = intval($cantidad);
    $tipo = $tipo; // 'entrada' o 'salida'
    if ($tipo === 'entrada') {
        $sqlupdate = "UPDATE consumibles SET cantidad_disponible = cantidad_disponible + $cantidad WHERE id_consumible = $id_consumible";
        $result = mysqli_query($con, $sqlupdate);
        if ($result) {
            $sqlinsert = "INSERT INTO movimientos_consumibles VALUES (default, '$tipo', $cantidad, NOW(),'N/A',$id_consumible)";
            $result = mysqli_query($con, $sqlinsert);
            if ($result) {
                return ["status" => "success", "message" => "Consumibles actualizados correctamente"];
            } else {
                return ["status" => "error", "message" => "Error al registrar el movimiento."];
            }
        } else {
            return ["status" => "error", "message" => "Error al actualizar los consumibles."];
        }
    } elseif ($tipo === 'salida') {
        $sqlupdate = "UPDATE consumibles SET cantidad_disponible = GREATEST(cantidad_disponible - $cantidad, 0) WHERE id_consumible = $id_consumible";//GREATEST(x(resultado de la resta), 0) → devuelve el valor más grande entre x y 0. si x es negativo, devuelve 0.
        $result = mysqli_query($con, $sqlupdate);
        if ($result) {
            $sqlinsert = "INSERT INTO movimientos_consumibles VALUES (default, '$tipo', $cantidad, NOW(),'N/A',$id_consumible)";
            $result = mysqli_query($con, $sqlinsert);
            if ($result) {
                return ["status" => "success", "message" => "Consumibles actualizados correctamente"];
            } else {
                return ["status" => "error", "message" => "Error al registrar el movimiento."];
            }
        } else {
            return ["status" => "error", "message" => "Error al actualizar los consumibles."];
        }
    } else {
        return ["status" => "error", "message" => "Tipo no válido. Debe ser 'entrada' o 'salida'."];
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
            if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['puesto']) && isset($_POST['correo']) && isset($_POST['extension']) && isset($_POST['area'])) {
                $response = updateDir($_POST['id'], $_POST['nombre'], $_POST['puesto'], $_POST['correo'], $_POST['extension'], $_POST['area']);
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
        case 'deleteDir':
            # code...
            if (isset($_POST['id'])) {
                $response = deleteDir($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'obtenerImpresoras':
            # code...
            if (isset($_POST['idprint'])) {
                $response = obtenerImpresoras($_POST['idprint']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'obtenerDatosInventario':
            # code...
            if (isset($_POST['id'])) {
                $response = obtenerDatosInventario($_POST['id']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'updateInv':
            # code...
            if (isset($_POST['id']) && isset($_POST['usu']) && isset($_POST['equipo']) && isset($_POST['modelo']) && isset($_POST['marca']) && isset($_POST['noSerie']) && isset($_POST['host']) && isset($_POST['depa']) && isset($_POST['estatus'])) {
                $response = updateInv($_POST['id'], $_POST['usu'], $_POST['equipo'], $_POST['modelo'], $_POST['marca'], $_POST['noSerie'], $_POST['host'], $_POST['depa'], $_POST['estatus']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            //$response = ["status" => "success", "message" => "entro al switch"];
            break;
        case 'insertarInventario':
            # code...
            if (isset($_POST['txtname']) && isset($_POST['txtequipo']) && isset($_POST['txtmodelo']) && isset($_POST['txtmarca']) && isset($_POST['txtno_serie']) && isset($_POST['txtnom_host']) && isset($_POST['txtdepartamento'])) {
                $response = insertarInventario($_POST['txtname'], $_POST['txtequipo'], $_POST['txtmodelo'], $_POST['txtmarca'], $_POST['txtno_serie'], $_POST['txtnom_host'], $_POST['txtdepartamento']);
            } else {
                $response = ["status" => "error", "message" => "ID no proporcionado."];
            }
            break;
        case 'obtenerUsuarios':
            # code...
            $response = obtenerUsuarios();
            break;
        case 'compartir':
            if (isset($_POST['id']) && isset($_POST['usuario'])) {
                $response = compartirEvento($_POST['id'], $_POST['usuario']);
            } else {
                $response = ["status" => "error", "message" => "ID o usuario no proporcionado."];
            }
            break;
        case 'actualizarFecha':
            if (isset($_POST['id']) && isset($_POST['fecha'])) {
                $response = actualizarFecha($_POST['id'], $_POST['fecha']);
            } else {
                $response = ["status" => "error", "message" => "ID o fecha no proporcionada."];
            }
            break;
        case 'actualizarConsumibles':
            if (isset($_POST['id_consumible']) && isset($_POST['cantidad']) && isset($_POST['tipo'])) {
                $response = actualizarConsumibles($_POST['id_consumible'], $_POST['cantidad'], $_POST['tipo']);
            } else {
                $response = ["status" => "error", "message" => "ID o fecha no proporcionada."];
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
