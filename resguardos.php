<?php
include "header.php";
?>
<div class="contnedor-buscador">
    <form action="resguardos.php" id="form" method="post">
        <center>
            <h1>BUSCADOR</h1>
        </center>
        <center><input type="text" name="nombre" id="input-search" placeholder="Ingresa el nombre a buscar"></center><br>
        <center><input type="submit" value="Buscar" id="input-button" style="cursor:pointer;"></center>
    </form><br>
    <div class="status-usuario">
        <p>
            Nombre: <input type="submit" value="JOSE ARTURO MORENO AGUILAR" style="color:white; width: 350px; border-radius:5px;background-color:gray;" disabled>
            &emsp;&emsp;&emsp;Estatus: <label for="">ACTIVO</label> <i class="fa-solid fa-circle-check" style="color:green"></i>
            &emsp;&emsp;&emsp;Ver usuario: <a href="usuario.php" style="text-decoration:none;"><i class="fa-solid fa-circle-user"></i></a>
        </p>
    </div>
</div><br>
<table>
    <thead>
        <tr><!--th para encabezados-->
            <th>USUARIO</th>
            <th style="text-align: center;">FECHA</th>
            <th style="text-align: center;">DISPOSITIVO</th>
            <th style="text-align: center;">PDF RESGUARDO</th>
            <th style="text-align: center;">PDF MANTENIMEINTO</th>
        </tr>
        <thead>
        <tbody>
            <?php if (isset($_POST['nombre']) && !empty($_POST['nombre'])): ?>
                <?php
                $nombre = strtoupper($_POST["nombre"]);
                $url_files = strtr($nombre, " ", "_");
                $new_url_files = "archivos/" . $url_files . "/";
                $query = "select*From evidencia where nombre = '$nombre'";
                $result = mysqli_query($con, $query);
                if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo
                        '<tr>
                                <td>' . $row["nombre"] . '</td>
                                <td>' . $row["fecha"] . '</td>
                                <td>' . $row["dispositivo"] . '</td>
                                <td>' . ($row["url_resguardo"] != null ? '<a href="' . $new_url_files . $row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') .'</td>
                                <td>' . ($row["url_mantenimiento"] != null ? '<a href="' . $new_url_files . $row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') .'</td>
                            </tr>';
                    }
                }
                //echo strtoupper($nombre) 
                ?>
            <?php endif; ?>
        </tbody>
</table>
<?php
include "footer.php"
?>