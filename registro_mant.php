<?php
include 'header.php';
?>

<div class="contenedor-form">
    <center>
        <h2 style="color: black;"><strong>REGISTRO MANTENIMIENTO</strong></h2><br>
    </center>
    <form action="create_mante.php" method="POST"><!--create_registre.php va esto puse firma.php para pruebas-->

        <label class="display-info" for="lname" style="display: block;">Asociar con archivo registro</label><br>
        <input type="radio" name="option_1" id=""  value = "1" checked>Asociar
        <input type="radio" name="option_1" id=""  value="2" >No Asociar <br><br>
        <select name="doc-resg" id="" class="asociar">
            <option value="">---SELCCIONA EL DOCUMENTO---</option>
            <?php 
                $query_report = "SELECT * FROM evidencia WHERE estatus = 0 and url_mantenimiento is null";
                $result_consulta = mysqli_query($con,$query_report);
                while($row_report = mysqli_fetch_array($result_consulta)){
                    echo '<option value="'.$row_report['id_evidencia'].'">Nombre: '.$row_report['nombre'].' Fecha: '.$row_report['fecha'].' Dispositivo: '.$row_report['dispositivo'].'</option>';
                }
            ?>
        </select>


        <label class="no-asociar" for="fname" style="display: none;">Nombre(s)</label>
        <input class="no-asociar" type="text" id="fname" name="firstname" placeholder="Nombre"
            onkeyup="this.value = this.value.toUpperCase();" autofocus style="display: none;">
        <label class="no-asociar" for="lname" style="display: none;">Apellido Paterno</label>
        <input class="no-asociar" type="text" id="lname" name="lastname" placeholder="Apellido Paterno"
            onkeyup="this.value = this.value.toUpperCase();" style="display: none;">
        <label class="no-asociar" for="fname" style="display: none;">Apelldio Materno</label>
        <input class="no-asociar" type="text" id="fname" name="surname" placeholder="Apellido Materno"
            onkeyup="this.value = this.value.toUpperCase();" style="display: none;">
        <label class="display-info" for="lname" style="display: block;">Dispositivo</label>
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
        <!--puesto-->
        <label class="#" for="fpuesto" style="display: block;">Puesto</label>
        <input class="#" type="text" id="fpuesto" name="puesto" placeholder="Puesto del usuario"
            style="display: block;">
        <!--numero de serie-->
        <label class="#" for="Nserie" style="display: block;">No. serie</label>
        <input class="#" type="text" id="Nserie" name="Nserie" placeholder="Numero de serie del PC"
            onkeyup="this.value = this.value.toUpperCase();" style="display: block;">
        <!-- CAPACIDAD DISCO-->
        <label class="#" for="disco" style="display: block;">Capacidad de disco:</label>
        <input type="number" name="disco" id="" min="0">GB <br><br>
        <!-- CAPACIDAD MEMORIA-->
        <label class="#" for="memoria" style="display: block;">Capacidad de memoria:</label>
        <input type="number" name="memoria" id="" min="0">GB <br><br>

        <table><!-- TIPO DE MANTENIMIENTO-->
            <thead>
                <tr>
                    <th>Tipo de mantenimiento</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Programado</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-programado" name="option"
                            value="Programado" checked></td>
                </tr>
                <tr>
                    <td><label for="css">Solicitado</label><br></td>
                    <td style="text-align: center;"><input type="radio" id="swal-input-solicitado" name="option"
                            value="Solicitado"></td>
                </tr>
            </thead>
        </table>
        <!-- MANTENIMIENTO HARDWARE Y SOFTWARE-->
        <table>
            <thead>
                <tr>
                    <th>Mantenimiento de HW y SW</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Pantalla</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="pantalla" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Exterior teclado y ratón</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="ETR" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Interior / Exterior gabinete</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="IEG" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Arreglo cableado</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="AC" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Bloqueo de USB</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="BU" id=""></td>
                </tr>
                <tr>
                    <td><label for="css">Eliminación de cookies</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="EC" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Eliminación de temporales</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="ET" id=""></td>
                </tr>
                <!--<tr>
                    <td><label for="css">Borrar Archivos infectados</label><br></td>
                    <td><input type="checkbox" name="BAI" id=""></td>
                </tr>-->
            </thead>
        </table>
        <!-- RESPALDO Y DEPURACION-->
        <table>
            <thead>
                <tr>
                    <th>Respaldo Y depuracion</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Escritorio</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="DESK" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Mis documentos</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="FILE" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Favoritos</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="FAV" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Correo</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="MAIL" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Unidades de Disco</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="UNIDAD" id=""></td>
                </tr>
            </thead>
        </table>
        <!-- Aplicación de Actualizaciones:-->
        <table>
            <thead>
                <tr>
                    <th>Aplicación de Actualizaciones:</th>
                    <th style="text-align: center;">Check</th>
                </tr>
                <tr>
                    <td><label for="html">Sistema Operativo</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="SO" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Office</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="OFFICE" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Antivirus</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="AV" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Intelisis</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="INTELISIS" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Utilerías</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="UTIL" id=""></td>
                </tr>
                <tr>
                    <td><label for="html">Exploradores</label><br></td>
                    <td style="text-align: center;"><input type="checkbox" name="EXPLO" id=""></td>
                </tr>

            </thead>
        </table>



        <input type="submit" value="Enviar">
    </form>
</div>

<?php
include 'footer.php';
?>