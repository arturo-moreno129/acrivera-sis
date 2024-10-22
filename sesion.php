<?php
include 'conexion.php';
$user = $_POST['user'];
$pass = $_POST['password'];
session_start();
/*$password = "Benito290496$";//$_POST['password'];
// Hasheamos la contraseña con un algoritmo seguro (por defecto, PASSWORD_BCRYPT)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO USUARIO VALUE(DEFAULT,'JMoreno','JOSE ARTURO','MORENO','AGUILAR','SOPORTE','SISTEMAS','$hashed_password')";
mysqli_query($con, $query);*/

$query = "SELECT * FROM USUARIO WHERE USUARIO ='$user'";
$result = mysqli_query($con, $query);
if ($row = mysqli_num_rows($result) > 0) {
    // Si la consulta fue exitosa, puedes acceder a los datos.
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['usuario'] == $user) {
            if (password_verify($pass, $row["contrasena"])) {
                $_SESSION['ususario'] = $row['usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellidoP'] = $row['apellidoP'];
                $_SESSION['apellidoM'] = $row['apellidoM'];
                $_SESSION['puesto'] = $row['puesto'];
                $_SESSION['departamento'] = $row['departamento'];
                echo $_SESSION['ususario'], $_SESSION['nombre'], $_SESSION['apellidoP'], $_SESSION['apellidoM'], $_SESSION['puesto'], $_SESSION['departamento'];
                header('location:registro.php');
            } else {
                header("location: index.php");
            }
        } else {
            header("location: index.php");
        }
    }
} else {
    header("location: index.php");
}


/*$usuario = $_POST['user'];
    $pasword = $_POST['password'];
    //1.- primero se hace el query
    $query = "select*From evidencia where nombre = '$nombre'";
    //2.-optenemos los resultados 
    $result = mysqli_query($con, $query);*/
