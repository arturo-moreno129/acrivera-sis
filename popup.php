<?php
// mi_pagina.php
include("conexion.php");

// Obtener el ID del evento desde window.open
$id = $_GET['id'] ?? null;

// Consultar datos
$evento = null;

if ($id) {
    $sql = $con->query("SELECT * FROM mantenimientos WHERE id_mantenimiento = $id LIMIT 1");
    $evento = $sql->fetch_assoc();
}

// Variables seguras para evitar errores
$usuario = $evento['usuario_final'] ?? "Evento";
$hora   = $evento['horaInicio'] ?? "00:00";
$hora_formateada = date("g:i a", strtotime($hora));
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evento Próximo</title>
    <audio id="alarma" autoplay>
        <source src="audios/pikachu-pikachu meloboom.mp3" type="audio/mpeg">
    </audio>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f2f2f2;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal {
            background: #fff;
            width: 90%;
            max-width: 500px;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            animation: pop 0.3s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            border-radius: 50%;
            border: 4px solid #f5b97a;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f5b97a;
            font-size: 42px;
            font-weight: bold;
        }

        h2 {
            margin: 10px 0;
            font-size: 26px;
            color: #444;
        }

        .emoji {
            font-size: 28px;
            margin-right: 5px;
        }

        p {
            color: #444;
            font-size: 17px;
        }

        .btn {
            margin-top: 15px;
            background: #6f4cff;
            border: none;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background: #5a3bd6;
        }
    </style>

</head>

<body>

    <div id="modalEvento" class="overlay">
        <div class="modal">
            <div class="icon-circle">!</div>

            <h2><span class="emoji">⏰</span>¡Evento próximo!</h2>

            <p>
                El evento <b><?= $usuario ?></b> está por comenzar a las
                <b><?= $hora_formateada ?></b>
            </p>

            <button class="btn" onclick="window.close()">Entendido</button>
        </div>
    </div>

</body>

</html>
<script>
    const audio = document.getElementById("alarma");

    // Reproducir en bucle (si lo quieres solo una vez, elimina esta línea)
    audio.loop = true;

    // Forzar reproducción en caso de que algunos navegadores bloqueen autoplay
    document.addEventListener("DOMContentLoaded", () => {
        audio.volume = 1.0; // máximo volumen
        audio.play().catch(e => {
            console.log("Autoplay bloqueado, intentando forzar...", e);

            setTimeout(() => {
                audio.play();
            }, 500);
        });
    });
</script>