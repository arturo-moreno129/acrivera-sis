<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Semáforo de Red</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }
        #semaforo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 20px auto;
            background-color: gray;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .verde {
            background-color: #28a745;
            box-shadow: 0 0 20px #28a745;
        }
        .rojo {
            background-color: #dc3545;
            box-shadow: 0 0 20px #dc3545;
        }
    </style>
</head>
<body>
    <h1>Estado de la Unidad Compartida</h1>
    <div id="semaforo"></div>
    <p id="estado">Verificando...</p>

    <script>
        function verificarEstado() {
            fetch("verificar.php")
                .then(res => res.json())
                .then(data => {
                    const semaforo = document.getElementById("semaforo");
                    const estado = document.getElementById("estado");

                    if (data.activo) {
                        semaforo.className = "verde";
                        estado.innerText = "Unidad activa ✅";
                    } else {
                        semaforo.className = "rojo";
                        estado.innerText = "Unidad inactiva ❌";
                    }
                })
                .catch(err => {
                    console.error(err);
                });
        }

        // Ejecutar al cargar
        verificarEstado();
        // Repetir cada 10 segundos
        setInterval(verificarEstado, 10000);
    </script>
</body>
</html>
