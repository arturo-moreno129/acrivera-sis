<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chat con WebSocket</title>
  <style>
    #chat {
      border: 1px solid #ccc;
      height: 200px;
      overflow-y: auto;
      padding: 10px;
      margin-bottom: 10px;
    }
    #message {
      width: 70%;
      padding: 5px;
    }
    #send {
      padding: 6px 12px;
      background: #28a745;
      color: white;
      border: none;
      cursor: pointer;
    }
    #send:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <h2>Chat en tiempo real</h2>

  <!-- Caja donde se mostrarán los mensajes -->
  <div id="chat"></div>

  <!-- Caja de texto y botón para enviar -->
  <input type="text" id="message" placeholder="Escribe un mensaje...">
  <button id="send">Enviar</button>

  <!-- Tu JS -->
  <!--<script src="chat.js"></script>-->
</body>
</html>
<?php
include 'footer.php';
?>
