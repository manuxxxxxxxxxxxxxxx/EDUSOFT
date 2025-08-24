<?php
require_once "../conexiones/conexion.php";
$id_tarea = $_POST['id_tarea'];
$sql = "DELETE FROM tareas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tarea);
$stmt->execute();
echo "Entrega eliminada.";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("SELECT ruta_archivo FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($ruta_archivo);
    if ($stmt->fetch()) {
        $stmt->close();

        // Borrar de base de datos
        $deleteStmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        if ($deleteStmt->execute()) {
            $deleteStmt->close();

            // Borrar archivo del sistema
            if (file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
            }
            echo "OK";
        } else {
            echo "Error";
        }
    } else {
        echo "No encontrado";
    }
} else {
    echo "Petición inválida";
}
?>
