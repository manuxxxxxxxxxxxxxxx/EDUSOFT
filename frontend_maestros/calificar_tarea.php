<?php
require_once "../conexiones/conexion.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_tarea = intval($_POST['id_tarea']);
    $calificacion = intval($_POST['calificacion']);
    $retro = trim($_POST['retroalimentacion'] ?? "");
    if ($id_tarea && $calificacion >= 1 && $calificacion <= 10) {
        $stmt = $conn->prepare("UPDATE tareas SET calificacion = ?, retroalimentacion = ? WHERE id = ?");
        $stmt->bind_param("isi", $calificacion, $retro, $id_tarea);
        $stmt->execute();
        $stmt->close();
    }
    // Redirecciona de nuevo a la sección de entregas
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}