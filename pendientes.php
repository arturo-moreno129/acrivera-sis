<?php include "header.php" ?>

<div class="titulo-pendiente">
    <h1>PENDIENTE POR FIRMA</h1>
</div>
<div class="container-options">
<a href="http://" style="text-decoration: none;" ></a>
    <?php
    $query_resguard = "SELECT * FROM bd_acrivera.evidencia WHERE id_evidencia = '{$_GET['id']}' and estatus = 0";
    $result = mysqli_query($con, $query_resguard);
    if (mysqli_num_rows($result) > 0) {
        echo '<a style="text-decoration: none" href="firma.php?id='.$_GET['id'].'&card=0" style="pointer-events:auto" rel="noopener noreferrer"><div class="card-option" id="firma-res" >
                <h1 style="color: black;">RESGUARDO</h1>
                <img src="imagenes/firma.png" style="width: 150px;" alt="">
                <!--<img src="imagenes/firma.png" style="width: 150px;" alt="">-->
            </div></a>';
    }
    ?>
    <?php
    $query_resguard = "SELECT * FROM bd_acrivera.evidencia WHERE id_evidencia = '{$_GET['id']}' and estatus_mant = 0";
    $result = mysqli_query($con, $query_resguard);
    if (mysqli_num_rows($result) > 0) {
        echo '<a style="text-decoration: none" href="firma.php?id='.$_GET['id'].'&card=1" style="pointer-events:auto" rel="noopener noreferrer"><div class="card-option" id="firma-mante">
                <h1 style="color: black;">MANTENIMIENTO</h1>
                <img src="imagenes/firma.png" style="width: 200px;" alt="">
                <!--<img src="imagenes/firma.png" style="width: 200px;" alt="">-->
            </div></a>';
    }
    ?>

</div>
<script src="js/card_option.js"></script>
<?php include "footer.php" ?>