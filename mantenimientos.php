<?php
include "header.php";

if (isset($_SESSION['pop-up'])) {
?><script>
    Swal.fire({
    title: "Good job!",
    text: "You clicked the button!",
    icon: "success"
    });
    </script>
<?php
}
unset($_SESSION["pop-up"]) ?>

<center>
    <h2 id="filtrado">Filtrar por:</h2>
</center>

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
            <th style="text-align: center;">TIPO DE MANTENIMEINTO</th>
            <th style="text-align: center;">Estatus</th>
        </tr>
        <thead>
        <tbody>
            <?php
            $query = "select * From mantenimietos ORDER BY fecha"; //where nombre = '$nombre'";
            $result = mysqli_query($con, $query);
            if ($row = mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo
                    '<tr>
                                <td>' . $row["usuario"] . '</td>
                                <td>' . $row["fecha"] . '</td>
                                <td>' . $row["tipoMan"] . '</td>
                                <td>' . $row["estatus"] . '</td>
                            </tr>';
                }
            }
            //echo strtoupper($nombre) 
            ?>
        </tbody>
</table>
<?php
include "footer.php"
?>