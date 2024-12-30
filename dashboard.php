<?php
include 'header.php'
?>
<button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">Inventario</button>
<!--<button class="tablink" onclick="openPage('News', this, 'white')">News</button>
<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->
<button class="tablink" onclick="openPage('About', this, 'white')">PING</button>

<div id="Home" class="tabcontent">
  <div class="container">
    <?php
    $myarray = ["TORRE DE CONTROL", 
                "RECEPCIÓN", 
                "VENTAS AFUERA", 
                "VENTAS ADENTRO",
                "RECURSOS HUMANOS",
                "CONTABILIDAD",
                "COMPRAS",
                "RECEPCIÓN",
                "GARANTÍAS",
                "ALMACÉN",
                "SERVICIO",
                "HOJALATERIA Y PINTURA"
              ];
    for ($i = 0; $i < count($myarray); $i++) {

    ?>
      <div class="card" style="cursor: pointer;">
        <center><img src="imagenes/toner.png" alt="Avatar" ></center>
        <div class="container">
          <h4><b><?php echo $myarray[$i]; ?></b><br</h4>
          <p>existencias: 80pz</p>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>

<div id="News" class="tabcontent">
  <div>
    <canvas id="myChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['FALTANTES', 'SOBRANTES', 'CORRECTOS'],
        datasets: [{
          label: 'cantidad',
          data: [12, 19, 30],
          borderWidth: 1,
        }]
      },
      options: {
        aspectRatio: 3.0,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</div>

<div id="Contact" class="tabcontent">
  <div id="myChart1"></div>
</div>

<script>
  var options = {
    series: [44, 55, 13, 43, 22],
    chart: {
      width: 380,
      type: 'pie',
    },
    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  };

  var chart = new ApexCharts(document.querySelector("#myChart1"), options);
  chart.render();
</script>


<div id="About" class="tabcontent">
  <?php include 'ip.php' ?>
</div>

<?php
include 'footer.php'
?>
