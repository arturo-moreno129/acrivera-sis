<script src="js/script.js"></script>

<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>


<!--<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>-->
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!--<script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.tailwindcss.com"></script>--><!--PARA PAGINACION-->
<!-- Ícono flotante de WhatsApp -->
<!--<a href="https://wa.me/2204844702?text=Hola,%20me%20gustaría%20obtener%20más%20información."
   target="_blank" class="whatsapp-float">
   <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp">
</a>-->

<!-- Estilos del botón flotante -->
<!--<style>
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 20px;
        right: 20px;
        background-color: #25D366;
        color: #FFF;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }

    .whatsapp-float img {
        margin-top: 15px;
        width: 30px;
        height: 30px;
    }
</style>-->
<!-- WhatsApp Múltiples Contactos lado derecho-->
<style>
    #whatsapp-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column-reverse;
        /* Asegura que el botón quede abajo */
        align-items: flex-end;
        /* Alinea a la derecha */
    }

    #whatsapp-widget .button {
        background-color: #25D366;
        color: white;
        border: none;
        border-radius: 50%;
        padding: 15px;
        cursor: pointer;
        font-size: 24px;
        width: 57px;
        height: auto;
    }

    #whatsapp-box {
        position: absolute;
        /* Permite posicionarlo sobre el botón */
        bottom: 70px;
        /* Coloca el cuadro arriba del botón */
        right: 0;
        display: none;
        background: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        width: 260px;
        z-index: 10000;
    }

    #whatsapp-box h4 {
        margin-top: 0;
        color: #25D366;
    }

    .whatsapp-contact {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px;
        margin-top: 8px;
        cursor: pointer;
        text-decoration: none;
        color: #000;
    }

    .whatsapp-contact img {
        width: 24px;
        height: 24px;
        margin-right: 10px;
    }
</style>

<div id="whatsapp-widget">
    <div id="whatsapp-box">
        <h4>¿Necesitas ayuda? Conversa con nosotros</h4>
        <p style="margin: 0; font-size: 14px;">Nuestro equipo de Soporte Técnico está disponible para ayudarte con cualquier inconveniente relacionado con el uso de nuestras plataformas.</p>

        <a class="whatsapp-contact" href="https://wa.me/2223358474?text=Hola,%20necesito%20ayuda" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="whatsapp"> José Arturo Moreno Aguilar
        </a>

        <!--<a class="whatsapp-contact" href="https://wa.me/521XXXXXXXXXX?text=Hola%20Elizabeth,%20necesito%20ayuda" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="whatsapp"> Elizabeth Moreno Moreno
        </a>-->
    </div>

    <button class="button" onclick="toggleWhatsappBox()">
        <i class="fab fa-whatsapp"></i>
    </button>
</div>

<script>
    function toggleWhatsappBox() {
        const box = document.getElementById("whatsapp-box");
        box.style.display = box.style.display === "block" ? "none" : "block";
    }
</script>

</body>
</main>

</html>