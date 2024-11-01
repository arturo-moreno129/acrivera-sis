<?php include 'header.php'; ?>
<div class="contenedor-form"><!--para que pueda subir multiples archivos: enctype=multipart/form-data-->
    <form action="upload.php" method="POST" enctype=multipart/form-data>
        <label for="fname">Nombre(s)</label>
        <input type="text" id="fname" name="firstname" placeholder="Nombre" onkeyup="this.value = this.value.toUpperCase();" required>
        <label for="lname">Apellido Paterno</label>
        <input type="text" id="lname" name="lastname" placeholder="Apellido Paterno" onkeyup="this.value = this.value.toUpperCase();" required>
        <label for="fname">Apelldio Materno</label>
        <input type="text" id="fname" name="surname" placeholder="Apellido Materno" onkeyup="this.value = this.value.toUpperCase();" required>
        <label for="lname">Dispositivo</label>
        <input type="text" id="lname" name="device" placeholder="Dispositivo" onkeyup="this.value = this.value.toUpperCase();" required><br>
        <p>Fecha de registro: <input type="date" name="fecha-registro" id="" required></p><br>
        <label for="myCheck">Resguardo:</label>
        <input type="checkbox" id="myCheck1" onclick="myFunction('mostrar1','myCheck1','file')">
        <p style="display:none" id="mostrar1">Subir registro: <input type="file" name="file" id="file" accept=".pdf" ></p><br>
        
        <label for="myCheck">Mantenimiento:</label>
        <input type="checkbox" id="myCheck2" onclick="myFunction('mostrar2','myCheck2','file1')">
        <p style="display:none" id="mostrar2">Subir mantenimiento: <input type="file" name="file1" id="file1" accept=".pdf" ></p><br>
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