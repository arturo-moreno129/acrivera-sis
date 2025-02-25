<?php include 'header.php' ?>
<div class="contenedor-form">
    <center>
        <h2 style="color: black;"><strong>REPARACION</strong></h2><br>
    </center>
    <form id="formulario" action="#" method="post">
        <label for="">Dispositivo:</label>
        <input id="inputdispo" type="text" placeholder="DISPOSITIVO" required>
        <label for="">Solicitante:</label>
        <input id="inputsolicita" type="text" placeholder="SOLICITANTE" required>
        <label for="">Problematica:</label><br><br>
        <textarea name="" id="inputdescrip" style="width: 100%; height:100px; padding:15px; resize: none;" required></textarea>

        <input type="submit" value="Enviar" id="btnCreateRepa">
    </form>
</div>
<?php include 'footer.php' ?>