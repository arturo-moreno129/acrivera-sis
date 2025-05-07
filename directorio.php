<?php
include 'header.php';
?>
<div class="cabecera">
    <h1>Camiones Rivera</h1>
    <h1>Automoviles y Camiones Rivera</h1>
</div>
<h2 id="filtrado">Filtrar por:</h2>

<select id="mySelectDirectorio" class="form-control">
    <option value="">SELECCIONA FILTRO DE BÚSQUEDA</option>
    <option value="0">PERSONAL</option>
    <option value="1">PUESTO</option>
    <option value="2">CORREO CORPORATIVO</option>
    <option value="3">EXTENSION</option>
</select>

<center><input type="text" name="nombre" id="input-search-directorio" onkeyup="myFunction1('myTableDirectorio', 'mySelectDirectorio', 'input-search-directorio')" placeholder="Ingresa el nombre a buscar"></center><br>
<!--se ejecintan en el moduoo scriptPopUp.js-->
<center><img id="btnAdd" src="imagenes/agregar.png" alt="" style="width: 100px; cursor:pointer"><br><br></center>
<center><input id="btnExport"type="submit" value="Exportar a excel"></center>
<!------------------------------------------------>

<table id="myTableDirectorio">
    <thead>
        <tr>
            <th>PERSONAL</th>
            <th style="text-align: center;">PUESTO</th>
            <th style="text-align: center;">CORREO CORPORATIVO</th>
            <th style="text-align: center;">EXTENSION</th>
            <th style="text-align: center;">EDITAR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM directorio WHERE ESTATUS = 1 ORDER BY FIELD(area, 'DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN','SA','SAT','ST')";
        $result = mysqli_query($con, $query);

        $arrayAreas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN','SA','SAT','ST'];
        $arrayNombres = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos','Sucursal Apizaco','Sucursal Alliance Tehuacán','Sucursal Teziutlán'];

        $area_actual = null;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                // Si el área cambia, imprimimos el encabezado de área
                if ($row['area'] != $area_actual) {
                    $area_actual = $row['area'];
                    $index = array_search($area_actual, $arrayAreas);
                    if ($index !== false) {
                        echo '<tr>
                        <th class="area" colspan="5" style="text-align: center;">' . $arrayNombres[$index] . '</th>
                      </tr>';
                    }
                }

                // Imprimir el usuario los botones estan funcionando en js/scriptPopUp.js
                echo '<tr>
                <td>' . $row["nom_usu"] . '</td>
                <td style="text-align: center;">' . $row["puesto"] . '</td>
                <td style="text-align: center;">' . $row["correo"] . '</td>
                <td style="text-align: center;">' . $row["extencion"] . '</td>
                <td> <a href="#" style="pointer-events:auto" rel="noopener noreferrer">
                    <img value="' . $row['id_user'] . '" class="btnPopUp" src="imagenes/edit.png" alt="" style="width: 35px;">
                </a></td>                            
              </tr>';
            }
        }
        ?>

    </tbody>
</table>
<script src="js/scriptPopUp.js"></script>
<?php
include 'footer.php';
?>