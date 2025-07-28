<?php
session_start();
include '../conexiones/conexion.php';

if (!isset($_SESSION['id_estudiante'])) {
    echo json_encode(["success" => false, "mensaje" => "No autorizado"]);
    exit;
}

$id_tarea = $_POST['id_tarea'];
$id_estudiante = $_SESSION['id_estudiante'];

// Verifica que la tarea le pertenece al estudiante
$sql = "SELECT ruta_archivo FROM tareas WHERE id = ? AND id_estudiante = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_tarea, $id_estudiante);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $ruta = $row['ruta_archivo'];

    // Eliminar archivo del servidor
    if (file_exists($ruta)) {
        unlink($ruta);
    }

    // Eliminar de la base de datos
    $delete = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $delete->bind_param("i", $id_tarea);
    $delete->execute();

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "mensaje" => "Tarea no encontrada o no tienes permiso."]);
}
?>