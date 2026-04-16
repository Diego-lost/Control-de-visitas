<?php
session_start();

$user = $_POST['usuario'];
$pass = $_POST['password'];

if ($user == "Diego" && $pass == "12345") {


    $_SESSION['usuario'] = $user;
    echo "ok";
} else {
    echo "error";
}
?>