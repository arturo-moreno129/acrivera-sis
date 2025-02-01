<?php include 'header.php' ?>
<div class="contenedor-form">
    <center>
        <h2 style="color: black;"><strong>REGISTRO MANTENIMIENTO</strong></h2><br>
    </center>
    <form action="create_mant.php" method="post" onsubmit="return validarFormulario(event)">
        <!-- evita conflicto con boton y subnit"-->
        <input type="radio" name="option" id="" value="1" checked>Asociar
        <input type="radio" name="option" id="" value="2">No Asociar <br><br>
        <label id="display-text-name" for="fname" style="display: block;" class="asociar">Asociar mantenimiento</label>
        <select name="" id="" class="asociar" required>
            <option value="">----ASOCIAR CON HOJA DE RESGUARDO----</option>
            <?php
            $query = "SELECT * FROM evidencia WHERE estatus = 0";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . htmlspecialchars($row["id_evidencia"]) . '">' . htmlspecialchars($row["nombre"]) . " Fecha: " . htmlspecialchars($row["fecha"]) . " Dispositivo: " . htmlspecialchars($row["dispositivo"]) . '</option>';

                }
            }
            ?>
        </select>

        <label for="" class="no-asociar" style="display: none;">Dispositivo resguardo</label>
        <select name="" id="" class="no-asociar" style="display: none;">
            <option value="">----SELECCIONA EL DISPOSITIVO----</option>
            <option value="">PC-COMPLETA</option>
            <option value="">LAPTOP</option>
            <option value="">TABLET</option>
            <option value="">IPAD</option>
        </select>

        <table><!-- EQUIPO EXTERNO O ACR-->
            <thead>
                <tr>
                    <th>Tipo de equipo</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Equipo ACR</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-programado" name="option1"
                            value="Equipo ACR" checked></td>
                </tr>
                <tr>
                    <td><label for="css">Equipo Externo</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-solicitado" name="option1"
                            value="Equipo Externo"></td>
                </tr>
            </thead>
        </table>

        <center>
            <h2 style="color: black;"><strong>REGISTRO DISPOSITIVOS</strong></h2><br>
        </center>

        <label for="CANTIDAD">CANTIDAD:</label>
        <input type="number" id="CANTIDAD" name="CANTIDAD[]" ><br><br>

        <label for="DESCRIPCION">DESCRIPCION:</label>
        <input type="text" id="DESCRIPCION" name="DESCRIPCION[]" onkeyup="this.value = this.value.toUpperCase();">

        <label for="MARCA">MARCA:</label>
        <input type="text" id="MARCA" name="MARCA[]" onkeyup="this.value = this.value.toUpperCase();">

        <label for="MODELO">MODELO:</label>
        <input type="text" id="MODELO" name="MODELO[]" onkeyup="this.value = this.value.toUpperCase();">

        <label for="SERIE">No. DE SERIE:</label>
        <input type="text" id="SERIE" name="SERIE[]" onkeyup="this.value = this.value.toUpperCase();">

        <label for="FISICO">INV. FISICO</label>
        <input type="text" id="FISICO" name="FISICO[]" onkeyup="this.value = this.value.toUpperCase();">
        <center>
        <button type="button" onclick="agregarFila()" id="btninsertTable" >Agregar</button><!--poner siempre que es de tipo button-->
        </center><br><br>

        <table id="tabla">
            <thead>
                <tr>
                    <th>CANTIDAD</th>
                    <th>DESCRIPCION</th>
                    <th>MARCA</th>
                    <th>MODELO</th>
                    <th>No. DE SERIE</th>
                    <th>Inv. Físico</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        

        <input type="submit" value="Enviar" id="btnenviar" >
    </form>
</div>
<?php include 'footer.php' ?>