<?php
include "header.php";
?>
<button class="tablink" onclick="openPage('Resguardos', this, 'white')" id="defaultOpen">RESGUARDOS</button>
<button class="tablink" onclick="openPage('Reparaciones', this, 'white')">REPARACIONES</button>
<!--<button class="tablink" onclick="openPage('News', this, 'white')">News</button>
<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>-->



<div id="Resguardos" class="tabcontent">
    <center>
        <h1>BUSCAR RESGUARDO</h1>
    </center>
    <h2 id="filtrado">Filtrar por:</h2>

    <select id="mySelectResguardo" class="form-control">
        <option value="">SELECCIONA FILTRO DE BÚSQUEDA</option>
        <option value="0">USUARIO</option>
        <option value="1">FECHA</option>
        <option value="2">DISPOSITIVO</option>
    </select>
    <center><input type="text" name="nombre" id="input-search-resguardo" onkeyup="myFunction1('myTableResguardo', 'mySelectResguardo', 'input-search-resguardo')" placeholder="Ingresa el nombre a buscar"></center><br>

    <!--<div class="status-usuario">
    <p>
        Nombre: <input type="submit" value="JOSE ARTURO MORENO AGUILAR" style="color:white; width: 350px; border-radius:5px;background-color:gray;" disabled>
        &emsp;&emsp;&emsp;Estatus: <label for="">ACTIVO</label> <i class="fa-solid fa-circle-check" style="color:green"></i>
        &emsp;&emsp;&emsp;Ver usuario: <a href="usuario.php" style="text-decoration:none;"><i class="fa-solid fa-circle-user"></i></a>
    </p>
</div>--><br>
    <table id="myTableResguardo">
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
                                <td>' . ($row["url_resguardo"] != null ? '<a href="view_pdf.php?file=' . $row["nombre"] . "/" . $row["url_resguardo"] . '" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') . '</td>
                                <td>' . ($row["url_mantenimiento"] != null ? '<a href="view_pdf.php?file=' .$row["nombre"] . "/" . $row["url_mantenimiento"] . '" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') . '</td>
                                <td>' . (($row['estatus'] == 0 or $row['estatus_mant'] == 0) ? '<a href="pendientes.php?id=' . $row["id_evidencia"] . '" style="pointer-events:auto" rel="noopener noreferrer"> <img id="pdf-icon" src="imagenes/pendiente_firma.png" alt="" style="width: 35px;"> </a>' : '<img id="pdf-icon" src="imagenes/chek.png" alt="" style="width: 35px;">') . '</td>
                            </tr>';
                    }
                } else {
                    $_SESSION["alert"] = "No se encontro el suaurio";
                }
                //echo strtoupper($nombre) 
                ?>
            </tbody>
    </table>
    <!--<div id="pagination" class="flex items-center space-x-2 mt-4"></div>--><!--PARA PAGINACION-->
</div>



<div id="Reparaciones" class="tabcontent">
    <center>
        <h1>BUSCAR REPARACIÓN</h1>
    </center>
    <h2 id="filtrado">Filtrar por:</h2>

    <select id="mySelectReparacion" class="form-control">
        <option value="">SELECCIONA FILTRO DE BÚSQUEDA</option>
        <option value="0">SOLICITANTE</option>
        <option value="1">FECHA</option>
        <option value="3">DISPOSITIVO</option>
    </select>
    <center><input type="text" name="nombre" id="input-search-reparacion" onkeyup="myFunction1('myTableReparacion', 'mySelectReparacion', 'input-search-reparacion')" placeholder="Ingresa el nombre a buscar"></center><br>

    <table id="myTableReparacion">
        <thead>
            <tr>
                <th>SOLICITANTE</th>
                <th style="text-align: center;">FECHA REGISTRO</th>
                <th style="text-align: center;">FECHA ENTREGA</th>
                <th style="text-align: center;">DISPOSITIVO</th>
                <th style="text-align: center;">DESCRIPCIÓN</th>
                <th style="text-align: center;">QUIN RECIBE</th>
                <th style="text-align: center;">ESTATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM reparacion ORDER BY fecha_recepcion DESC;";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>
                            <td>' . $row["nom_solicitante"] . '</td>
                            <td style="text-align: center;">' . $row["fecha_recepcion"] . '</td>
                            <td style="text-align: center;">' . $row["fecha_entrega"] . '</td>
                            <td style="text-align: center;">' . $row["dispositivo"] . '</td>
                            <td style="text-align: justify;">' . $row["descripcion"] . '</td>
                            <td style="text-align: center;">' . $row["nom_recepcion"] . '</td>
                            <td style="text-align: center;">' .
                        (($row['estatus'] == 0)
                            ? '<a href="#" style="pointer-events:auto" rel="noopener noreferrer">
                                    <img value="' . $row['id_repa'] . '" class="btnPrueba" src="imagenes/pendiente_firma.png" alt="" style="width: 35px;">
                                   </a>'
                            : '<img id="pdf-icon" src="imagenes/chek.png" alt="" style="width: 35px;">') .
                        '</td>
                          </tr>';
                }
            }
            ?>
        </tbody>
    </table>
    
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.btnPrueba').forEach((btn) => {
            btn.addEventListener('click', function() {
                const idRepa = this.getAttribute("value");

                Swal.fire({
                    title: "Fecha de entrega",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "FINALIZAR",
                    denyButtonText: "CANCELAR",
                    html: `
                        <input type="date" id="swal-input1" class="swal2-input"><br><br>
                        <label for="#">Nombre quien recibe:</label>
                        <input id="swal-input2" class="swal2-input">
                    `,
                    didOpen: () => {
                        const today = new Date().toISOString().split("T")[0];
                        document.getElementById("swal-input1").min = today;
                    },
                    preConfirm: () => {
                        const fechaEntrega = document.getElementById("swal-input1").value;
                        const usuRecepcion = document.getElementById("swal-input2").value
                        if (!fechaEntrega) {
                            Swal.showValidationMessage("Debes seleccionar una fecha");
                            return false;
                        }
                        if (!usuRecepcion) {
                            Swal.showValidationMessage("Debes de escribir quien recibio el articulo");
                            return false;
                        }

                        return {
                            fechaEntrega,
                            usuRecepcion,
                            id: typeof idRepa !== "undefined" ? idRepa : null
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            fechaEntrega,
                            id,
                            usuRecepcion
                        } = result.value;
                        fetch('crud-calendar.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `action=updateDate&id=${id}&fecha=${fechaEntrega}&usurecep=${usuRecepcion}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    console.log(data);
                                    Swal.fire({
                                        title: data.message, //obtine el mensaje desde php
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload(); // Recarga la página cuando el usuario presiona "OK"
                                        }
                                    });

                                } else {
                                    /*Swal.fire("Error", data.message, "error");*/
                                    console.log(data);
                                }
                            })
                        //Swal.fire("Datos a mostrar", `Fecha: ${fechaEntrega}, ID: ${id !== null ? id : "No definido"}, Usuario: ${usuRecepcion}`);
                    } else if (result.isDenied) {
                        Swal.fire("Se canceló el cambio", "", "info");
                    }
                });

            });
        });
    });
</script>
<!--<script src="js/pagination.js"></script>--><!--PRAR PAGINACION-->


<?php
include "footer.php"
?>