<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// 🔗 Enlace directo al Excel
$url = "https://camionesrivera.sharepoint.com/:x:/s/PermisosGAU/IQBZZwjSpE-ZSZKH62YupeJiAVE5rdurgvB-QNWAOLYzigo?e=bGgWxj";

// Guardamos una copia temporal
$archivo = "excel_temp.xlsx";
file_put_contents($archivo, file_get_contents($url));

// Cargamos el Excel
$spreadsheet = IOFactory::load($archivo);
$hoja = $spreadsheet->getActiveSheet();
$datos = $hoja->toArray();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla desde SharePoint</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f4f4f4;
        }
    </style>
</head>
<body>

<h2>Datos del Excel</h2>

<table>
    <?php
    foreach ($datos as $i => $fila) {
        echo "<tr>";
        foreach ($fila as $celda) {
            if ($i == 0) {
                echo "<th>" . htmlspecialchars($celda) . "</th>";
            } else {
                echo "<td>" . htmlspecialchars($celda) . "</td>";
            }
        }
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
