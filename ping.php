<?php
header('Content-Type: application/json');
$direccion = "8.8.8.8";
    # code...
    if (isset($direccion)) {
        $ip = escapeshellcmd($direccion);
        $os = PHP_OS;
    
        if (stripos($os, 'WIN') === 0) {
            $command = "ping -n 1 $ip";
        } else {
            $command = "ping -c 1 $ip";
        }
    
        $output = shell_exec($command);
    
        if (strpos($output, 'TTL') !== false) {
            preg_match('/tiempo[=<]([\d.]+)ms/', $output, $matches);
            $time = $matches[1] ?? null;
            echo json_encode(['ip' => $ip, 'time' => $time, 'status' => 'success']);
        } else {
            echo json_encode(['ip' => $ip, 'time' => null, 'status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se proporcionó una IP.']);
    }
?>