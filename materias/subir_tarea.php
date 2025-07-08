<?php
session_start();
include '../conexiones/conexion.php'; // corregido

$id_estudiante = $_POST['id_estudiante'];
$materia = $_POST['materia'];
$archivo = $_FILES['archivo'];

$nombre = $archivo['name'];
$nombreUnico = uniqid() . '_' . $nombre;
$ruta = '../uploads/' . $nombreUnico; // asegúrate que ../uploads exista
$fecha = date('Y-m-d H:i:s');

if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
    $stmt = $conn->prepare("INSERT INTO tareas (id_estudiante, materia, nombre_archivo, ruta_archivo, fecha_subida) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_estudiante, $materia, $nombre, $ruta, $fecha);
    $stmt->execute();
    echo "✅ Tarea subida correctamente.";
    echo "<br><br><a href='biologia.php'><button>⬅️ Volver a Biología</button></a>";
} else {
    echo "❌ Error al subir el archivo.";
}
?>
