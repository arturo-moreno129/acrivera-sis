<?php
include 'header.php'
?>
<!--<button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">INVENTARIO</button>
<button class="tablink" onclick="openPage('News', this, 'white')">IMPRESORAS</button>
<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->
<button class="tablink" onclick="openPage('About', this, 'white')" id="defaultOpen">PING</button>

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