<?php
include 'header.php'
?>
<button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">INVENTARIO</button>
<button class="tablink" onclick="openPage('News', this, 'white')">IMPRESORAS</button>
<!--<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->
<button class="tablink" onclick="openPage('About', this, 'white')">PING</button>

<div id="Home" class="tabcontent">
  <div class="container">
    <?php
    $myarray = [
      "TORRE DE CONTROL",
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
        <center><img src="imagenes/toner.png" alt="Avatar"></center>
        <div class="container">
          <h4><b><?php echo $myarray[$i]; ?></b>
            <br< /h4>
              <p>existencias: 80pz</p>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>

<div id="News" class="tabcontent">

  <center><img id="btnAdd" src="imagenes/agregar.png" alt="" style="width: 100px; cursor:pointer"><br><br></center>
  <table id="myTableResguardo">
    <thead>
      <tr><!--th para encabezados-->
        <th style="text-align: center;">UBICACION</th>
        <th style="text-align: center;">MARCA</th>
        <th style="text-align: center;">DIRECCION IP</th>
        <th style="text-align: center;">DIRECCION MAC</th>
        <th style="text-align: center;">CONTRASEÑA</th>
        <th style="text-align: center;">VER CONTRASEÑA</th>
      </tr>
      <thead>
      <tbody>
        <?php
        $query = "SELECT * FROM impresoras";
        $result  = mysqli_query($con, $query);
        if ($row = mysqli_num_rows($result) > 0) {
          # code...
          while ($row = mysqli_fetch_array($result)) {
            echo '<tr><!--th para encabezados-->
                    <td>' . $row['ubicacion'] . '</td>
                    <td style="text-align: center;">' . $row['marca'] . '</td>
                    <td style="text-align: center;">' . $row['direccion_ip'] . '</td>
                    <td style="text-align: center;">' . $row['direccion_mac'] . '</td>
                    <td style="text-align: center;"><input type="password" name="" value=' . $row['contrasena'] . ' readonly></td>
                    <td style="text-align: center;"> <a href="#" style="pointer-events:auto" rel="noopener noreferrer">
                          <img value="' . $row['id_impresora'] . '" class="btnPopUp2" id="impresoras" src="imagenes/mostrar.png" alt="" style="width: 35px;">
                        </a>
                    </td>
                  </tr>';
          }
        }
        ?>
      </tbody>
  </table>
  <script src="js/scriptPopUp.js"></script>
</div>

<div id="Contact" class="tabcontent">
  <div id="myChart1"></div>
</div>

<!--<script>
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
</script>-->


<div id="About" class="tabcontent">
  <div class="wifi">
    <div class="online-msg"></div>
    <div class="offline-msg"></div>
  </div>
  <?php include 'ip.php' ?>
</div>

<?php
include 'footer.php'
?>