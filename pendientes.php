<?php include "header.php" ?>

<div class="titulo-pendiente">
    <h1>PENDIENTE POR FIRMA</h1>
</div>
<div class="container-options">
    <?php
    $query_resguard = "SELECT * FROM bd_acrivera.evidencia WHERE estatus = 0 and url_resguardo is not null";
    $result = mysqli_query($con, $query_resguard);
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="card-option" id="firma-res" >
                <h1 style="color: black;">RESGUARDO</h1>
                <img src="imagenes/firma.png" style="width: 150px;" alt="">
            </div>';
    }
    ?>
    <?php
    $query_resguard = "SELECT * FROM bd_acrivera.evidencia WHERE estatus_mant = 0 and url_mantenimiento is not null";
    $result = mysqli_query($con, $query_resguard);
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="card-option" id="firma-mante">
                <h1 style="color: black;">MANTENIMIENTO</h1>
                <img src="imagenes/firma.png" style="width: 200px;" alt="">
            </div>';
    }
    ?>

</div>
<script src="js/card_option.js"></script>
<?php include "footer.php" ?>