<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button type="button" id="btnprueba">enviar</button>
    <script>
        const btn = document.getElementById("btnprueba");
        if (btn) {
            btn.addEventListener('click', () => {
                fetch('crudPerfil.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `action=obtenerDatos&id=51`

                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            console.log(data);
                        }
                    })
            })
        }
    </script>
</body>

</html>