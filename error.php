<?php
// Bloquea el acceso directo
/*if (!defined('NO_DB_ACCESS')) {
    header("Location: main");
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #1e1e2f;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 5rem;
            margin: 0;
        }

        p {
            font-size: 1.5rem;
            margin: 10px 0 20px;
        }

        a {
            text-decoration: none;
            color: #ff4b5c;
            font-size: 1.2rem;
            border: 2px solid #ff4b5c;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background-color: #ff4b5c;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>404</h1>
        <p>¡Oops! La página que buscas no se encuentra.</p>
        <a href="logout">Recargar pagina</a>
    </div>
</body>

</html>