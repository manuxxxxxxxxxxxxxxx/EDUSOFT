<?php
session_start();
require_once 'conexiones/conexion.php';

if (!isset($_SESSION['id_estudiante'])) {
    echo "<script>alert('No has iniciado sesión.'); window.location.href='loginAlumno.php';</script>";
    exit;
}

$id_clase = $_POST['id_clase'];
$id_estudiante = $_SESSION['id_estudiante'];

if ($id_clase && $id_estudiante) {
    $query = "DELETE FROM clases_estudiantes WHERE id_clase = ? AND id_estudiante = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_clase, $id_estudiante);
    $stmt->execute();
    echo "<script>alert('Has salido de la clase correctamente.'); window.location.href='cursos.php';</script>";
} else {
    echo "<script>alert('Error al salir de la clase.'); window.location.href='cursos.php';</script>";
}
?>