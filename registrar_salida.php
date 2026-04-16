<?php
include("conexion.php");

$id = $_POST['id'];

$sql = "UPDATE visita 
SET hora_salida = CURTIME()
WHERE id_visita = '$id'";

$conn->query($sql);

echo "ok";
?>