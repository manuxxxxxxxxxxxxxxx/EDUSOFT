<?php
$servername = "localhost";
$username = "root";           
$password = "";               
$dbname = "edusoft";          

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Opcional: Forzar UTF-8 para evitar problemas de acentos o caracteres especiales
$conn->set_charset("utf8mb4");
?>