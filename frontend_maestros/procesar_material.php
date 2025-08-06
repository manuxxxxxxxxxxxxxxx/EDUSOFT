<?php
session_start();
require_once "../conexiones/conexion.php";

// Verifica que el profesor esté logueado
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    echo "⚠️ No tienes permisos para realizar esta acción.";
    exit;
}

$profesor_id = $_SESSION["id"];

// Validar datos del formulario
if (!isset($_POST["id_clase"], $_POST["titulo"]) || empty($_FILES["archivo"]["name"])) {
    echo "❌ Todos los campos son obligatorios.";
    exit;
}

$id_clase = $_POST["id_clase"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"] ?? '';

// Procesar archivo subido
$archivo_nombre = $_FILES["archivo"]["name"];
$archivo_temporal = $_FILES["archivo"]["tmp_name"];
$archivo_tipo = $_FILES["archivo"]["type"];
$archivo_error = $_FILES["archivo"]["error"];
$archivo_size = $_FILES["archivo"]["size"];

if ($archivo_error !== UPLOAD_ERR_OK) {
    echo "⚠️ Error al subir el archivo.";
    exit;
}

// Ruta de guardado
$directorio = "../materiales_subidos/";
if (!is_dir($directorio)) {
    mkdir($directorio, 0755, true); // Crea el directorio si no existe
}

$nombre_final = uniqid() . "_" . basename($archivo_nombre);
$ruta_archivo = $directorio . $nombre_final;

// Mover archivo al servidor
if (!move_uploaded_file($archivo_temporal, $ruta_archivo)) {
    echo "⚠️ No se pudo guardar el archivo.";
    exit;
}

// Guardar en la base de datos
$sql = "INSERT INTO materiales_estudio (id_clase, titulo, descripcion, archivo, ruta_archivo, fecha_subida) 
        VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $id_clase, $titulo, $descripcion, $archivo_nombre, $ruta_archivo);

if ($stmt->execute()) {
    header("Location: ../frontend_maestros");
    exit;
} else {
    echo "❌ Error al guardar en la base de datos.";
}
?>
