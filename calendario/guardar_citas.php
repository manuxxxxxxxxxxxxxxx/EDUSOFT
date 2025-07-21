<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['title']) || !isset($data['start'])) {
    echo json_encode(['success' => false]);
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "edusoft");
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false]);
    exit;
}

$title = $mysqli->real_escape_string($data['title']);
$start = $mysqli->real_escape_string($data['start']);
$end = isset($data['end']) ? $mysqli->real_escape_string($data['end']) : null;
$query = "INSERT INTO citas (title, start, end) VALUES ('$title', '$start', " . ($end ? "'$end'" : "NULL") . ")";
$success = $mysqli->query($query);

echo json_encode(['success' => $success]);
?>