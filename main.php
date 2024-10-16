<?php
include "header.php";
?>
<main>
    <div class="contnedor-buscador">
        <form action="main.php" id="form" method="post">
            <center>
                <h1>BUSCADOR</h1>
            </center>
            <center><input type="text" name="nombre" id="input-search" placeholder="Ingresa el nombre a buscar"></center><br>
            <center><input type="submit" value="Buscar" id="input-button" style="cursor:pointer;"></center>
        </form>
    </div>
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
                    $new_url_files = "resguardos/" . $url_files . "/";
                    $query = "select*From evidencia where nombre = '$nombre'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo
                            '<tr>
                                <td>' . $row["nombre"] . '</td>
                                <td>' . $row["fecha"] . '</td>
                                <td>' . $row["dispositivo"] . '</td>
                                <td>' .
                                        ($row["id_usuario"] == 1 ? '<a href="' . $row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') .
                                        '</td>
                                <td>
                                    <a href="' . $new_url_files . $row["url_mantenimienti"] . '" target="_blank" rel="noopener noreferrer"><img id="pdf-icon" src="imagenes\pdf_img.png" alt="" style="width: 35px;></a>
                                </td>
                                <td>
                                    <a href="load_img.php" target="_blank" value = "arturo" rel="noopener noreferrer"><img id="pdf-icon" src="imagenes\icon_img.png" alt=""></a>                    
                                </td>
                            </tr>';
                        }
                    }
                    //echo strtoupper($nombre) 
                    ?>
                <?php endif; ?>
            </tbody>
    </table>
</main>
<?php
include "footer.php"
?>