<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID faltante']);
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "edusoft");
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}
$id = intval($_POST['id']);
$query = "DELETE FROM citas WHERE id = $id";
$success = $mysqli->query($query);
echo json_encode(['success' => $success]);
?>