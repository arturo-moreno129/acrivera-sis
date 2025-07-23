<?php
include 'header.php'
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<body>
    <center>
        <div class="qr-card">
            <h1>Descarga la App de Kigo</h1>
            <p>Escanea este código QR desde tu celular para descargar la aplicación.</p>
            <div id="qrcode"></div>
            <p>Kigo - Parkimovil_6.10.2 build-2024_06_21_apkcombo.com.apk</p>
        </div>
    </center>


    <script>
        // 🔁 Reemplaza esta IP y ruta por la de tu archivo .apk
        const apkUrl = "https://drive.google.com/file/d/174h-qPQX8DEcMJ3b7IevFbs61o4_1xO6/view?usp=sharing";

        new QRCode(document.getElementById("qrcode"), {
            text: apkUrl,
            width: 200,
            height: 200
        });
    </script>

</body>

<?php
include 'footer.php'
?>