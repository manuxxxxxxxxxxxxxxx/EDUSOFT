<?php
require_once "../conexiones/conexion.php";
$id_entrega = $_POST['id_entrega'];
// Borra archivos físicos primero
$sql_files = "SELECT ruta_archivo FROM tareas_archivos WHERE id_tarea = ?";
$stmt_files = $conn->prepare($sql_files);
$stmt_files->bind_param("i", $id_entrega);
$stmt_files->execute();
$result_files = $stmt_files->get_result();
while ($row = $result_files->fetch_assoc()) {
    @unlink($row['ruta_archivo']);
}
// Borra registros en tareas_archivos
$sql_del_files = "DELETE FROM tareas_archivos WHERE id_tarea = ?";
$stmt_del_files = $conn->prepare($sql_del_files);
$stmt_del_files->bind_param("i", $id_entrega);
$stmt_del_files->execute();
// Borra registro en tareas
$sql_del_entrega = "DELETE FROM tareas WHERE id = ?";
$stmt_del_entrega = $conn->prepare($sql_del_entrega);
$stmt_del_entrega->bind_param("i", $id_entrega);
$stmt_del_entrega->execute();
echo "Entrega eliminada.";
?>