<?php
include 'header.php';
?>

<div id="Home" class="consumibles-box">
    <br>
    <center>
        <h1 id="impresora-title">Monitoreo de dispositivos en Red</h1>
    </center>
    <center>
        <div class="wifi">
            <div class="online-msg"></div>
            <div class="offline-msg"></div>
        </div>
        <?php include 'ip.php' ?>
    </center>
</div>
<script src="js/scriptPopUp.js"></script>
<?php
include 'footer.php';
?>