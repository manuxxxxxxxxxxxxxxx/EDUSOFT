<?php
session_start();
require_once "../conexiones/conexion.php";

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../login.php");
    exit;
}

$profesor_id = $_SESSION["id"];
$sql = "SELECT id, materia, nombre_clase FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();
$clases = [];
while ($row = $res->fetch_assoc()) $clases[] = $row;

$id_clase = isset($_GET['id_clase']) ? intval($_GET['id_clase']) : (count($clases) ? $clases[0]['id'] : 0);
$periodos = [1, 2, 3, 4];
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 1;

$materia = "";
foreach ($clases as $c) {
    if ($c['id'] == $id_clase) $materia = $c['materia'];
}

$alumnos = [];
if ($id_clase) {
    $sql = "SELECT e.ID, e.nombre 
            FROM clases_estudiantes ce 
            JOIN estudiantes e ON ce.id_estudiante = e.ID
            WHERE ce.id_clase = ?
            ORDER BY e.nombre ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_clase);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $alumnos[] = $row;
}
$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : (count($alumnos) ? $alumnos[0]['ID'] : 0);

$rubros = [
    'aula' => 'Aula (10%)',
    'integradora' => 'Integradora (30%)',
    'prueba_objetiva' => 'Prueba Objetiva (20%)',
    'examen_trimestral' => 'Examen Trimestral (30%)',
    'nota_formativa' => 'Nota Formativa (10%)',
];

// Cargar descripciones globales
$descripciones = [];
$sql = "SELECT rubro, descripcion FROM descripciones_rubros WHERE id_clase=? AND periodo=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_clase, $periodo);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $descripciones[$row['rubro']] = $row['descripcion'];

// Guardar notas SOLO para el alumno seleccionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notas']) && $id_clase && $materia && $id_alumno) {
    $campos = $_POST['notas'][$id_alumno];
    $sql_check = "SELECT id FROM notas_periodos WHERE id_alumno=? AND id_clase=? AND materia=? AND periodo=?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("iisi", $id_alumno, $id_clase, $materia, $periodo);
    $stmt->execute();
    $stmt->store_result();

    $vals = [];
    foreach ($rubros as $k=>$nombre) {
        $vals[$k] = isset($campos[$k]) && $campos[$k] !== "" ? floatval($campos[$k]) : null;
    }
    $prom = 0.0;
    if ($vals['aula'] !== null) $prom += 0.10 * $vals['aula'];
    if ($vals['integradora'] !== null) $prom += 0.30 * $vals['integradora'];
    if ($vals['prueba_objetiva'] !== null) $prom += 0.20 * $vals['prueba_objetiva'];
    if ($vals['examen_trimestral'] !== null) $prom += 0.30 * $vals['examen_trimestral'];
    if ($vals['nota_formativa'] !== null) $prom += 0.10 * $vals['nota_formativa'];

    if ($stmt->num_rows > 0) {
        $sql_update = "UPDATE notas_periodos SET aula=?, integradora=?, prueba_objetiva=?, examen_trimestral=?, nota_formativa=?, promedio_final=? WHERE id_alumno=? AND id_clase=? AND materia=? AND periodo=?";
        $stmt2 = $conn->prepare($sql_update);
        $stmt2->bind_param(
            "ddddddiisi",
            $vals['aula'], $vals['integradora'], $vals['prueba_objetiva'], $vals['examen_trimestral'], $vals['nota_formativa'], $prom,
            $id_alumno, $id_clase, $materia, $periodo
        );
        $stmt2->execute();
    } else {
        $sql_insert = "INSERT INTO notas_periodos (id_alumno, id_clase, materia, periodo, aula, integradora, prueba_objetiva, examen_trimestral, nota_formativa, promedio_final) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql_insert);
        $stmt2->bind_param(
            "iisiddddddd",
            $id_alumno, $id_clase, $materia, $periodo,
            $vals['aula'], $vals['integradora'], $vals['prueba_objetiva'], $vals['examen_trimestral'], $vals['nota_formativa'], $prom
        );
        $stmt2->execute();
    }
    echo "<div style='color:green'>Notas actualizadas correctamente.</div>";
}

// Cargar notas actuales de ese alumno
$nota = [];
if ($id_clase && $materia && $id_alumno) {
    $sql_n = "SELECT * FROM notas_periodos WHERE id_clase=? AND materia=? AND periodo=? AND id_alumno=?";
    $stmt = $conn->prepare($sql_n);
    $stmt->bind_param("isii", $id_clase, $materia, $periodo, $id_alumno);
    $stmt->execute();
    $res = $stmt->get_result();
    $nota = $res->fetch_assoc() ?: [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas - Profesor</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .alumno-box {
            border: 1px solid #bbb;
            margin-bottom: 20px;
            padding: 18px;
            border-radius: 6px;
            background: #f7f9fb;
            max-width: 550px;
        }
        .alumno-nombre {
            font-weight: bold;
            color: #1c3c5a;
            margin-bottom: 10px;
        }
        .rubro-group {
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px dotted #ccd;
        }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        .descripcion-global {font-size: 0.96em; color: #234;}
        input[type=number] {
            width: 80px; font-size: 1em; border-radius: 3px; border: 1px solid #ddd;
            padding: 4px; margin-bottom: 4px;
        }
        .promedio { color: #222; font-size: 1.1em; font-weight: bold; }
        .rubro-label { font-size: 1em; color: #24487c; }
        .form-filtros { margin-bottom:25px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;}
        .editar-link {margin-left:12px;}
    </style>
</head>
<body>
    <h2>Sistema de Notas (Profesor)</h2>
    <form method="GET" class="form-filtros">
        Clase/Materia:
        <select name="id_clase" onchange="this.form.submit()">
            <?php foreach($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                    <?= ucfirst($clase['materia']) ?> <?= htmlspecialchars($clase['nombre_clase']) ? '('.htmlspecialchars($clase['nombre_clase']).')' : '' ?>
                </option>
            <?php endforeach; ?>
        </select>
        Periodo:
        <select name="periodo" onchange="this.form.submit()">
            <?php foreach($periodos as $p): ?>
                <option value="<?= $p ?>" <?= ($periodo==$p?'selected':'') ?>><?= $p ?></option>
            <?php endforeach; ?>
        </select>
        Alumno:
        <select name="id_alumno" onchange="this.form.submit()">
            <?php foreach($alumnos as $alumno): ?>
                <option value="<?= $alumno['ID'] ?>" <?= ($id_alumno==$alumno['ID']?'selected':'') ?>>
                    <?= htmlspecialchars($alumno['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <a class="editar-link" href="editar_descripciones_rubros.php?id_clase=<?= $id_clase ?>&periodo=<?= $periodo ?>" style="color: #0a59a8;font-size:1em;">Editar descripciones de rubros</a>
        <noscript><button type="submit">Ver</button></noscript>
    </form>
    <?php if ($id_clase && $materia && $id_alumno): ?>
    <form method="POST">
        <div class="alumno-box">
            <div class="alumno-nombre">
                <?php
                    foreach ($alumnos as $a) { if ($a['ID'] == $id_alumno) echo htmlspecialchars($a['nombre']); }
                ?>
            </div>
            <?php foreach($rubros as $campo=>$nombre): ?>
                <div class="rubro-group">
                    <span class="rubro-label"><?= $nombre ?></span>
                    <span class="descripcion-global"><?= isset($descripciones[$campo]) ? htmlspecialchars($descripciones[$campo]) : '<i>No hay descripción</i>' ?></span>
                    <label for="nota_<?= $id_alumno ?>_<?= $campo ?>">Nota:</label>
                    <input name="notas[<?= $id_alumno ?>][<?= $campo ?>]" id="nota_<?= $id_alumno ?>_<?= $campo ?>" type="number" step="0.01" min="1" max="10"
                        value="<?= isset($nota[$campo]) ? htmlspecialchars($nota[$campo]) : '' ?>" />
                </div>
            <?php endforeach; ?>
            <div class="promedio">
                Promedio: <?= isset($nota['promedio_final']) ? number_format($nota['promedio_final'],2) : '-' ?>
            </div>
        </div>
        <button type="submit" style="font-size:1.1em;padding:10px 30px;">Guardar Notas</button>
    </form>
    <?php elseif ($id_clase && $materia): ?>
        <div style="color:#800">No hay alumnos en esta clase.</div>
    <?php else: ?>
        <div style="color:#800">Selecciona una clase/materia.</div>
    <?php endif; ?>
</body>
</html>