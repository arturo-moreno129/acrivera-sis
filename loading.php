<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Página Principal</title>
  <link rel="stylesheet" href="css/style.css">
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