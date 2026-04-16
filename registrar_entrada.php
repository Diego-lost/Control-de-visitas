<?php
include("conexion.php");

// VALIDAR DATOS
if (!isset($_POST['nombre'], $_POST['dni'], $_POST['visitado'], $_POST['despacho'])) {
    echo "Error: datos incompletos";
    exit();
}

$nombre = $_POST['nombre'];
$dni = $_POST['dni'];
$visitado = $_POST['visitado'];
$despacho = $_POST['despacho'];

// ========================
// PERSONA
// ========================
$check = "SELECT id_persona FROM persona WHERE dni='$dni'";
$result = $conn->query($check);

if (!$result) {
    die("Error en SELECT persona: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_persona = $row['id_persona'];
} else {
    if (!$conn->query("INSERT INTO persona (nombre, dni) VALUES ('$nombre','$dni')")) {
        die("Error insert persona: " . $conn->error);
    }
    $id_persona = $conn->insert_id;
}

// ========================
// DESPACHO
// ========================
$checkD = "SELECT id_despacho FROM despacho WHERE nombre='$despacho'";
$resD = $conn->query($checkD);

if (!$resD) {
    die("Error en SELECT despacho: " . $conn->error);
}

if ($resD->num_rows > 0) {
    $rowD = $resD->fetch_assoc();
    $id_despacho = $rowD['id_despacho'];
} else {
    if (!$conn->query("INSERT INTO despacho (nombre) VALUES ('$despacho')")) {
        die("Error insert despacho: " . $conn->error);
    }
    $id_despacho = $conn->insert_id;
}

// ========================
// VISITA
// ========================
$sql = "INSERT INTO visita (id_persona, id_despacho, persona_visitada, fecha, hora_entrada)
VALUES ('$id_persona','$id_despacho','$visitado', CURDATE(), CURTIME())";

if (!$conn->query($sql)) {
    die("Error insert visita: " . $conn->error);
}

// RESPUESTA FINAL
echo "Se registró correctamente";
?>