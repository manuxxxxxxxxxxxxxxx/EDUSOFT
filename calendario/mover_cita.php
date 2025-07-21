<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['start'])) {
    echo json_encode(['success' => false]);
    exit;
}
$mysqli = new mysqli("localhost", "TU_USUARIO", "TU_PASSWORD", "TU_BASEDATOS");
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false]);
    exit;
}
$id = intval($data['id']);
$start = $mysqli->real_escape_string($data['start']);
$end = isset($data['end']) ? $mysqli->real_escape_string($data['end']) : null;
$query = "UPDATE citas SET start = '$start', end = " . ($end ? "'$end'" : "NULL") . " WHERE id = $id";
$success = $mysqli->query($query);
echo json_encode(['success' => $success]);
?>