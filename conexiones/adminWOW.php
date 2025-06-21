<?php
session_start();

// Usuario quemado (definido directamente en el código)
$usuario_valido = "manux28";
$contrasena_valida = "Crocodilo"; // Puedes cambiarlo

$nombre = $_POST["Nombre"];
$pass = $_POST["Pass"];

if ($nombre === $usuario_valido && $pass === $contrasena_valida) {
    $_SESSION["admin"] = true;
    header("Location: ../principal/menuAdmin.php"); // Menú del administrador
    exit;
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>
