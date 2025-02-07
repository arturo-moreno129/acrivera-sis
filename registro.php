<?php include 'header.php'; ?>
<div class="contenedor-form"><!--para que pueda subir multiples archivos: enctype=multipart/form-data-->
    <form action="upload.php" method="POST" enctype=multipart/form-data>
        <label id = "display-text-name" for="fname" style="display: block;">Selecciona el ususario:(Si no encuentra el usuario, diríjase al apartado de "Nuevo Usuario" y seleccione la casilla)</label>
        <select name="select-user" id="select-user">
            <option value="0">--SELECCION--</option>
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
        <input type="checkbox" id="check-newUser" onclick="newUser()" ><label for="" style="color: red;">NUEVO USUARIO</label><br>
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
            <option value="COMBO T/M">COMBO T/M</option>
            <option value="UPS">UPS</option>
            <option value="LLAVE">LLAVE</option>
            <option value="OTRO">OTRO</option>
        </select>
        <!--<input type="text" id="lname" name="device" placeholder="Dispositivo" onkeyup="this.value = this.value.toUpperCase();" required><br>-->
        <p>Fecha de registro: <input type="date" name="fecha-registro" id="" required></p><br>
        <label for="myCheck">Resguardo:</label>
        <input type="checkbox" id="myCheck1" onclick="myFunction('mostrar1','myCheck1','file')">
        <p style="display:none" id="mostrar1">Subir registro: <input type="file" name="file" id="file" accept=".pdf"></p><br>

        <label for="myCheck">Mantenimiento:</label>
        <input type="checkbox" id="myCheck2" onclick="myFunction('mostrar2','myCheck2','file1')">
        <p style="display:none" id="mostrar2">Subir mantenimiento: <input type="file" name="file1" id="file1" accept=".pdf"></p><br>
        <!---------------------este es para subir multiples archivos-->
        <!--<p>Fecha de registro: <input type="date" name="" id=""> <input type="file" name="file[]" id="file[]" multiple></p>-->
        <!------------------------------------------------------------------------------------>


        <!--<label for="country">Country</label>
        <select id="country" name="country">
            <option value="australia">Australia</option>
            <option value="canada">Canada</option>
            <option value="usa">USA</option>
        </select>-->

        <input type="submit" value="Enviar">
    </form>
</div>

<?php include 'footer.php' ?>