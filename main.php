<?php
include("conexion.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos.css">
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
                <img src="imagenes/logo.png" style="width: 150px;" alt="">
            </div>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a id="inbox" href="#">
                        <ion-icon name="document-outline"></ion-icon>
                        <span>Resguardos</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="build-outline"></ion-icon>
                        <span>Mantenimientos</span>
                    </a>
                </li>
                <!--<li>
                    <a href="#">
                        <ion-icon name="paper-plane-outline"></ion-icon>
                        <span>Sent</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span>Drafts</span>
                    </a>
                </li>
                <li>
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
                        <span class="nombre">Jhampier</span>
                        <span class="email">jhampier@gmail.com</span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>

    </div>


    <main>
        <div class="contnedor-buscador">
            <form action="main.php" id="form" method="post">
                <center>
                    <h1>BUSCADOR</h1>
                </center>
                <center><input type="text" name="nombre" id="input-search" placeholder="Ingresa el nombre a buscar"></center><br>
                <center><input type="submit" value="Buscar" id="input-button" style="cursor:pointer;"></center>
            </form>
        </div>
        <table>
            <thead>
                <tr><!--th para encabezados-->
                    <th>USUARIO</th>
                    <th style="text-align: center;">FECHA</th>
                    <th style="text-align: center;">DISPOSITIVO</th>
                    <th style="text-align: center;">PDF RESGUARDO</th>
                    <th style="text-align: center;">PDF MANTENIMEINTO</th>
                </tr>
                <thead>
                <tbody>
                    <?php if (isset($_POST['nombre']) && !empty($_POST['nombre'])): ?>
                        <?php
                        $nombre = strtoupper($_POST["nombre"]);
                        $url_files = strtr($nombre, " ", "_");
                        $new_url_files = "resguardos/" . $url_files . "/";
                        $query = "select*From evidencia where nombre = '$nombre'";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo
                                '<tr>
                        <td>' . $row["nombre"] . '</td>
                        <td style="text-align: center;">' . $row["fecha"] . '</td>
                        <td style="text-align: center;">' . $row["dispositivo"] . '</td>
                        <td style="text-align: center;">
                            <a href="' . $row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"><img id="pdf-icon" src="imagenes\pdf_img.png" alt="" style="width: 35px;"></a>
                        </td>
                        <td style="text-align: center;">
                            <a href="' . $new_url_files . $row["url_mantenimienti"] . '" target="_blank" rel="noopener noreferrer"><img id="pdf-icon" src="imagenes\pdf_img.png" alt="" style="width: 35px;></a>
                        </td>
                        <td>
                            <a href="load_img.php" target="_blank" value = "arturo" rel="noopener noreferrer"><img id="pdf-icon" src="imagenes\icon_img.png" alt=""></a>                    
                        </td>
                    </tr>';
                            }
                        }
                        //echo strtoupper($nombre) 
                        ?>
                    <?php endif; ?>
                </tbody>
        </table>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>

</html>