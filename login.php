<?php
session_start();

$user = $_POST['usuario'];
$pass = $_POST['password'];

// 🔥 LOGIN SIMPLE (SIN BD)
if ($user == "admin" && $pass == "1234") {
    $_SESSION['usuario'] = $user;
    echo "ok";
} else {
    echo "error";
}
?>