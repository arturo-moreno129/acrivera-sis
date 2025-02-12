<?php
include "header.php";
?>
<center>
    <h1>BUSCAR</h1>
</center>
<h2 id="filtrado">Filtrar por:</h2>

<select id="mySelect" class="form-control">
    <option value="">SELECCIONA FILTRO DE BÚSQUEDA</option>
    <option value="0">USUARIO</option>
    <option value="1">FECHA</option>
    <option value="2">DISPOSITIVO</option>
</select>
<center><input type="text" name="nombre" id="input-search" onkeyup="myFunction1()" placeholder="Ingresa el nombre a buscar"></center><br>

<!--<div class="status-usuario">
    <p>
        Nombre: <input type="submit" value="JOSE ARTURO MORENO AGUILAR" style="color:white; width: 350px; border-radius:5px;background-color:gray;" disabled>
        &emsp;&emsp;&emsp;Estatus: <label for="">ACTIVO</label> <i class="fa-solid fa-circle-check" style="color:green"></i>
        &emsp;&emsp;&emsp;Ver usuario: <a href="usuario.php" style="text-decoration:none;"><i class="fa-solid fa-circle-user"></i></a>
    </p>
</div>--><br>
<table id="myTable">
    <thead>
        <tr><!--th para encabezados-->
            <th>USUARIO</th>
            <th style="text-align: center;">FECHA</th>
            <th style="text-align: center;">DISPOSITIVO</th>
            <th style="text-align: center;">PDF RES</th>
            <th style="text-align: center;">PDF MANT</th>
            <th style="text-align: center;">ESTATUS</th>
        </tr>
        <thead>
        <tbody>
            <?php
            $new_url_files = "carpetas/";
            $query = "select * From evidencia ORDER BY nombre"; //where nombre = '$nombre'";
            $result = mysqli_query($con, $query);
            if ($row = mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo
                    '<tr>
                                <td>' . $row["nombre"] . '</td>
                                <td>' . $row["fecha"] . '</td>
                                <td>' . $row["dispositivo"] . '</td>
                                <td>' . ($row["url_resguardo"] != null ? '<a href="' . $new_url_files . $row["nombre"] ."/".$row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') . '</td>
                                <td>' . ($row["url_mantenimiento"] != null ? '<a href="' . $new_url_files .$row["nombre"] ."/". $row["url_mantenimiento"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') . '</td>
                                <td>' . (($row['estatus'] == 0 or $row['estatus_mant'] == 0)? '<a href="pendientes.php?id='.$row["id_evidencia"].'" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pendiente_firma.png" alt="" style="width: 35px;"> </a>':'<img id="pdf-icon" src="imagenes/chek.png" alt="" style="width: 35px;">').'</td>
                            </tr>';
                }
            } else {
                $_SESSION["alert"] = "No se encontro el suaurio";
            }
            //echo strtoupper($nombre) 
            ?>
        </tbody>
</table>
<?php
include "footer.php"
?>
