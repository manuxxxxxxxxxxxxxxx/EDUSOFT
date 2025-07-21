<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "edusoft");
if ($mysqli->connect_errno) {
    echo "[]";
    exit;
}
$result = $mysqli->query("SELECT id, title, start, end FROM citas");
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => strval($row['id']),
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end']
    ];
}
echo json_encode($events);
?>