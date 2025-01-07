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
    var maximo = 0;
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

                       <div id = "${host}" class="card-ip" style="cursor: pointer;">
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
                        label: `Direccion IP - ${host}`,
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
            setInterval(() => pingHost(host), 2500); // Ping cada 2,5 segundos
        });
    }

    function pingHost(host) {

        fetch(`ping.php?host=${encodeURIComponent(host)}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") { //&& data.time !== null ->para cuando es por wifi
                    const chart = charts[host];
                    const time = new Date().toLocaleTimeString();
                    let dataTime = (data.time === null)?1: data.time;
                    //para hacer un sombreado cuando el ping sea muy alto***////
                    if (dataTime > 10) {
                        const card = document.getElementById(data.ip);
                        card.style.border = "solid 2px red"
                        //console.log(data.ip);
                    } else {
                        const card = document.getElementById(data.ip);
                        card.style.border = "none"
                    }
                    // Agregar datos al gráfico
                    chart.data.labels.push(time);
                    chart.data.datasets[0].data.push(parseFloat(dataTime));

                    // Limitar el número de puntos en el gráfico
                    if (chart.data.labels.length > 30) {
                        chart.data.labels.shift();
                        chart.data.datasets[0].data.shift();
                    }

                    chart.update();
                } else {
                    //console.warn(`No se pudo hacer ping a ${host}:`, data.message || "Sin detalles.");
                    /*const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: `Se perdio la conexion al host ${host}`
                    });*/
                }
            })
            .catch(error => console.log(console.error(`Error al hacer ping a ${host}:`, error)));
    }
</script>
<!--<script src="prueba.js"></script>-->
<?php
//include "footer.php"
?>