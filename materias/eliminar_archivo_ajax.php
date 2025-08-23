<?php
require_once "../conexiones/conexion.php";
$id_archivo = $_POST['id_archivo'];
// Borra físico primero si quieres (opcional)
$sql_file = "SELECT ruta_archivo FROM tareas_archivos WHERE id = ?";
$stmt_file = $conn->prepare($sql_file);
$stmt_file->bind_param("i", $id_archivo);
$stmt_file->execute();
$result_file = $stmt_file->get_result();
if ($row = $result_file->fetch_assoc()) {
    @unlink($row['ruta_archivo']);
}
$sql = "DELETE FROM tareas_archivos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_archivo);
$stmt->execute();
echo "Archivo eliminado.";
?>