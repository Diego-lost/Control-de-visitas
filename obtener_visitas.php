<?php
session_start();
if (!isset($_SESSION['usuario'])) exit();

include("conexion.php");

$sql = "SELECT v.*, p.nombre, p.dni, d.nombre as despacho
FROM visita v
JOIN persona p ON v.id_persona = p.id_persona
JOIN despacho d ON v.id_despacho = d.id_despacho";

$res = $conn->query($sql);

$data = [];

while ($row = $res->fetch_assoc()) {

    if ($row['hora_salida']) {
        $entrada = strtotime($row['hora_entrada']);
        $salida = strtotime($row['hora_salida']);
        $diff = $salida - $entrada;

        $row['tiempo'] = gmdate("H:i:s", $diff);
    }

    $data[] = $row;
}

echo json_encode($data);
?>