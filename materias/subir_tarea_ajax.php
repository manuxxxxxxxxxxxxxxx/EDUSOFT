<?php
session_start();
include '../conexiones/conexion.php';

if (!isset($_SESSION['id_estudiante'])) {
    http_response_code(403);
    echo "No autorizado.";
    exit;
}

$id_estudiante = $_SESSION['id_estudiante'];
$materia = $_POST['materia'];
$archivo = $_FILES['archivo'];

$nombre = $archivo['name'];
$nombreUnico = uniqid() . '_' . $nombre;
$ruta = '../uploads/' . $nombreUnico;
$fecha = date('Y-m-d H:i:s');

if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
    $stmt = $conn->prepare("INSERT INTO tareas (id_estudiante, materia, nombre_archivo, ruta_archivo, fecha_subida) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_estudiante, $materia, $nombre, $ruta, $fecha);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "mensaje" => "✅ Tarea subida correctamente.",
        "archivo" => [
            "nombre" => $nombre,
            "ruta" => $ruta,
            "fecha" => $fecha
        ]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error al subir el archivo."
    ]);
}
?>