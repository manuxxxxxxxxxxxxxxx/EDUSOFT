<?php
session_start();

require_once "../conexiones/conexion.php";

// Validaciones básicas
if (empty($_POST["Nombre"]) || empty($_POST["Pass"])) {
    die("Por favor, complete todos los campos.");
}

$nombre = $_POST["Nombre"];
$pass = $_POST["Pass"];
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// Consulta por nombre
$sql = "SELECT id_estudiante, Nombre, Pass FROM estudiantes WHERE Nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id_estudiante, $nombre, $pass_hash);
    $stmt->fetch();

    if (password_verify($pass, $pass_hash)) {
        $_SESSION["id_estudiante"] = $id;
        $_SESSION["nombre"] = $nombre;
        $_SESSION["rol"] = "estudiante"; // Aquí se define el rol
        eader("Location: ../cursos.php");
        exit;h
    } else {
        echo "❌ Contraseña incorrecta.";
    }
} else {
    echo "❌ Nombre no registrado.";
}

$stmt->close();
$conn->close();
?>
