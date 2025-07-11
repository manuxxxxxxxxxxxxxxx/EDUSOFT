<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar que esté logueado como profesor
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'profesor') {
    die("Acceso denegado.");
}

$nombre = $_POST['nombre_clase'];
$descripcion = $_POST['descripcion'] ?? '';
$profesor_id = $_SESSION['id'];
$materia = $_POST['materia'];

$sql = "INSERT INTO clases (nombre_clase, materia, descripcion, profesor_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nombre, $materia, $descripcion, $profesor_id);

if ($stmt->execute()) {
    echo "Clase creada exitosamente.";
    // Redirigir si quieres:
    header("Location: ../fronted_maestros/index.php");
} else {
    echo "Error al crear clase: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
