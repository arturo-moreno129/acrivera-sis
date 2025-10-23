<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['ususario'])) {
    // Si no hay sesión, redirigir al login
    header('Location: index');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACRIVERA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./imagenes/logo_acr_black.png" type="image/x-icon" id="favicon">
    <script src='fullcalendar/packages/core/index.global.js'></script>
    <script src='fullcalendar/packages/core/locales/es.global.js'></script>
    <script src='fullcalendar/dist/index.global.min.js'></script>
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--Manifiest-->
    <link rel="manifest" href="json/app.webmanifest">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <!--++++++++++-->
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
                <?php if ($_SESSION['rol'] == 1): ?>
                    <li>
                        <a href="monitoreo_red">
                            <ion-icon name="radio-outline"></ion-icon>
                            <span>Monitoreo de Red</span>
                        </a>
                    </li>
                    <li>
                        <a href="internet">
                            <ion-icon name="qr-code-outline"></ion-icon>
                            <span>QR Internet</span>
                        </a>
                    </li>
                    <li>
                        <a href="consumibles">
                            <ion-icon name="flask-outline"></ion-icon>
                            <span>Consumibles</span>
                        </a>
                    </li>
                    <li>
                        <a href="altaUsuario">
                            <ion-icon name="person-add-outline"></ion-icon>
                            <span>Alta de Usuario</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="registro">
                            <ion-icon name="document-outline"></ion-icon>
                            <span>Registro</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="card_registro">
                            <ion-icon name="pencil-outline"></ion-icon>
                            <span>Registro</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="resguardos">
                            <ion-icon name="folder-outline"></ion-icon>
                            <span>Resguardos</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="calendario">
                            <ion-icon name="calendar-outline"></ion-icon>
                            <span>Calendario</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="directorio">
                            <ion-icon name="call-outline"></ion-icon>
                            <span>Directorio</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="inventario">
                            <ion-icon name="clipboard-outline"></ion-icon>
                            <span>inventario</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="descarga_apk">
                            <ion-icon src="icons/logo-google-playstore.svg"></ion-icon>
                            <span>Kigo App</span>
                        </a>
                    </li>
                <?php elseif ($_SESSION['rol'] == 2): ?>
                    <li>
                        <a href="directorio">
                            <ion-icon name="call-outline"></ion-icon>
                            <span>Directorio</span>
                        </a>
                    </li>
                    <li class="no-show">
                        <a href="calendario">
                            <ion-icon name="calendar-outline"></ion-icon>
                            <span>Calendario</span>
                        </a>
                    </li>
                    <!--<li>
                    <a href="#">
                        <ion-icon name="trash-outline"></ion-icon>
                        <span>Trash</span>
                    </a>
                </li>-->
                <?php endif; ?>
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
                    <a title="Cerrar Sesión" id="log-out" href="logout.php" style="text-decoration: none;"><ion-icon
                            name="log-out-outline"></ion-icon></a>
                </div>
            </div>
        </div>

    </div>

    <main>

        <header class="header-notificaciones">
            <div class="notificaciones-menu" id="notificacionesMenu">
                <ion-icon name="notifications-outline"></ion-icon>
                <span class="cantidad-notificaciones" id="cantidadNotificaciones">0</span>

                <!-- Contenedor de notificaciones -->
                <div class="lista-notificaciones" id="listaNotificaciones">
                    <!-- Notificaciones se cargan con JS -->
                </div>
            </div>
            <div class="usuario">
                José Arturo Moreno Aguilar
                <img src="imagenes/avatar_h.webp" alt="Foto de perfil" class="foto-perfil">
            </div>
        </header>

        <audio id="tonoNotificacion" src="audios/mariocoin.mp3" preload="auto"></audio>
        <!--<button onclick="reproducirTono()">Probar notificación</button>-->
        <?php
        //session_start();
        if (isset($_SESSION["alert"])) {
        ?>
            <div class=" alert alert-danger alert-dismissible fade show" role="alert" id="alertaa"
                style="background-color: rgba(149, 236, 149, 0.452);">
                <strong>¡<?php print $_SESSION['alert']; ?>!</strong>
                <a href="resguardos.php">¡Ir a la Sección de Resguardos!</a>
                <button type="button" class="close" aria-label="Cerrar"
                    onclick="document.getElementById('alertaa').style.display='none';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php
            unset($_SESSION["alert"]);
        }

        ?>

        <style>
            .header-notificaciones {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                padding: 10px 20px;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                gap: 20px;
                margin-bottom: 10px;
                border-radius: 30px;
            }

            .notificaciones-menu {
                position: relative;
                cursor: pointer;
                font-size: 24px;
                color: #333;
            }

            .cantidad-notificaciones {
                position: absolute;
                top: -5px;
                right: -10px;
                background-color: red;
                color: white;
                border-radius: 50%;
                padding: 2px 6px;
                font-size: 12px;
            }

            .lista-notificaciones {
                max-height: 0;
                overflow-y: auto;
                /* scroll vertical */
                position: absolute;
                top: 40px;
                right: 0;
                background-color: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
                min-width: 250px;
                z-index: 100;
                transition: max-height 0.3s ease, opacity 0.3s ease;
                opacity: 0;
            }

            .lista-notificaciones.show {
                max-height: 400px;
                opacity: 1;
            }

            .notificacion {
                display: block;
                /* ocupa toda la fila */
                padding: 10px;
                border-bottom: 1px solid #eee;
                cursor: pointer;
                font-size: 14px;
                color: #000;
                background-color: #fff;
                text-decoration: none;
            }

            .notificacion:last-child {
                border-bottom: none;
            }

            .notificacion:hover {
                background-color: #f9f9f9;
            }

            .notificacion.leida {
                color: #888;
            }

            .foto-perfil {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                object-fit: cover;
            }
        </style>

        <script>
            const notificacionesMenu = document.getElementById('notificacionesMenu');
            const listaNotificaciones = document.getElementById('listaNotificaciones');
            const cantidadNotificaciones = document.getElementById('cantidadNotificaciones');

            // Array de notificaciones con estado de lectura
            let notificaciones = [];

            // Función para actualizar el listado de notificaciones
            function actualizarNotificaciones() {
                listaNotificaciones.innerHTML = ''; // Limpiar
                const ultimas = notificaciones.slice(-5).reverse(); // Últimas 5

                ultimas.forEach((n) => {
                    const a = document.createElement('a');
                    a.href = n.url; // apuntar a la URL
                    a.classList.add('notificacion');
                    a.textContent = n.texto;
                    if (n.leida) a.classList.add('leida');
                    a.style.display = 'block';

                    // Evento click para marcar como leída Y actualizar base de datos
                    a.addEventListener('click', () => {
                        n.leida = true;
                        a.classList.add('leida');
                        actualizarContador();
                    });

                    listaNotificaciones.appendChild(a);
                });

                actualizarContador();
            }

            // Función para actualizar contador
            function actualizarContador() {
                const noLeidas = notificaciones.filter(n => !n.leida).length;
                cantidadNotificaciones.textContent = noLeidas;
            }

            // Inicializa
            actualizarNotificaciones();

            // Toggle dropdown
            notificacionesMenu.addEventListener('click', (e) => {
                e.stopPropagation();
                listaNotificaciones.classList.toggle('show');
            });

            // Cerrar al hacer clic fuera
            document.addEventListener('click', () => {
                listaNotificaciones.classList.remove('show');
            });

            // Simulación de nuevas notificaciones cada 5 segundos
            /*setInterval(() => {
                const nueva = {
                    texto: "Notificación nueva " + new Date().toLocaleTimeString(),
                    leida: false,
                    url: "calendario" // todas apuntan a calendario
                };
                notificaciones.push(nueva);
                actualizarNotificaciones();
            }, 5000);*/
        </script>