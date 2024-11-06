<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['ususario'])) {
    //echo "<h1>existe</h1>";
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACRIVERA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./imagenes/logo_acr_white.png" type="image/x-icon" id="favicon">
    <script src='fullcalendar/packages/core/index.global.js'></script>
    <script src='fullcalendar/packages/core/locales/es.global.js'></script>
    <script src='fullcalendar/dist/index.global.min.js'></script>
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">-->

</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <!--<ion-icon id="cloud" name="cloud-outline"></ion-icon>
                <span>Camiones Rivera</span>-->
                <img id="cloud" src="imagenes/logo.png" style="width: 150px;" alt="">
            </div>
        </div>

        <nav class="navegacion">
            <ul>
                <!--<li>
                    <a href="#">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Usuario</span>
                    </a>
                </li>-->
                <li>
                    <a href="registro.php">
                        <ion-icon name="document-outline"></ion-icon>
                        <span>Registro</span>
                    </a>
                </li>
                <li>
                    <a href="resguardos.php">
                        <ion-icon name="folder-outline"></ion-icon>
                        <span>Resguardos</span>
                    </a>
                </li>
                <li>
                    <a href="mantenimientos.php">
                        <ion-icon name="construct-outline"></ion-icon>
                        <span>Mantenimientos</span>
                    </a>
                </li>
                <!--<li>
                    <a href="#">
                        <ion-icon name="bookmark-outline"></ion-icon>
                        <span>Important</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Spam</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="trash-outline"></ion-icon>
                        <span>Trash</span>
                    </a>
                </li>-->
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Modo oscuro</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">

                        </div>
                    </div>
                </div>
            </div>

            <div class="usuario">
                <img src="imagenes/user.png" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre"><?php echo $_SESSION['ususario']; ?></span>
                        <span class="email"><?php echo $_SESSION['puesto']; ?></span>
                    </div>
                    <a title="Cerrar Sesión" id="log-out" href="logout.php" style="text-decoration: none;"><i class="fa-solid fa-right-from-bracket" style="cursor: pointer;"></i></a>
                </div>
            </div>
        </div>

    </div>
    <main>
        <?php
        //session_start();
        if (isset($_SESSION["alert"])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertaa" style="background-color: rgba(149, 236, 149, 0.452);">
                <strong>¡<?php print $_SESSION['alert']; ?>!</strong>
                <a href="resguardos.php">¡Ir a la Sección de Resguardos!</a>
                <button type="button" class="close" aria-label="Cerrar" onclick="document.getElementById('alertaa').style.display='none';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php
            unset($_SESSION["alert"]);
        }

        ?>