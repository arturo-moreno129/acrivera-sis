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
        <!--<div class="status">
            <div class="label link"><a href="mantenimientos" style="text-decoration: none; color:white;">VER LISTADO DE MANTENIMEINTOS</a></div>
        </div>-->
        <div class="status">
            <div class="label">
                <p>Para crear un evento, haga click en la fecha y llene los campos requeridos.</p>
            </div>
        </div>
        <div class="status">
            <div class="label">
                <p>Para compartir un evento, haga click en él y seleccione "Compartir".</p>
            </div>
        </div>
        <div class="status">
            <div class="label">
                <p>Para visualizar más información del evento, deje el cursor sobre él.</p>
            </div>
        </div>
        <div class="status">
            <div class="label">
                <p>Para cambiar de fecha un evento, arrastre y suelte el evento en la nueva fecha.</p>
            </div>
        </div>

    </div>
    <div id='calendar'></div>
</div>

<!--<div id='calendar'></div>-->


<?php include("footer.php") ?>