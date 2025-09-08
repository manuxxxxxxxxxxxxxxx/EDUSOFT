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

$rubros = [
    'aula' => 'Aula (10%)',
    'integradora' => 'Integradora (30%)',
    'prueba_objetiva' => 'Prueba Objetiva (20%)',
    'examen_trimestral' => 'Examen Trimestral (30%)',
    'nota_formativa' => 'Nota Formativa (10%)',
];

// Guardar descripciones
if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_clase && $periodo) {
    foreach ($rubros as $clave => $nombre) {
        $descripcion = trim($_POST['descripciones'][$clave] ?? '');
        // Insertar o actualizar
        $sql = "INSERT INTO descripciones_rubros (id_clase, periodo, rubro, descripcion)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE descripcion=VALUES(descripcion)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $id_clase, $periodo, $clave, $descripcion);
        $stmt->execute();
    }
    echo "<div style='color:green'>Descripciones actualizadas correctamente.</div>";
}

// Cargar actuales
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
    <title>Editar descripciones de rubros</title>
    <style>
        body { font-family: Arial, sans-serif;}
        .desc-box {border:1px solid #bbb; background:#f7f9fb; border-radius:7px; padding:24px; max-width:600px; margin:35px auto;}
        textarea { width:99%; min-height:36px; border-radius:3px; border:1px solid #ddd; margin-bottom:11px;}
    </style>
</head>
<body>
<div class="desc-box">
    <h2>Editar descripciones de rubros</h2>
    <form method="GET">
        Clase:
        <select name="id_clase" onchange="this.form.submit()">
            <?php foreach($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                    <?= htmlspecialchars($clase['materia']) ?> (<?= htmlspecialchars($clase['nombre_clase']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        Periodo:
        <select name="periodo" onchange="this.form.submit()">
            <?php foreach($periodos as $p): ?>
                <option value="<?= $p ?>" <?= ($periodo==$p?'selected':'') ?>><?= $p ?></option>
            <?php endforeach; ?>
        </select>
        <noscript><button type="submit">Ver</button></noscript>
    </form>
    <form method="POST">
        <?php foreach($rubros as $clave => $nombre): ?>
            <label><b><?= $nombre ?></b></label>
            <textarea name="descripciones[<?= $clave ?>]"><?= htmlspecialchars($descripciones[$clave] ?? "") ?></textarea>
        <?php endforeach; ?>
        <button type="submit" style="padding:10px 30px;">Guardar descripciones</button>
    </form>
</div>
</body>
</html>