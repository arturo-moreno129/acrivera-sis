<?php
//include "header.php"
?>


<div id="charts" class="container"></div>

<script>
    /*document.getElementById("pingForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const hosts = document.getElementById("hosts").value.split(",").map(h => h.trim());
            startMonitoring(hosts);
        });*/

    document.addEventListener("DOMContentLoaded", function() {
        const defaultHosts = "140.240.13.133,140.240.13.131,140.240.13.230,140.240.13.233";
        const hosts = defaultHosts.split(",").map(h => h.trim());
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

                       <div class="card-ip" style="cursor: pointer;">
                        <canvas id="chart-${host}" ></canvas>
                       </div> 
                    
                    
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
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "Tiempo"
                            },

                        },
                        y: {
                            title: {
                                display: true,
                                text: "ms"
                            },
                            //beginAtZero: true
                        },
                    }
                }
            });

            // Iniciar el monitoreo para este host
            setInterval(() => pingHost(host), 2500); // Ping cada 5 segundos
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
                    if (chart.data.labels.length > 30) {
                        chart.data.labels.shift();
                        chart.data.datasets[0].data.shift();
                    }

                    chart.update();
                }
            })
            .catch(error => console.error(`Error al hacer ping a ${host}:`, error));
    }
</script>
<?php
//include "footer.php"
?>