<?php
session_start();
if (!isset($_SESSION['usuario'])) exit();

include("conexion.php");

$id = $_POST['id'];

$conn->query("UPDATE visita SET hora_salida=CURTIME() WHERE id_visita='$id'");
?>