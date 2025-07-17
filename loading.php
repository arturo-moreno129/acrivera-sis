<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Página Principal</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="./imagenes/logo_acr_black.png" type="image/x-icon" id="favicon">
</head>

<body>
  <div id="loader">
    <div class="spinner"></div>
  </div>
  <script>
    // Esperar 2 segundos antes de mostrar contenido (simula carga)
    setTimeout(() => {
      document.getElementById('loader').style.display = 'none';
      //document.getElementById('contenido').style.display = 'block';
      console.log("hola")
      window.location.assign("main");
    }, 2000);
  </script>
</body>

</html>