<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdf'])) {
        $uploads_dir = 'archivos'; // Asegúrate de que esta carpeta exista y tenga permisos de escritura
        $tmp_name = $_FILES['pdf']['tmp_name'];
        $name = basename($_FILES['pdf']['name']);
        $path = "$uploads_dir/$name";

        // Mueve el archivo subido a la carpeta deseada
        if (move_uploaded_file($tmp_name, $path)) {
            echo "<script>alert(el archivo se guardo)</script";
            //echo "El archivo se ha guardado en: $path";
        } else {
            echo "Error al guardar el archivo.";
        }
    } else {
        echo "No se ha recibido ningún archivo.";
    }
} else {
    echo "Método no permitido.";
}
?>
