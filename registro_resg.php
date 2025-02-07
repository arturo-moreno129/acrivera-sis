<?php include 'header.php' ?>
<div class="contenedor-form">
    <center>
        <h2 style="color: black;"><strong>REGISTRO REGUARDO</strong></h2><br>
    </center>
    <form action="create_registro.php" method="post" onsubmit="return validarFormulario(event)">
        <label id="display-text-name" for="fname" style="display: block;">Selecciona el ususario:(Si no encuentra el
            usuario, diríjase al apartado de "Nuevo Usuario" y seleccione la casilla)</label><br>
        <input type="checkbox" id="check-newUser" onclick="newUser()"><label for="" style="color: red;">NUEVO
            USUARIO</label><br>
        <select name="select-user" id="select-user" required>
            <option value="">--SELECCIONA EL USUARIO--</option> <!-- el valor antes era asi=>value = "0"-->
            <?php

            $query = "SELECT DISTINCT nombre FROM evidencia ORDER BY nombre";
            $result = mysqli_query($con, $query); //esto me regresu los renglones de la consulta
            if ($row = mysqli_num_rows($result) > 0) { //comprovamos si nos devuelve la consulta
                # code...
                while ($row = mysqli_fetch_array($result)) { //recorremos lo que se almaceno
                    # code...
                    echo '<option value="' . htmlspecialchars($row["nombre"]) . '">' . htmlspecialchars($row["nombre"]) . '</option>';
                }
            }
            ?>
        </select>

        <label class="display-info" for="fname" style="display: none;">Nombre(s)</label>
        <input class="display-info" type="text" id="fname" name="firstname" placeholder="Nombre"
            onkeyup="this.value = this.value.toUpperCase();" autofocus style="display: none;">
        <label class="display-info" for="lname" style="display: none;">Apellido Paterno</label>
        <input class="display-info" type="text" id="lname" name="lastname" placeholder="Apellido Paterno"
            onkeyup="this.value = this.value.toUpperCase();" style="display: none;">
        <label class="display-info" for="fname" style="display: none;">Apelldio Materno</label>
        <input class="display-info" type="text" id="fname" name="surname" placeholder="Apellido Materno"
            onkeyup="this.value = this.value.toUpperCase();" style="display: none;">

        <label class="display-info-1" for="fname" style="display: block;">Puesto</label>
        <input class="display-info-1" type="text" id="fpuesto" name="puesto" placeholder="Puesto"
            onkeyup="this.value = this.value.toUpperCase();" autofocus style="display: block;">

        <label class="display-info-1" for="lname" style="display: block;">Dispositivo</label>
        <select id="#" class="form-control" name="dispositivo" required>
            <option value="">--SELECCIONA EL DISPOSITIVO--</option>
            <option value="PC-COMPLETA">PC-COMPLETA</option>
            <option value="TABLET">TABLET</option>
            <option value="IPAD">IPAD</option>
            <option value="LAPTOP">LAPTOP</option>
            <option value="MOUSE">MOUSE</option>
            <option value="COMBO T/M">COMBO T/M</option>
            <option value="UPS">UPS</option>
            <option value="LLAVE">LLAVE</option>
            <option value="OTRO">OTRO</option>
        </select>
        <!--<input type="text" id="lname" name="device" placeholder="Dispositivo" onkeyup="this.value = this.value.toUpperCase();" required><br>-->
        <p>Fecha de registro: <input type="date" name="fecha-registro" id="" required></p><br>

        <table><!-- EQUIPO EXTERNO O ACR-->
            <thead>
                <tr>
                    <th>Tipo de equipo</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Equipo ACR</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-programado" name="option1"
                            value="1" checked></td>
                </tr>
                <tr>
                    <td><label for="css">Equipo Externo</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-solicitado" name="option1"
                            value="2"></td>
                </tr>
            </thead>
        </table>

        <center>
            <h2 style="color: black;"><strong>REGISTRO DISPOSITIVOS</strong></h2><br>
        </center>

        <label for="CANTIDAD">CANTIDAD:</label>
        <input type="number" id="CANTIDAD" name="CANTIDAD[]"><br><br>

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
            <button type="button" onclick="agregarFila()"
                id="btninsertTable">Agregar</button><!--poner siempre que es de tipo button-->
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



        <input type="submit" value="Enviar" id="btnenviar">
    </form>
</div>
<?php include 'footer.php' ?>