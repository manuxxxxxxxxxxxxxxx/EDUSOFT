<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['start'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "edusoft");
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}
$id = intval($data['id']);
$title = isset($data['title']) ? $mysqli->real_escape_string($data['title']) : null;
$start = $mysqli->real_escape_string($data['start']);
$end = isset($data['end']) ? $mysqli->real_escape_string($data['end']) : null;

$query = "UPDATE citas SET start = '$start', end = " . ($end ? "'$end'" : "NULL");
if ($title !== null) {
    $query .= ", title = '$title'";
}
$query .= " WHERE id = $id";

$success = $mysqli->query($query);
echo json_encode(['success' => $success]);
?>