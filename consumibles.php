<?php
include 'header.php'
?>
<button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">INVENTARIO</button>
<button class="tablink" onclick="openPage('News', this, 'white')">DASHBOARD</button>
<!--<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->
<!--<button class="tablink" onclick="openPage('About', this, 'white')" id="defaultOpen">PING</button>-->

<div id="Home" class="tabcontent">
  <div class="container1">
    <?php
    $query = "SELECT * from impresoras as i inner join consumibles as c on i.id_consumible = c.id_consumible;";
    $result  = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) { // ✅ corrección aquí
      while ($row = mysqli_fetch_array($result)) {
    ?>
        <div class="card1" style="cursor: pointer;"
          data_ubicacion="<?php echo $row['ubicacion']; ?>"
          data_no_serie="<?php echo $row['no_serie']; ?>"
          data_modelo="<?php echo $row['modelo']; ?>"
          data_id_consumible="<?php echo $row['id_consumible']; ?>"
          data_nombre="<?php echo $row['nombre']; ?>"
          data_cantidad_disponible="<?php echo $row['cantidad_disponible']; ?>"
          data_id_impresora="<?php echo $row['id_impresora']; ?>">
          <div class="card-header1">
            <ion-icon name="print-outline"></ion-icon>
            <h1 id="impresora-title">Impresora</h1>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="business-outline"></ion-icon> Área:</span>
            <span class="value1"><?php echo $row['ubicacion']; ?></span>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="business-outline"></ion-icon> Marca:</span>
            <span class="value1"><?php echo $row['marca']; ?></span>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="barcode-outline"></ion-icon> Número de serie:</span>
            <span class="value1"><?php echo $row['no_serie']; ?></span>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="hardware-chip-outline"></ion-icon> Modelo:</span>
            <span class="value1"><?php echo $row['modelo']; ?></span>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="color-fill-outline"></ion-icon> Tóner:</span>
            <span class="value1"><?php echo $row['nombre']; ?></span>
          </div>
          <div class="info1">
            <span style="color: <?php echo ($row['cantidad_disponible'] == 0) ? 'red' : ''; ?>;" class="label1"><ion-icon name="cube-outline"></ion-icon> Consumibles disponibles:</span>
            <span class="value1"><?php echo $row['cantidad_disponible']; ?> pz</span>
          </div>
        </div>
    <?php
      } // while
    } // if
    ?>
    <script src="js/scriptPopUp.js"></script>
  </div>
</div>

<div id="News" class="tabcontent">

</div>

<div id="About" class="tabcontent">

</div>
<?php
include 'footer.php'
?>