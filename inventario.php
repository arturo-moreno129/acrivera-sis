<?php
include 'header.php';
?>
<div class="cabecera">
    <h1>Camiones Rivera</h1>
    <h1>Automoviles y Camiones Rivera</h1>
</div>
<h2 id="filtrado">Filtrar por:</h2>

<select id="mySelectorInventario" class="form-control">
    <option value="">SELECCIONA FILTRO DE BÚSQUEDA</option>
    <option value="0">USUARIO</option>
    <option value="1">EQUIPO</option>
    <option value="2">MODELO</option>
    <option value="3">MARCA</option>
    <option value="4">NO. SERIE</option>
    <option value="5">HOST</option>
    <option value="6">DEPARTAMENTO</option>
    <option value="7">UBICACION</option>
</select>

<center><input style="display: none;" type="text" name="nombre" id="input-search-inentario" onkeyup="myFunction1('myTablaInventario', 'mySelectorInventario', 'input-search-inentario')" placeholder="Ingresa el dato a buscar"></center><br>
<!--se ejecintan en el moduoo scriptPopUp.js-->
<?php if ($_SESSION['rol'] == 1): ?>
    <center><img id="btnAddinventario" src="imagenes/agregar.png" alt="" style="width: 100px; cursor:pointer"><br><br></center>
<?php endif; ?>
<center><input id="btnExportinventario" type="submit" value="Exportar a excel"></center>
<!------------------------------------------------>

<table id="myTablaInventario">
    <thead>
        <tr><!--th para encabezados-->
            <th>USUARIO</th>
            <th style="text-align: center;">EQUIPO</th>
            <th style="text-align: center;">MODELO</th>
            <th style="text-align: center;">MARCA</th>
            <th style="text-align: center;">NO. SERIE</th>
            <th style="text-align: center;">HOST</th>
            <th style="text-align: center;">DEPARTAMENTO</th>
            <th style="text-align: center;">UBICACION</th>
            <th style="text-align: center;">ESTATUS</th>
            <th style="text-align: center;">EDITAR</th>
        </tr>
        <thead>
        <tbody>
            <?php
            $query = "select * From inventario where estatus = 1"; //where nombre = '$nombre'";
            $result = mysqli_query($con, $query);
            if ($row = mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo
                    '<tr>
                        <td>' . $row["usuario_asignado"] . '</td>
                        <td>' . $row["tipo_equipo"] . '</td>
                        <td>' . $row["modelo"] . '</td>
                        <td>' . $row["marca"] . '</td>
                        <td>' . $row["no_serie"] . '</td>
                        <td>' . $row["nom_host"] . '</td>
                        <td>' . $row["departamento"] . '</td>
                        <td>' . $row["Ubicacion"] . '</td>
                        <td>' . (($row['estatus'] == 1) ? '<img id="pdf-icon" src="imagenes/chek.png" alt="" style="width: 35px;">' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') . '</td>';
                    if ($_SESSION['rol'] == 1) {
                        echo '<td> <a href="#" style="pointer-events:auto" rel="noopener noreferrer">
                                    <img value="' . $row['id_inventario'] . '" class="btnPopUpInventario" src="imagenes/edit.png" alt="" style="width: 35px;">
                               </a>
                          </td>';
                    }
                    echo '</tr>';
                }
            } else {
                $_SESSION["alert"] = "No se encontro el suaurio";
            }
            //echo strtoupper($nombre) 
            ?>
        </tbody>
</table>
<script src="js/scriptPopUp.js"></script>
<script>
    const selectOption = document.querySelector("#mySelectorInventario");
    if (selectOption) {
        selectOption.addEventListener('change', () => {
            let flag = selectOption.value;
            const inputbuscar = document.querySelector('#input-search-inentario');
            (flag == '') ? inputbuscar.style.display = 'none': inputbuscar.style.display = 'block';

        })
    }
</script>
<?php
include 'footer.php';
?>