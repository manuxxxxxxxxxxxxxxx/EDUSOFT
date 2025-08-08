<?php
session_start();
require_once "../conexiones/conexion.php";

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    die("⛔ Acceso denegado.");
}

$profesor_id = $_SESSION["id"];

// Verificamos que se envió la acción
if (!isset($_POST['accion'])) {
    die("❌ Acción no especificada.");
}

$accion = $_POST['accion'];

if ($accion === "eliminar_tarea") {
    // ELIMINAR TAREA
    if (!isset($_POST['id_tarea'])) {
        die("❌ ID de tarea no proporcionado.");
    }

    $id_tarea = intval($_POST['id_tarea']);

    // Validar que la tarea pertenece a una clase del profesor
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
    $id_clase = $tarea['id_clase'];

    // Eliminar la tarea
    $stmt = $conn->prepare("DELETE FROM tareas_profesor WHERE id = ?");
    $stmt->bind_param("i", $id_tarea);
    $stmt->execute();

    // Redirigir a la sección de tareas del panel principal o la materia
    header("Location: ../frontend_maestros?seccion=tareas&id_clase=$id_clase&msg=tarea_eliminada");
    exit;

} elseif ($accion === "eliminar_material") {
    // ELIMINAR MATERIAL
    if (!isset($_POST['id_material'])) {
        die("❌ ID de material no proporcionado.");
    }

    $id_material = intval($_POST['id_material']);
    $id_clase = isset($_POST['id_clase']) ? intval($_POST['id_clase']) : null;

    // Validar que el material pertenece a una clase del profesor
    $sql = "SELECT m.ruta_archivo, m.id_clase 
            FROM materiales_estudio m 
            JOIN clases c ON m.id_clase = c.id 
            WHERE m.id = ? AND c.profesor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_material, $profesor_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        die("❌ No tienes permiso para eliminar este material.");
    }

    $material = $res->fetch_assoc();
    $ruta_archivo = $material['ruta_archivo'];
    $id_clase = $material['id_clase'];

    // Intentar eliminar archivo físico
    if (file_exists($ruta_archivo)) {
        unlink($ruta_archivo);
    }

    // Eliminar registro en la BD
    $stmt_del = $conn->prepare("DELETE FROM materiales_estudio WHERE id = ?");
    $stmt_del->bind_param("i", $id_material);
    $stmt_del->execute();
    $stmt_del->close();

    // Redirigir a la sección de materiales con mensaje
    header("Location: ../frontend_maestros?seccion=materiales&id_clase=$id_clase&msg=material_eliminado");
    exit;

} else {
    die("❌ Acción inválida.");
}
?>
