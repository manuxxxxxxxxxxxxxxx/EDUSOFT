<?php
require_once "../conexiones/conexion.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../loginProfes.php");
    exit;
}

$id_entrega = isset($_GET['id_entrega']) ? intval($_GET['id_entrega']) : null;
$id_tarea_profesor = isset($_GET['id_tarea_profesor']) ? intval($_GET['id_tarea_profesor']) : null;

if (!$id_entrega || !$id_tarea_profesor) {
    echo "Error: Falta id de entrega o id de tarea.";
    exit;
}

// Obtener datos de la entrega
$sql = "SELECT t.*, e.nombre AS nombre_alumno, tp.titulo AS nombre_tarea, tp.descripcion AS descripcion_tarea
        FROM tareas t
        JOIN estudiantes e ON t.id_estudiante = e.ID
        JOIN tareas_profesor tp ON t.id_tarea_profesor = tp.id
        WHERE t.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_entrega);
$stmt->execute();
$res = $stmt->get_result();
$entrega = $res->fetch_assoc();
$stmt->close();

if (!$entrega) {
    echo "Entrega no encontrada.";
    exit;
}

// Obtener archivos entregados para la tarea
$stmt_archivos = $conn->prepare("SELECT nombre_archivo, ruta_archivo FROM tareas_archivos WHERE id_tarea = ?");
$stmt_archivos->bind_param("i", $id_entrega);
$stmt_archivos->execute();
$res_archivos = $stmt_archivos->get_result();
$archivos = [];
while ($row = $res_archivos->fetch_assoc()) {
    $archivos[] = $row;
}
$stmt_archivos->close();

// Obtener la rubrica de la tarea
$stmt_rubrica = $conn->prepare("SELECT criterios_json FROM rubricas WHERE id_tarea = ?");
$stmt_rubrica->bind_param("i", $id_tarea_profesor);
$stmt_rubrica->execute();
$stmt_rubrica->bind_result($criterios_json);
$stmt_rubrica->fetch();
$stmt_rubrica->close();

$criterios = [];
if ($criterios_json) {
    $criterios = json_decode($criterios_json, true);
}

// Obtener puntajes guardados por criterio (si ya se calificó antes)
$calificacion_rubrica = [];
if (!empty($entrega['calificacion_rubrica'])) {
    $calificacion_rubrica = json_decode($entrega['calificacion_rubrica'], true);
}

// Procesar calificación y retroalimentación
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_calificacion'])) {
    $calificacion = $_POST['calificacion'];
    $retroalimentacion = trim($_POST['retroalimentacion']);

    // Guardar puntajes por criterio (rubrica)
    $rubrica_puntajes = [];
    foreach ($criterios as $i => $c) {
        $key = "criterio_puntaje_$i";
        $puntaje = isset($_POST[$key]) ? floatval($_POST[$key]) : 1; // default mínimo
        if ($puntaje < 1) $puntaje = 1;
        if ($puntaje > 10) $puntaje = 10;
        $rubrica_puntajes[] = [
            "nombre" => $c['nombre'],
            "porcentaje" => $c['porcentaje'],
            "puntaje" => $puntaje
        ];
    }
    $calificacion_rubrica_json = json_encode($rubrica_puntajes, JSON_UNESCAPED_UNICODE);

    // Limitar calificacion final entre 1 y 10
    $calificacion = floatval($calificacion);
    if ($calificacion < 1) $calificacion = 1;
    if ($calificacion > 10) $calificacion = 10;

    // Guarda la calificacion normal y la rubrica
    $stmt = $conn->prepare("UPDATE tareas SET calificacion = ?, retroalimentacion = ?, calificacion_rubrica = ? WHERE id = ?");
    $stmt->bind_param("sssi", $calificacion, $retroalimentacion, $calificacion_rubrica_json, $id_entrega);
    $stmt->execute();
    $stmt->close();
    header("Location: revision_entrega.php?id_entrega=$id_entrega&id_tarea_profesor=$id_tarea_profesor&guardado=1");
    exit;
}

// Mostrar mensaje si se guardó
$mensaje = "";
if (isset($_GET['guardado'])) {
    $mensaje = "¡Calificación y retroalimentación guardadas!";
}

function is_image($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
}

function is_pdf($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return $ext === 'pdf';
}

// Calcula la calificación sugerida (ponderada)
function calcularCalificacionRubrica($criterios, $puntajes) {
    $total = 0;
    foreach ($criterios as $i => $c) {
        $porcentaje = isset($c['porcentaje']) ? $c['porcentaje'] : 0;
        $puntaje = isset($puntajes[$i]['puntaje']) ? $puntajes[$i]['puntaje'] : 1;
        if ($puntaje < 1) $puntaje = 1;
        if ($puntaje > 10) $puntaje = 10;
        $total += ($porcentaje / 100) * $puntaje;
    }
    // Limita entre 1 y 10
    if ($total < 1) $total = 1;
    if ($total > 10) $total = 10;
    return number_format($total, 2);
}

// Inicializar valores para inputs
$rubrica_input_values = [];
foreach ($criterios as $i => $c) {
    $rubrica_input_values[$i] = isset($calificacion_rubrica[$i]['puntaje']) ? $calificacion_rubrica[$i]['puntaje'] : 1;
}
$sugerido = calcularCalificacionRubrica($criterios, array_map(function($v, $i) { return ['puntaje' => $v]; }, $rubrica_input_values, array_keys($rubrica_input_values)));

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisión de entrega | Edusoft</title>
    <link rel="stylesheet" href="/frontend_maestros/stylemaestro.css">
    <style>
    .preview-img {max-width:350px;max-height:350px;display:block;margin-top:8px;}
    .preview-pdf {width:100%;height:450px;display:block;border:1px solid #ddd;margin-top:8px;}
    .rubrica-table {width:100%;border-collapse:collapse;margin-bottom:10px;}
    .rubrica-table th, .rubrica-table td {padding:6px 10px;border:1px solid #ccc;text-align:left;}
    .rubrica-table th {background:#f9f9f9;}
    .criterio-input {width:60px;}
    </style>
    <link rel="stylesheet" href="revision.css">
    <script>
    // JS para recalcular la calificación sugerida en tiempo real
    function recalcularCalificacion() {
        var criterios = document.querySelectorAll('.criterio-input');
        var porcentajes = document.querySelectorAll('.criterio-porcentaje');
        var total = 0;
        for(var i=0; i<criterios.length; i++){
            var puntaje = parseFloat(criterios[i].value) || 1;
            if (puntaje < 1) puntaje = 1;
            if (puntaje > 10) puntaje = 10;
            var porcentaje = parseFloat(porcentajes[i].textContent) || 0;
            total += puntaje * porcentaje / 100;
        }
        if (total < 1) total = 1;
        if (total > 10) total = 10;
        document.getElementById('calificacion_sugerida').textContent = total.toFixed(2);
        document.getElementById('calificacion').value = total.toFixed(2);
    }
    </script>
</head>
<body>
    <div class="main-content" style="max-width:700px;margin:40px auto;background:#fff;padding:32px;border-radius:12px;">
        <h2>Revisión de entrega</h2>
        <?php if ($mensaje): ?>
            <div style="color:green;margin-bottom:16px;"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <h3>Tarea: <?= htmlspecialchars($entrega['nombre_tarea'] ?? '') ?></h3>
        <p><b>Alumno:</b> <?= htmlspecialchars($entrega['nombre_alumno'] ?? '') ?></p>
        <p><b>Fecha de entrega:</b> <?= htmlspecialchars($entrega['fecha_subida'] ?? '') ?></p>
        <p><b>Descripción de la tarea:</b> <?= htmlspecialchars($entrega['descripcion_tarea'] ?? '') ?></p>
        <hr>
        <?php if (count($criterios) > 0): ?>
            <h4>Rúbrica de evaluación</h4>
            <form method="POST" action="">
            <table class="rubrica-table">
                <tr><th>Criterio</th><th>Porcentaje</th><th>Puntaje (1-10)</th></tr>
                <?php foreach ($criterios as $i => $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td class="criterio-porcentaje"><?= htmlspecialchars($c['porcentaje']) ?></td>
                        <td>
                            <input type="number" step="0.01" min="1" max="10" name="criterio_puntaje_<?= $i ?>" class="criterio-input"
                            value="<?= htmlspecialchars($rubrica_input_values[$i]) ?>" oninput="recalcularCalificacion()">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p><b>Calificación sugerida (suma ponderada): <span id="calificacion_sugerida"><?= $sugerido ?></span></b></p>
            <label for="calificacion"><b>Calificación final (1-10):</b></label>
            <input type="number" step="0.01" min="1" max="10" name="calificacion" id="calificacion" value="<?= htmlspecialchars($entrega['calificacion'] ?? $sugerido) ?>" style="width:80px;">
            <br>
            <label for="retroalimentacion"><b>Retroalimentación:</b></label><br>
            <textarea name="retroalimentacion" id="retroalimentacion" rows="4" style="width:100%;"><?= htmlspecialchars($entrega['retroalimentacion'] ?? '') ?></textarea>
            <br>
            <button type="submit" name="guardar_calificacion" style="margin-top:12px;">Guardar cambios</button>
            <a href="index.php?ver_entregas=1&id_tarea_profesor=<?= $id_tarea_profesor ?>" style="margin-left:22px;">← Volver a entregas</a>
            </form>
            <hr>
        <?php endif; ?>
        <h4>Archivos Entregados</h4>
        <?php if (count($archivos) > 0): ?>
            <?php foreach ($archivos as $archivo): ?>
                <a href="<?= htmlspecialchars($archivo['ruta_archivo']) ?>" target="_blank" download>
                    Descargar archivo (<?= htmlspecialchars($archivo['nombre_archivo']) ?>)
                </a><br>
                <?php if (is_image($archivo['nombre_archivo'])): ?>
                    <img src="<?= htmlspecialchars($archivo['ruta_archivo']) ?>" alt="Vista previa imagen" class="preview-img">
                <?php endif; ?>
                <?php if (is_pdf($archivo['nombre_archivo'])): ?>
                    <embed src="<?= htmlspecialchars($archivo['ruta_archivo']) ?>" type="application/pdf" class="preview-pdf"/>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay archivo entregado.</p>
        <?php endif; ?>
        <?php if (!empty($entrega['texto_entrega'])): ?>
            <h4>Texto Entregado</h4>
            <pre style="background:#f7f7f7;padding:12px;border-radius:6px;"><?= htmlspecialchars($entrega['texto_entrega']) ?></pre>
        <?php endif; ?>
    </div>
    <script>
    window.onload = recalcularCalificacion;
    </script>
</body>
</html>