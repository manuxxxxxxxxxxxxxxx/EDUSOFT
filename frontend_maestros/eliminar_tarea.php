<?php
session_start();
require_once "../conexiones/conexion.php";

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    die("⛔ Acceso denegado.");
}

if (!isset($_POST['id_tarea'])) {
    die("❌ ID de tarea no proporcionado.");
}

$id_tarea = intval($_POST['id_tarea']);
$profesor_id = $_SESSION["id"];

// Validar que esa tarea pertenece a una clase del profesor
$sql = "SELECT t.id_clase, c.materia 
        FROM tareas_profesor t 
        JOIN clases c ON t.id_clase = c.id 
        WHERE t.id = ? AND c.profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_tarea, $profesor_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("❌ No tienes permiso para eliminar esta tarea.");
}

$tarea = $res->fetch_assoc();
$materia = $tarea['materia'];
$id_clase = $tarea['id_clase'];

// Eliminar la tarea
$stmt = $conn->prepare("DELETE FROM tareas_profesor WHERE id = ?");
$stmt->bind_param("i", $id_tarea);
$stmt->execute();

// Redirigir a la sección de tareas del panel principal o la materia
header("Location: ../frontend_maestros");
exit;
?>
