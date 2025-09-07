<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar que sea un profesor
if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../Registros/inicioProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_entrega = $_POST['fecha_entrega']; // Unificado y será el único campo de fecha
$tema = $_POST['tema'];
$id_clase = intval($_POST['id_clase']);

// NUEVO: Recoger la categoría de la tarea
$categoria_tarea = isset($_POST['categoria_tarea']) ? $_POST['categoria_tarea'] : 'normal';

// Verificar que el profesor sea dueño de la clase
$sql = "SELECT materia FROM clases WHERE id = ? AND profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_clase, $profesor_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($resultado->num_rows === 0) {
    die("Error: No tienes acceso a esta clase.");
}

// Procesar el primer archivo adjunto
$archivo_adjunto = null;
if (isset($_FILES['material']['name'][0]) && $_FILES['material']['error'][0] == 0) {
    $archivo_nombre = $_FILES['material']['name'][0];
    $archivo_tmp = $_FILES['material']['tmp_name'][0];
    $carpeta_destino = "../archivos_tareas/";
    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    $archivo_adjunto = $carpeta_destino . time() . "_" . basename($archivo_nombre);
    move_uploaded_file($archivo_tmp, $archivo_adjunto);
}

// Conversion robusta del formato de fecha
function convertirFecha($fecha) {
    if (strpos($fecha, 'T') !== false) {
        $fecha = str_replace('T', ' ', $fecha) . ':00';
    }
    // Si solo viene como 'YYYY-MM-DD HH:MM', añade segundos
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $fecha)) {
        $fecha .= ':00';
    }
    return $fecha;
}
$fecha_entrega = convertirFecha($fecha_entrega);

// Insertar la tarea en la base de datos (solo UNA fecha: fecha_entrega y categoría)
$sql_insert = "INSERT INTO tareas_profesor (id_clase, titulo, descripcion, fecha_limite, tema, archivo_adjunto, categoria_tarea)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("issssss", $id_clase, $titulo, $descripcion, $fecha_entrega, $tema, $archivo_adjunto, $categoria_tarea);
$stmt->execute();
$id_tarea = $stmt->insert_id;

// Guardar la rúbrica asociada
if ($id_tarea) {
    $rubrica_titulo = $_POST['rubrica_titulo'];
    $rubrica_descripcion = $_POST['rubrica_descripcion'];
    $criterio_nombres = $_POST['criterio_nombre'];
    $criterio_porcentajes = $_POST['criterio_porcentaje'];

    // Construir el array de criterios con porcentaje
    $criterios = [];
    $suma = 0;
    for ($i = 0; $i < count($criterio_nombres); $i++) {
        $nombre = trim($criterio_nombres[$i]);
        $porcentaje = intval($criterio_porcentajes[$i]);
        if ($nombre !== "" && $porcentaje > 0) {
            $criterios[] = [
                "nombre" => $nombre,
                "porcentaje" => $porcentaje
            ];
            $suma += $porcentaje;
        }
    }
    // Validar que la suma sea 100%
    if ($suma !== 100) {
        die("La suma de los porcentajes debe ser exactamente 100%.");
    }
    $criterios_json = json_encode($criterios, JSON_UNESCAPED_UNICODE);

    // Insertar la rúbrica
    $sql_rubrica = "INSERT INTO rubricas (id_tarea, titulo, descripcion, criterios_json) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_rubrica);
    $stmt->bind_param("isss", $id_tarea, $rubrica_titulo, $rubrica_descripcion, $criterios_json);
    $stmt->execute();
}

// Redireccionar a subir_tarea.php con modal de éxito
header("Location: ../frontend_maestros/subir_tarea.php?id_clase=$id_clase&exito=1");
exit;
?>