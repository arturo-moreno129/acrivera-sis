const chatBox = document.getElementById("chat");
const messageInput = document.getElementById("message");
const sendBtn = document.getElementById("send");

// 🔗 Conexión al servidor Node.js
const socket = new WebSocket("ws://localhost:3000");

socket.onopen = () => {
    console.log("Conectado al servidor WebSocket");
};

socket.onmessage = (event) => {
    const msg = document.createElement("div");
    msg.textContent = event.data;
    chatBox.appendChild(msg);
};

sendBtn.addEventListener("click", () => {
    const message = messageInput.value;
    if (message.trim() !== "") {
        socket.send(message);

        // guardar en MySQL a través de PHP
        /*fetch("php/save_message.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "mensaje=" + encodeURIComponent(message)
        });

        messageInput.value = "";*/
    }
});
