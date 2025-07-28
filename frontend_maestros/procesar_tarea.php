<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar que sea un profesor
if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../Registros/inicioProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"];

// Obtener datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$puntos = $_POST['puntos'];
$fecha_entrega = $_POST['fecha_entrega'];
$tema = $_POST['tema'];
$id_clase = intval($_POST['id_clase']);

// Verificar que el profesor sea dueño de la clase
$sql = "SELECT materia FROM clases WHERE id = ? AND profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_clase, $profesor_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Error: No tienes acceso a esta clase.");
}

$clase = $resultado->fetch_assoc();
$materia = $clase['materia']; // Ej: biologia, matematicas, etc.

// Procesar el primer archivo (puedes expandir a múltiples si quieres más adelante)
$ruta_guardada = null;
if (isset($_FILES['material']['name'][0]) && $_FILES['material']['error'][0] == 0) {
    $archivo_nombre = $_FILES['material']['name'][0];
    $archivo_tmp = $_FILES['material']['tmp_name'][0];
    $carpeta_destino = "../archivos_tareas/";

    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    $ruta_guardada = $carpeta_destino . time() . "_" . basename($archivo_nombre);
    move_uploaded_file($archivo_tmp, $ruta_guardada);
}

// Insertar la tarea en la base de datos
$sql_insert = "INSERT INTO tareas_profesor (id_clase, titulo, descripcion, puntos, fecha_entrega, tema, ruta_archivo)
               VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("ississs", $id_clase, $titulo, $descripcion, $puntos, $fecha_entrega, $tema, $ruta_guardada);
$stmt->execute();

// Redireccionar dinámicamente a la materia
header("Location: ../materias/$materia.php?id_clase=$id_clase");
exit;
?>
