<?php
session_start();
require_once "../conexiones/conexion.php";
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "alumno") {
    header("Location: ../login.php");
    exit;
}
$id_alumno = $_SESSION["id_estudiante"];

// Clases donde está inscrito
$sql = "SELECT c.id, c.materia, c.nombre_clase FROM clases_estudiantes ce
        JOIN clases c ON ce.id_clase = c.id
        WHERE ce.id_estudiante = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$res = $stmt->get_result();
$clases = [];
while ($row = $res->fetch_assoc()) $clases[] = $row;

$id_clase = isset($_GET['id_clase']) ? intval($_GET['id_clase']) : (count($clases) ? $clases[0]['id'] : 0);
$periodos = [1,2,3,4];
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 1;

$notas = [];
if ($id_clase) {
    $sql_n = "SELECT * FROM notas_periodos WHERE id_clase=? AND id_alumno=? AND periodo=?";
    $stmt = $conn->prepare($sql_n);
    $stmt->bind_param("iii", $id_clase, $id_alumno, $periodo);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) $notas = $row;
}

$rubros = [
    'aula' => 'Aula (10%)',
    'integradora' => 'Integradora (30%)',
    'prueba_objetiva' => 'Prueba Objetiva (20%)',
    'examen_trimestral' => 'Examen Trimestral (30%)',
    'nota_formativa' => 'Nota Formativa (10%)',
];

// Cargar descripciones globales de rubros
$descripciones = [];
$sql = "SELECT rubro, descripcion FROM descripciones_rubros WHERE id_clase=? AND periodo=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_clase, $periodo);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $descripciones[$row['rubro']] = $row['descripcion'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas del Alumno</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .notas-box {border:1px solid #bbb;margin:30px auto;max-width:600px;padding:22px;border-radius:10px;background:#f7f9fb;}
        .rubro {margin-bottom:15px;}
        .rubro-nombre {font-weight:bold; color:#24487c;}
        .desc {font-size:0.97em;color:#234;}
        .promedio {color:#191970;font-size:1.35em;font-weight:bold;padding-top:10px;}
    </style>
</head>
<body>
    <div class="notas-box">
        <h2>Notas de <?= htmlspecialchars($_SESSION["nombre"]) ?></h2>
        <form method="GET">
            Clase:
            <select name="id_clase" onchange="this.form.submit()">
                <?php foreach($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                        <?= htmlspecialchars($clase['materia']) ?> <?= $clase['nombre_clase'] ? '('.$clase['nombre_clase'].')' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            Periodo:
            <select name="periodo" onchange="this.form.submit()">
                <?php foreach($periodos as $p): ?>
                    <option value="<?= $p ?>" <?= ($periodo==$p?'selected':'') ?>><?= $p ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <?php if ($notas): ?>
            <?php foreach($rubros as $campo=>$nombre): ?>
                <div class="rubro">
                    <span class="rubro-nombre"><?= $nombre ?>:</span>
                    <span><?= isset($notas[$campo]) ? number_format($notas[$campo],2) : '-' ?></span><br>
                    <span class="desc"><?= isset($descripciones[$campo]) ? htmlspecialchars($descripciones[$campo]) : '<i>No hay descripción</i>' ?></span>
                </div>
            <?php endforeach; ?>
            <div class="promedio">
                Promedio Final: <?= isset($notas['promedio_final']) ? number_format($notas['promedio_final'],2) : '-' ?>
            </div>
        <?php else: ?>
            <div style="color:#a00">No hay notas registradas para esta clase y periodo.</div>
        <?php endif; ?>
    </div>
</body>
</html>