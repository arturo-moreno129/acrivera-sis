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
    <option value="3">CORREO CORPORATIVO</option>
</select>
<center><input type="text" name="nombre" id="input-search-directorio" onkeyup="myFunction1('myTableDirectorio', 'mySelectDirectorio', 'input-search-directorio')" placeholder="Ingresa el nombre a buscar"></center><br>

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
        $query = "SELECT * FROM directorio";
        $result = mysqli_query($con, $query);
        $arrayAreas = ['DG', 'DF', 'CL', 'AUD', 'CXC'];
        $arrayNombres = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza'];
        $i = 0;
        if (mysqli_num_rows($result) > 0) {
            echo ' <tr>
                        <th class="area" colspan="5" style="text-align: center;">' . $arrayNombres[$i] . '</th>
                    </tr>';
            while ($row = mysqli_fetch_array($result)) {
                if ($row['area'] != $arrayAreas[$i]) {
                    # code...
                    $i++;
                    echo ' <tr>
                            <th class="area" colspan="5" style="text-align: center;">' . $arrayNombres[$i] . '</th>
                        </tr>';
                }
                echo '
                   
                    <tr>
                        <td>' . $row["nom_usu"] . '</td>
                        <td style="text-align: center;">' . $row["puesto"] . '</td>
                        <td style="text-align: center;">' . $row["correo"] . '</td>
                        <td style="text-align: center;">' . $row["extencion"] . '</td>
                        <td> <a href="#" style="pointer-events:auto" rel="noopener noreferrer"><img value="' . $row['id_user'] . '" class="btnPopUp" src="imagenes/pendiente_firma.png" alt="" style="width: 35px;"></a></td>                            
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