<?php
session_start();
require_once "../conexiones/conexion.php";

// Validaciones básicas
if (empty($_POST["Nombre"]) || empty($_POST["Pass"])) {
    die("Por favor, complete todos los campos.");
}

$nombre = $_POST["Nombre"];
$pass = $_POST["Pass"];

// Consulta por nombre
$sql = "SELECT ID, nombre, pass FROM estudiantes WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $nombre, $pass_hash);
    $stmt->fetch();

    if (password_verify($pass, $pass_hash)) {
        $_SESSION["id_estudiante"] = $id;
        $_SESSION["nombre"] = $nombre;
        $_SESSION["rol"] = "estudiante"; 
        header("Location: ../cursos.php");
        exit;
    } else {
        echo "❌ Contraseña incorrecta.";
    }
} else {
    echo "❌ Nombre no registrado.";
}

$stmt->close();
$conn->close();
?>
