<?php
include("conexion.php");

$sql = "SELECT 
v.id_visita,
p.nombre,
p.dni,
d.nombre AS despacho,
v.persona_visitada,
v.fecha,
v.hora_entrada,
v.hora_salida,
TIMEDIFF(v.hora_salida, v.hora_entrada) AS tiempo
FROM visita v
JOIN persona p ON v.id_persona = p.id_persona
JOIN despacho d ON v.id_despacho = d.id_despacho";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>