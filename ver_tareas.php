<?php
session_start();
include 'conexiones/conexion.php'; // Ajusta si lo pones en la raíz

$sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE materia = 'biologia'";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas de Biología</title>
</head>
<body>
    <h2>Tareas subidas por los estudiantes</h2>
    <ul>
    <?php
    while ($fila = $resultado->fetch_assoc()) {
        echo "<li><a href='" . $fila['ruta_archivo'] . "' target='_blank'>" . $fila['nombre_archivo'] . "</a> - Subido el " . $fila['fecha_subida'] . "</li>";
    }
    ?>
    </ul>
</body>
</html>