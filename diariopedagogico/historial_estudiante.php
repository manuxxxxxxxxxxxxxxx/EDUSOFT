<?php
session_start();
require_once "conexion.php";

// Usar la variable correcta para el id del estudiante
$id_estudiante = $_SESSION['id_estudiante'] ?? null;

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante' || !$id_estudiante) {
    echo "Acceso denegado.";
    exit;
}

// Consulta las observaciones y códigos de conducta del estudiante
$sql = "SELECT d.fecha, d.observacion, d.tipo_entrada, c.codigo AS codigo_conducta, c.descripcion AS descripcion_conducta,
               p.nombre AS nombre_profesor
        FROM diario_pedagogico d
        LEFT JOIN codigos_conducta c ON d.id_codigo = c.id
        LEFT JOIN profesores p ON d.id_profesor = p.id
        WHERE d.id_estudiante = ?
        ORDER BY d.fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_estudiante);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diario pedagógico - Historial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estudiantedp.css">
    
    <style>
        body { background: #f7f8fa; font-family: 'Poppins', sans-serif; }
        .container { margin-top: 40px; max-width: 900px; }
        .table { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 16px #e0e0e0; }
        h2 { font-weight: 700; margin-bottom: 24px; }
        .no-registros { margin: 40px 0; color: #888; font-size: 1.2em; text-align: center; }
        .th-profesor, .td-profesor { min-width: 150px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Diario pedagógico</h2>
    <?php if ($result->num_rows === 0): ?>
        <div class="no-registros">
            No tienes observaciones ni códigos registrados aún.
        </div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Observación</th>
                    <th class="th-profesor">Profesor</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['fecha']) ?></td>
                    <td><?= htmlspecialchars($row['tipo_entrada']) ?></td>
                    <td><?= htmlspecialchars($row['codigo_conducta'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['descripcion_conducta'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['observacion']) ?></td>
                    <td class="td-profesor"><?= htmlspecialchars($row['nombre_profesor']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="../cursos.php" class="btn btn-secondary mt-3">Volver a cursos</a>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>