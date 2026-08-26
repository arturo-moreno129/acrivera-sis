<?php
session_start();
include 'conexion.php';

$user = trim($_POST['user'] ?? '');
$pass = $_POST['password'] ?? '';

if ($user === '' || $pass === '') {
    header('Location: index');
    exit;
}

$userEscaped = mysqli_real_escape_string($con, $user);
$query = "SELECT * FROM USUARIO WHERE USUARIO = '$userEscaped' AND estatus = 'Activo' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row && password_verify($pass, $row['contrasena'])) {
        session_regenerate_id(true);
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['ususario'] = $row['usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellidoP'] = $row['apellidoP'];
        $_SESSION['apellidoM'] = $row['apellidoM'];
        $_SESSION['sexo'] = $row['sexo'];
        $_SESSION['puesto'] = $row['puesto'];
        $_SESSION['departamento'] = $row['departamento'];
        $_SESSION['rol'] = $row['rol'];
        header('Location: loading');
        exit;
    }
}

header('Location: index');
exit;

