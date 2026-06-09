<?php
include 'header.php'
?>
<div class="tablinks-wrapper">
  <button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">INVENTARIO</button>
  <button class="tablink" onclick="openPage('News', this, 'white')">DASHBOARD</button>
</div>
<!--<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->
<!--<button class="tablink" onclick="openPage('About', this, 'white')" id="defaultOpen">PING</button>-->

<div id="Home" class="tabcontent">
  <div class="container1">
    <?php
    $query = "SELECT * from impresoras as i inner join consumibles as c on i.id_consumible = c.id_consumible ORDER BY i.id_impresora ASC;";
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
          data_direccion_ip="<?php echo $row['direccion_ip']; ?>"
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
            <span class="label1"><ion-icon name="cellular-outline"></ion-icon> Dirección IP:</span>
            <span class="value1"><?php echo $row['direccion_ip']; ?></span>
          </div>
          <div class="info1">
            <span class="label1"><ion-icon name="color-fill-outline"></ion-icon> Tóner:</span>
            <span class="value1"><?php echo $row['nombre']; ?></span>
          </div>
          <div class="info1">
            <span style="color: <?php echo ($row['cantidad_disponible'] == 0) ? 'red' : ''; ?>;" class="label1"><ion-icon name="cube-outline"></ion-icon> Consumibles disponibles:</span>
            <span class="value1"><?php echo $row['cantidad_disponible']; ?> pz</span>
          </div>
          <div style="display:flex; justify-content:flex-end; margin-top:8px;">
            <button class="edit-btn" data-id-impresora="<?php echo $row['id_impresora']; ?>" data-id-consumible="<?php echo $row['id_consumible']; ?>">Editar</button>
            <button class="update-consumibles" style="margin-left:8px;" data-id-impresora="<?php echo $row['id_impresora']; ?>" data-id-consumible="<?php echo $row['id_consumible']; ?>">Actualizar consumibles</button>
          </div>
          
        </div>
    <?php
      } // while
    } // if
    ?>
    <script src="js/scriptPopUp.js"></script>
    <!-- Modal de edición -->
    <div id="editModal" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Editar impresora / consumible</h2>
        <form id="editForm">
          <input type="hidden" name="id_impresora" id="id_impresora">
          <input type="hidden" name="id_consumible" id="id_consumible">
          <label>Ubicación</label>
          <input type="text" name="ubicacion" id="ubicacion">
          <label>Marca</label>
          <input type="text" name="marca" id="marca">
          <label>Número de serie</label>
          <input type="text" name="no_serie" id="no_serie">
          <label>Modelo</label>
          <input type="text" name="modelo" id="modelo">
          <label>Tóner (nombre)</label>
          <input type="text" name="nombre" id="nombre">
          <label>Cantidad disponible</label>
          <input type="number" name="cantidad_disponible" id="cantidad_disponible" min="0">
          <div style="margin-top:12px; text-align:right;">
            <button type="submit" id="saveEdit">Guardar</button>
          </div>
        </form>
      </div>
    </div>
    <script src="js/consumibles_edit.js"></script>
  </div>
</div>

<div id="News" class="tabcontent">

</div>

<div id="About" class="tabcontent">

</div>
<?php
include 'footer.php'
?>