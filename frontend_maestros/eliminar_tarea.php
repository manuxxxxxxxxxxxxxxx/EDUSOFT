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

    // Redirigir a la sección de tareas del panel principal
    header("Location: ../frontend_maestros/index.php?id_clase=$id_clase#seccion-tareas&msg=tarea_eliminada");
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
    if ($ruta_archivo && file_exists($ruta_archivo)) {
        unlink($ruta_archivo);
    }

    // Eliminar registro en la BD
    $stmt_del = $conn->prepare("DELETE FROM materiales_estudio WHERE id = ?");
    $stmt_del->bind_param("i", $id_material);
    $stmt_del->execute();
    $stmt_del->close();

    // Redirigir a la sección de materiales con mensaje
    header("Location: ../frontend_maestros/index.php?id_clase=$id_clase#seccion-materiales&msg=material_eliminado");
    exit;

} elseif ($accion === "eliminar_aviso") {
    // ELIMINAR AVISO
    if (!isset($_POST['id_aviso'])) {
        die("❌ ID de aviso no proporcionado.");
    }

    $id_aviso = intval($_POST['id_aviso']);
    $id_clase = isset($_POST['id_clase']) ? intval($_POST['id_clase']) : null;

    // Validar que el aviso pertenece a una clase del profesor
    $sql = "SELECT a.id_clase 
            FROM avisos a 
            JOIN clases c ON a.id_clase = c.id 
            WHERE a.id = ? AND c.profesor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_aviso, $profesor_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        die("❌ No tienes permiso para eliminar este aviso.");
    }

    $aviso = $res->fetch_assoc();
    $id_clase = $aviso['id_clase'];

    // Eliminar el aviso
    $stmt_del = $conn->prepare("DELETE FROM avisos WHERE id = ?");
    $stmt_del->bind_param("i", $id_aviso);
    $stmt_del->execute();
    $stmt_del->close();

    // Redirigir a la sección de avisos con mensaje
    header("Location: ../frontend_maestros/index.php?id_clase=$id_clase#seccion-avisos&msg=aviso_eliminado");
    exit;

} else {
    die("❌ Acción inválida.");
}
?>