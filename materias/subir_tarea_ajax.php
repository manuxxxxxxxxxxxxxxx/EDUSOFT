<?php
session_start();
require_once "../conexiones/conexion.php";

$id_tarea_profesor = $_POST['id_tarea_profesor'];
$id_estudiante = $_POST['id_estudiante'];
$id_clase = $_POST['id_clase'];
$materia = $_POST['materia'];
$id_entrega = isset($_POST['id_entrega']) ? $_POST['id_entrega'] : null;

// Si ya existe la entrega, usar ese ID. Si no, crear la entrega.
if (!$id_entrega) {
    $sql = "INSERT INTO tareas (id_tarea_profesor, materia, id_clase, id_estudiante, fecha_subida) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $id_tarea_profesor, $materia, $id_clase, $id_estudiante);
    $stmt->execute();
    $id_entrega = $conn->insert_id;
}

// Procesar archivos subidos
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

// Verifica si ya existe entrega
$sql_check = "SELECT id FROM tareas WHERE id_estudiante = ? AND id_tarea_profesor = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_estudiante, $id_tarea_profesor);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Ya tiene entrega, obtén el id
    $stmt_check->bind_result($id_tarea);
    $stmt_check->fetch();
} else {
    // Crea nueva entrega
    $sql = "INSERT INTO tareas (id_estudiante, materia, id_clase, id_tarea_profesor, fecha_subida)
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $id_estudiante, $materia, $id_clase, $id_tarea_profesor);
    $stmt->execute();
    $id_tarea = $stmt->insert_id;
}

// Procesa varios archivos
$respuestas = [];
$carpeta = "../tareas_subidas/" . $materia . "/";
if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

foreach ($_FILES['archivo']['name'] as $key => $archivo) {
    $tmp = $_FILES['archivo']['tmp_name'][$key];
    if ($archivo && $tmp) {
        $ruta = $carpeta . time() . "_" . basename($archivo);
        if (move_uploaded_file($tmp, $ruta)) {
            // Guarda cada archivo
            $sql_archivo = "INSERT INTO tareas_archivos (id_tarea, nombre_archivo, ruta_archivo) VALUES (?, ?, ?)";
            $stmt_archivo = $conn->prepare($sql_archivo);
            $stmt_archivo->bind_param("iss", $id_tarea, $archivo, $ruta);
            $stmt_archivo->execute();
            $respuestas[] = $archivo . " subido correctamente.";
        } else {
            $respuestas[] = "❌ Error al subir " . $archivo;
        }
    }
}

echo json_encode(['mensaje' => 'Tu archivo se subió correctamente.']);
exit;
?>