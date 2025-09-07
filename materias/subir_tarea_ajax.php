<?php
session_start();
require_once "../conexiones/conexion.php";

$id_tarea_profesor = $_POST['id_tarea_profesor'];
$id_estudiante = $_POST['id_estudiante'];
$id_clase = $_POST['id_clase'];
$materia = $_POST['materia'];
$id_entrega = isset($_POST['id_entrega']) ? $_POST['id_entrega'] : null;

// 1. Obtener la fecha de entrega de la tarea del profesor (solo un campo)
$sql_fecha = "SELECT fecha_limite FROM tareas_profesor WHERE id = ?";
$stmt_fecha = $conn->prepare($sql_fecha);
$stmt_fecha->bind_param("i", $id_tarea_profesor);
$stmt_fecha->execute();
$stmt_fecha->bind_result($fecha_entrega);
$stmt_fecha->fetch();
$stmt_fecha->close();

// Validar que la fecha existe y es válida
if (!$fecha_entrega || $fecha_entrega == "0000-00-00 00:00:00") {
    echo json_encode(['error' => 'La tarea no tiene una fecha de entrega válida. Contacte a su profesor.']);
    exit;
}

// Comparar con la fecha actual
$ahora = strtotime(date("Y-m-d H:i:s"));
$fecha_entrega_ts = strtotime($fecha_entrega);

if ($ahora > $fecha_entrega_ts) {
    echo json_encode(['error' => 'La fecha de entrega para esta tarea ha expirado.']);
    exit;
}

// 2. Si ya existe la entrega, usar ese ID. Si no, crear la entrega.
if (!$id_entrega) {
    $sql = "INSERT INTO tareas (id_tarea_profesor, materia, id_clase, id_estudiante, fecha_subida) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $id_tarea_profesor, $materia, $id_clase, $id_estudiante);
    $stmt->execute();
    $id_entrega = $conn->insert_id;
}

// 3. Procesar archivos subidos
$mensajes = [];
foreach ($_FILES['archivo']['tmp_name'] as $i => $tmpName) {
    if ($_FILES['archivo']['error'][$i] === UPLOAD_ERR_OK) {
        $nombre = $_FILES['archivo']['name'][$i];
        $ruta = "../uploads/" . uniqid() . "_" . basename($nombre);
        move_uploaded_file($tmpName, $ruta);

        $sql = "INSERT INTO tareas_archivos (id_tarea, nombre_archivo, ruta_archivo, fecha_subida) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_entrega, $nombre, $ruta);
        $stmt->execute();

        $mensajes[] = "$nombre subido correctamente.";
    }
}

echo json_encode(['mensaje' => 'Tu archivo se subió correctamente.']);
exit;
?>