<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento con firma - By Parzibyte</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <h1>Título del documento</h1>
    <strong>Simple documento para demostrar cómo se puede colocar una firma del usuario</strong>
    <img src="" alt="Firma del usuario" id="firma">
    <br>
    <button id="guardarPdf">Guardar PDF</button>
    
    <script>
        const { jsPDF } = window.jspdf;

        if (window.opener) {
            document.querySelector("#firma").src = window.opener.obtenerImagen();
        }

        document.getElementById("guardarPdf").onclick = () => {
            const pdf = new jsPDF();
            pdf.text("Título del documento", 20, 20);
            pdf.text("Simple documento para demostrar cómo se puede colocar una firma del usuario", 20, 30);
            // Agrega más texto según necesites

            const img = document.querySelector("#firma").src;
            pdf.addImage(img, 'PNG', 20, 40, 50, 30); // Ajusta el tamaño y posición según sea necesario
            
            // Convertir el PDF a Blob y enviarlo
            const pdfBlob = pdf.output('blob');
            const formData = new FormData();
            formData.append('pdf', pdfBlob, 'documento_con_firma.pdf');

            fetch('guardar_pdf.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        };
    </script>
</body>
</html>
