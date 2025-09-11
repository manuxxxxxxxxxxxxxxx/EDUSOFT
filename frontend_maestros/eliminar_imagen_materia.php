<?php
session_start();
require_once '../conexiones/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_clase'])) {
    $id_clase = intval($_POST['id_clase']);

    // Opcional: primero trae la ruta, y si es archivo local, lo borra físicamente
    $stmt = $conn->prepare("SELECT imagen_materia FROM clases WHERE id = ?");
    $stmt->bind_param("i", $id_clase);
    $stmt->execute();
    $stmt->bind_result($ruta_actual);
    $stmt->fetch();
    $stmt->close();

    // Si es imagen local, la borra físicamente
    if ($ruta_actual && substr($ruta_actual, 0, 3) === '../') {
        $ruta_fisica = realpath($ruta_actual);
        if ($ruta_fisica && file_exists($ruta_fisica)) {
            unlink($ruta_fisica);
        }
    }

    // Borra la referencia en la base de datos
    $stmt = $conn->prepare("UPDATE clases SET imagen_materia = NULL WHERE id = ?");
    $stmt->bind_param("i", $id_clase);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?imagen_eliminada=1");
    exit;
} else {
    echo "Error al eliminar la imagen.";
}
?>