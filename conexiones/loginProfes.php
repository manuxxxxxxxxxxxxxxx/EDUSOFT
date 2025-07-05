<?php
session_start();

// Conexión a la base de datos
$ServerName = "localhost";
$UserName = "root";
$PassWord = "";
$DbName = "edusoft";

$conn = new mysqli($ServerName, $UserName, $PassWord, $DbName);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validaciones básicas
if (empty($_POST["Nombre"]) || empty($_POST["Pass"])) {
    die("Por favor, complete todos los campos.");
}

$nombre = $_POST["Nombre"];
$pass = $_POST["Pass"];
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// Consulta por nombre
$sql = "SELECT Nombre, Pass FROM profesores WHERE Nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($nombre, $pass_hash);
    $stmt->fetch();

    if (password_verify($pass, $pass_hash)) {
        $_SESSION['nombre'] = $nombre;
            echo "Login exitoso. Bienvenido,  " . $nombre;
             header ("Location: ../frontend_maestros/index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Nombre no registrado.";
    }

$stmt->close();
$conn->close();
?>