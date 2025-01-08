<?php
include("header.php");
include("scriptCalendar.php");
?>
<!--CONTENEDOR DEL CALENDARIO-->

<div class="flex-box-calendar">
    <div class="container-calendar">
        <h1>ESTATUS</h1>
        <div class="status">
            <div class="circle green"></div>
            <div class="label">EN PROCESO</div>
        </div>
        <div class="status">
            <div class="circle red"></div>
            <div class="label">FINALIZADO</div>
        </div>
        <div class="status">
            <div class="label link"><a href="mantenimientos.php" style="text-decoration: none; color:white;">LISTADO DE MANTENIMEINTOS</a></div>
        </div>
        
    </div>
    <div id='calendar'></div>
</div>

<!--<div id='calendar'></div>-->


<?php include("footer.php") ?>