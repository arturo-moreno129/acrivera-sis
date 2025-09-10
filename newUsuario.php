<?php
session_start();
include 'conexion.php';

$usuario = $_POST['usuario'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellido_paterno = $_POST['apellido_paterno'] ?? null;
$apellido_materno = $_POST['apellido_materno'] ?? null;
$puesto = $_POST['puesto'] ?? null;
$departamento = $_POST['departamento'] ?? null;
$contrasena = $_POST['contrasena'] ?? null;
$rol = $_POST['rol'] ?? null;
if ($usuario != null && $nombre != null && $apellido_paterno != null && $puesto != null && $departamento != null && $contrasena != null && $rol != null) {
    # code...
    $password = $contrasena;
    // Hasheamos la contraseña con un algoritmo seguro (por defecto, PASSWORD_BCRYPT)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT into usuario values(default,'$usuario','$nombre','$apellido_paterno','$apellido_materno','$puesto','$departamento','$hashed_password',$rol)";
    mysqli_query($con, $query);
    if (mysqli_errno($con)) {
        $_SESSION['mensaje'] = "Error al crear el usuario: " . mysqli_error($con);
        header("Location: altaUsuario.php");
        exit();
    }
    $_SESSION['mensaje'] = "Usuario $usuario creado correctamente.";
    header("Location: altaUsuario.php");
    exit();
} else {
    $_SESSION['mensaje'] = null;
}

$password = "inicio0725"; //$_POST['password'];
// Hasheamos la contraseña con un algoritmo seguro (por defecto, PASSWORD_BCRYPT)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT into usuario values(default,'AFlores','Antonio','Flores','Atempa','Supervisor de Vigilancia','Recursos Humanos','$hashed_password',2)";
/*$query_impresora = "INSERT into impresoras values (default,'TORRE DE CONTROL','BROTHER','140.240.13.203','B4:22:00:79:4B:1C','$hashed_password'),
                                                    (default,'VENTAS AFUERA','BROTHER','140.240.13.204','84:25:19:67:2F:F4','$hashed_password'),
                                                    (default,'RECURSOS HUMANOS','KYOCERA','140.240.13.207','00:17:C8:CB:0D:2F','$hashed_password'),
                                                    (default,'CONTABILIDAD','KYOCERA','140.240.13.219','00:17:C8:CA:FE:46','$hashed_password'),
                                                    (default,'RECEPCIÓN','KYOCERA','140.240.13.205','00:17:C8:EA:03:37','$hashed_password'),
                                                    (default,'ALMACÉN','KYOCERA','140.240.13.120','00:17:C8:CA:FE:37','$hashed_password')";*/
//echo mysqli_query($con, $query);
//$query= "UPDATE usuario SET contrasena = '$hashed_password' WHERE id_usuario > 1";
//mysqli_query($con, $query);
