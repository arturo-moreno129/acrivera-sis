<?php
// Dirección IP de la impresora
/*$ip_impressora = '140.240.13.205';

// Comunidad SNMP
$comunidad_snmp = 'public';

// OIDs (Verificar si son correctos)
$oid_usuario_1 = '.1.3.6.1.4.1.1347.43.10.1.1.12.1.1';
$oid_usuario_2 = '.1.3.6.1.4.1.1347.42.3.1.1.1.1.1';
$oid_usuario_3 = '.1.3.6.1.4.1.1347.42.3.1.1.1.1.2'; 
// Obtener datos SNMP
$contador_paginas_usuario_1 = @snmpget($ip_impressora, $comunidad_snmp, $oid_usuario_1);
$contador_paginas_usuario_2 = @snmpget($ip_impressora, $comunidad_snmp, $oid_usuario_2);
$contador_paginas_usuario_3 = @snmpget($ip_impressora, $comunidad_snmp, $oid_usuario_3);

// Limpiar salida (eliminar "STRING:" o "INTEGER:")
$contador_paginas_usuario_1 = $contador_paginas_usuario_1 ? preg_replace('/^.*: /', '', $contador_paginas_usuario_1) : 'No disponible';
$contador_paginas_usuario_2 = $contador_paginas_usuario_2 ? preg_replace('/^.*: /', '', $contador_paginas_usuario_2) : 'No disponible';
$contador_paginas_usuario_3 = $contador_paginas_usuario_3 ? preg_replace('/^.*: /', '', $contador_paginas_usuario_3) : 'No disponible';

// Mostrar resultados
echo "Impresiones: $contador_paginas_usuario_2 <br>";
echo "Copias: $contador_paginas_usuario_3 <br>";
echo "Total de impresiones: $contador_paginas_usuario_1 <br>";*/


$ip_impressora = '140.240.13.205';
$comunidad_snmp = 'public';

// Usuarios y sus posibles OIDs (Asegúrate de que los números son correctos)
$usuarios = [
    "0001" => "KPRINT",
    "0115" => "CHERNANDEZ",
    "1438" => "LORTIZ",
    "1461" => "MALVARADO",
    "1538" => "NGARCIA",
    "1583" => "TMORALES"
];

foreach ($usuarios as $id => $nombre) {
    $oid = ".1.3.6.1.4.1.1347.42.3.1.1.1.1.$id";  // Ajusta según la estructura correcta
    $contador = snmpget($ip_impressora, $comunidad_snmp, $oid);

    if ($contador) {
        echo "Usuario: $nombre (ID: $id) - Páginas impresas: $contador <br>";
    } else {
        echo "No se pudo obtener el contador de $nombre (ID: $id). <br>";
    }
}



?>

