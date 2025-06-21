<?php

$ServerName = "localhost";
$UserName = "root";
$PassWord = "";
$DbName = "edusoft";

$conn = new mysqli($ServerName, $UserName, $PassWord, $DbName);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>