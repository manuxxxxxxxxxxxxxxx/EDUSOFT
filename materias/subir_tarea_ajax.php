<?php
session_start();
header("Content-Type: application/json");
include '../conexiones/conexion.php';

if (!isset($_SESSION['id_estudiante'])) {
    echo json_encode(["success" => false, "mensaje" => "No autorizado"]);
    exit;
}

$id_estudiante = $_SESSION['id_estudiante'];
$materia = $_POST['materia'];

if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] != 0) {
    echo json_encode(["success" => false, "mensaje" => "❌ Error al subir el archivo"]);
    exit;
}

// Ruta y nombre del archivo
$nombreArchivo = basename($_FILES['archivo']['name']);
$carpeta = "tareas_subidas/" . $materia . "/";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$nombreUnico = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $nombreArchivo);
$rutaCompleta = $carpeta . $nombreUnico;

if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaCompleta)) {
    $fecha = date("Y-m-d H:i:s");

    // Guardar en BD
    $stmt = $conn->prepare("INSERT INTO tareas (id_estudiante, materia, ruta_archivo, nombre_archivo, fecha_subida) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_estudiante, $materia, $rutaCompleta, $nombreArchivo, $fecha);
    
    if ($stmt->execute()) {
        $id_insertado = $stmt->insert_id;

        echo json_encode([
            "success" => true,
            "mensaje" => "✅ Tarea subida exitosamente.",
            "archivo" => [
                "id" => $id_insertado,
                "nombre" => $nombreArchivo,
                "ruta" => $rutaCompleta,
                "fecha" => date("d/m/Y H:i", strtotime($fecha))
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "❌ Error al guardar en la base de datos."]);
    }
} else {
    echo json_encode(["success" => false, "mensaje" => "❌ No se pudo mover el archivo."]);
}
?>
