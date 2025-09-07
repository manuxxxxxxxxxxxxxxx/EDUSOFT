<?php
session_start();
require_once "../conexiones/conexion.php";

// Solo profesores pueden calificar
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    die("Acceso denegado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_tarea = intval($_POST['id_tarea']);
    $retroalimentacion = trim($_POST['retroalimentacion'] ?? '');

    // Procesar criterios de la rúbrica
    $criterios = [];
    $total_puntaje = 0;
    if (isset($_POST['criterio_nombre']) && is_array($_POST['criterio_nombre'])) {
        foreach ($_POST['criterio_nombre'] as $idx => $nombre) {
            $porcentaje = floatval($_POST['criterio_porcentaje'][$idx] ?? 0);
            $puntaje = floatval($_POST['criterio_puntaje'][$idx] ?? 0);

            // Aporte de este criterio a la nota final (puntaje * porcentaje / 100)
            $aporte = ($puntaje * $porcentaje) / 100;
            $total_puntaje += $aporte;

            $criterios[] = [
                'nombre' => $nombre,
                'porcentaje' => $porcentaje,
                'puntaje' => $puntaje,
                'aporte' => round($aporte, 2)
            ];
        }
    }

    // Guarda el desglose y la nota final
    $criterios_json = json_encode($criterios, JSON_UNESCAPED_UNICODE);
    $nota_final = round($total_puntaje, 2);

    // Actualiza la entrega en la base de datos (debe tener los campos calificacion_rubrica, calificacion, retroalimentacion)
    $stmt = $conn->prepare("UPDATE tareas SET calificacion_rubrica = ?, calificacion = ?, retroalimentacion = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $criterios_json, $nota_final, $retroalimentacion, $id_tarea);
    $stmt->execute();
    $stmt->close();

    // Redirecciona de vuelta (a la sección de entregas, ajusta si lo necesitas)
    if (isset($_POST['id_tarea_profesor'])) {
        header("Location: ../maestros/index.php?ver_entregas=1&id_tarea_profesor=" . intval($_POST['id_tarea_profesor']));
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    exit;
}
?>