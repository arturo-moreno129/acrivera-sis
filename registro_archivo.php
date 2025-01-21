<?php
include 'header.php';
?>

<div class="contenedor-form">
    <center>
        <h2 style="color: black;"><strong>REGISTRO MANTENIMIENTO</strong></h2><br>
    </center>
    <form action="create_registre.php" method="POST">
        <label id="display-text-name" for="fname" style="display: block;">Selecciona el ususario:(Si no encuentra el usuario, diríjase al apartado de "Nuevo Usuario" y seleccione la casilla)</label><br>
        <input type="checkbox" id="check-newUser" onclick="newUser()"><label for="" style="color: red;">NUEVO USUARIO</label><br>
        <select name="select-user" id="select-user">
            <option value="0">--SELECCIONA EL USUARIO--</option>
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
        <input class="display-info" type="text" id="fname" name="firstname" placeholder="Nombre" onkeyup="this.value = this.value.toUpperCase();" autofocus style="display: none;">
        <label class="display-info" for="lname" style="display: none;">Apellido Paterno</label>
        <input class="display-info" type="text" id="lname" name="lastname" placeholder="Apellido Paterno" onkeyup="this.value = this.value.toUpperCase();" style="display: none;">
        <label class="display-info" for="fname" style="display: none;">Apelldio Materno</label>
        <input class="display-info" type="text" id="fname" name="surname" placeholder="Apellido Materno" onkeyup="this.value = this.value.toUpperCase();" style="display: none;">
        <label class="display-info" for="lname" style="display: none;">Dispositivo</label>
        <select id="#" class="form-control" name="dispositivo" required>
            <option value="">--SELECCIONA EL DISPOSITIVO--</option>
            <option value="PC-COMPLETA">PC-COMPLETA</option>
            <option value="TABLET">TABLET</option>
            <option value="IPAD">IPAD</option>
            <option value="LAPTOP">LAPTOP</option>
            <option value="MOUSE">MOUSE</option>
            <option value="UPS">UPS</option>
            <option value="OTRO">OTRO</option>
        </select>
        <!--<input type="text" id="lname" name="device" placeholder="Dispositivo" onkeyup="this.value = this.value.toUpperCase();" required><br>-->
        <p>Fecha de registro: <input type="date" name="fecha-registro" id="" required></p><br>

        <table><!-- TIPO DE MANTENIMIENTO-->
            <thead>
                <tr>
                    <th>Tipo de mantenimiento</th>
                    <th>Check</th>
                </tr>
                <tr>
                    <td><label for="html">Programado</label><br></td>
                    <td><input type="radio" id="swal-input-programado" name="option" value="Programado" checked></td>
                </tr>
                <tr>
                    <td><label for="css">Solicitado</label><br></td>
                    <td><input type="radio" id="swal-input-solicitado" name="option" value="Solicitado"></td>
                </tr>
            </thead>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Mantenimiento de HW y SW</th>
                    <th>Check</th>
                </tr>
                <tr>
                    <td><label for="html">Pantalla</label><br></td>
                    <td><input type="checkbox" name="P" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Exterior teclado y ratón</label><br></td>
                    <td><input type="checkbox" name="ETR" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Interior / Exterior gabinete</label><br></td>
                    <td><input type="checkbox" name="IEG" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Arreglo cableado</label><br></td>
                    <td><input type="checkbox" name="AC" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Bloqueo de USB</label><br></td>
                    <td><input type="checkbox" name="BU" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Eliminación de cookies</label><br></td>
                    <td><input type="checkbox" name="EC" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Eliminación de temporales</label><br></td>
                    <td><input type="checkbox" name="ET" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Borrar Archivos infectados</label><br></td>
                    <td><input type="checkbox" name="BAI" id=""></td>
                </tr>
            </thead>
        </table>

        <input type="submit" value="Enviar">
    </form>
</div>

<?php
include 'footer.php';
?>