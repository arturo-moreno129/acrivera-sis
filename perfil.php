<?php
include 'header.php'
?>

<style>
    .container {
        display: flex;
        width: 100%;
        height: 500px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .left-panel {
        width: 40%;
        padding: 20px;
        text-align: center;
        background: #e3e3e3;
    }

    .left-panel img {
        width: 250px;
        /*height: 120px;*/
        border-radius: 50%;
        background: #fff;
        padding: 10px;
    }

    .left-panel h3 {
        margin: 10px 0;
    }

    .left-panel button {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .right-panel {
        width: 60%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .device {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        background: #f9f9f9;
    }

    .device img {
        width: 40px;
        margin-right: 15px;
    }

    .observaciones {
        text-align: center;
        margin-top: 15px;
    }

    .observaciones button {
        background: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<div class="container">
    <div class="left-panel">
    <?php
        $query = "SELECT * from directorio WHERE id_user = 51";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                # code...
                echo '<img src="imagenes/user.png" alt="Usuario">
                    <h3>'.$row["nom_usu"].'</h3>
                    <p>Puesto: '.$row["puesto"].'</p>
                    <input type="password" name="" style="text-align: center;" id="btnpass" value="'.$row['contasena'].'" readonly><br>
                    <ion-icon name="eye-off-outline" style="cursor:pointer;" id="btnEye"></ion-icon><br>
                    <button>Editar</button><br><br>';
            }
        }
        ?>
        
    </div>
    <div class="right-panel">
        <?php
        $query = "SELECT * FROM equipo AS e INNER JOIN directorio AS d ON e.id_user = d.id_user WHERE e.id_user = 51";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            # code...
            while ($row = mysqli_fetch_array($result)) {
                # code...
                echo '<div class="device">
                            <img src="imagenes/device.png" alt="PC">
                            <div>
                                <p><strong>Dispositivo:</strong> ' . $row["nom_dispositivo"] . '</p>
                                <p><strong>Modelo:</strong> ' . $row["modelo"] . '</p>
                                <p><strong>Marca:</strong> ' . $row["marca"] . '</p>
                                <p><strong>No. Serie:</strong> ' . $row["no_serie"] . '</p>
                            </div>
                        </div>';
            }
        }
        ?>
        <div class="observaciones">
            <button>Observaciones</button>
        </div>
    </div>
</div>
<script>
    const btnEye = document.getElementById("btnEye");
    const btnpass = document.getElementById("btnpass");
    if (btnEye) {
        btnEye.addEventListener('click', () => {
            if (btnEye.name == 'eye-off-outline') {
                btnEye.name = "eye-outline";
                btnpass.type = 'text'
            } else if(btnEye.name == 'eye-outline'){
                btnEye.name = 'eye-off-outline'
                btnpass.type = 'password'
            }

        })
    }
</script>
<?php
include 'footer.php'
?>