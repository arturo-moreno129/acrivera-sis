<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ACRIVERA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estiloslogin.css">
    <link rel="shortcut icon" href="assets/icono_FM.jpg" type="image/x-icon">
</head>

<body>

    <div class="contenedor-formulario contenedor">
        <div class="imagen-formulario"> <!-- aqui va la imagen de la empresa-->
            <img class="imagen-bacground" src="#" alt="" style="width: 700px;">
        </div>

        <form class="formulario" action="sesion.php" method="post" name="confir">
            <div class="texto-formulario">
                <h2>Bienvenido de nuevo</h2>
                <p>Inicia sesión con tu cuenta</p>
            </div>
            <div class="input">
                <label for="usuario">Usuario</label>
                <input placeholder="Ingresa tu nombre" type="text" id="user" name ="user">
            </div>
            <div class="input">
                <label for="contraseña">Contraseña</label>
                <input placeholder="Ingresa tu contraseña" type="password" id="myPass" name = "password">
                <p style="color: white;"><input type="checkbox" name="" id="checkbox3" style="width: 30px;" onclick="functionPass()">Mostrar contraseña</p>
            </div>
            <div class="password-olvidada">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="input">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    <footer>
        <script src="js/script.js"></script>
    </footer>
</body>

</html>