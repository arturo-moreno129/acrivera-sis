<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Monitor</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .chart-container { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Web Monitor - Ping en Tiempo Real</h1>
    <form id="pingForm">
        <label for="hosts">Direcciones IP/Dominios (separados por comas):</label>
        <input type="text" id="hosts" name="hosts" placeholder="e.g., 8.8.8.8, example.com" required>
        <button type="submit">Iniciar Monitoreo</button>
    </form>

    <div id="charts" class="chart-container"></div>

    <script>
        
        document.getElementById("pingForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const hosts = document.getElementById("hosts").value.split(",").map(h => h.trim());
            startMonitoring(hosts);
        });

        const charts = {}; // Almacena los gráficos para cada host

        function startMonitoring(hosts) {
            const chartContainer = document.getElementById("charts");
            chartContainer.innerHTML = ""; // Limpiar gráficos previos

            hosts.forEach(host => {
                // Crear un contenedor para el gráfico
                const canvasContainer = document.createElement("div");
                canvasContainer.innerHTML = `
                    <h3>${host}</h3>
                    <canvas id="chart-${host}" width="400" height="200"></canvas>
                `;
                chartContainer.appendChild(canvasContainer);

                // Configurar el gráfico para este host
                const ctx = document.getElementById(`chart-${host}`).getContext("2d");
                charts[host] = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: [], // Tiempos
                        datasets: [{
                            label: `Tiempo de respuesta (ms) - ${host}`,
                            data: [],
                            borderColor: "blue",
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: { title: { display: true, text: "Tiempo" } },
                            y: { title: { display: true, text: "ms" }, beginAtZero: true },
                        }
                    }
                });

                // Iniciar el monitoreo para este host
                setInterval(() => pingHost(host), 3000); // Ping cada 5 segundos
            });
        }

        function pingHost(host) {
            fetch(`ping.php?host=${encodeURIComponent(host)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success" && data.time !== null) {
                        const chart = charts[host];
                        const time = new Date().toLocaleTimeString();

                        // Agregar datos al gráfico
                        chart.data.labels.push(time);
                        chart.data.datasets[0].data.push(parseFloat(data.time));

                        // Limitar el número de puntos en el gráfico
                        if (chart.data.labels.length > 20) {
                            chart.data.labels.shift();
                            chart.data.datasets[0].data.shift();
                        }

                        chart.update();
                    }
                })
                .catch(error => console.error(`Error al hacer ping a ${host}:`, error));
        }
    </script>
</body>
</html>
