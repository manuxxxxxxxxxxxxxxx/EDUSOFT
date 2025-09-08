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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="notas_profe.css">
    <style>
    /* Botón de regresar arriba */
     #btn-back {
        position: fixed;
        left: 32px;
        top: 32px;
        z-index: 99;
        background: linear-gradient(90deg, #0a0a0aff, #0f0f0fff);
        color: #fff;
        border: none;
        outline: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        box-shadow: 0 6px 24px #8d72e144;
        cursor: pointer;
        font-size: 1.8rem;
        transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #btn-back:hover {
        background: linear-gradient(90deg, #8d72e1, #67b6fa);
        box-shadow: 0 10px 30px #67b6fa55;
        transform: translateY(-2px) scale(1.06);
    }
    @media (max-width:600px){
        #btn-back {
            left: 12px;
            top: 12px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
    </style>
</head>
<body>
     <button id="btn-back" title="Volver" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
    </button>
    <div id="main-container">
        <h2>
            <i class="fas fa-chalkboard-teacher"></i>
            Sistema de Notas (Profesor)
        </h2>
        <form method="GET" class="form-filtros">
            <span><i class="fas fa-book"></i> Clase/Materia:</span>
            <select name="id_clase" onchange="this.form.submit()">
                <?php foreach($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                        <?= ucfirst($clase['materia']) ?> <?= htmlspecialchars($clase['nombre_clase']) ? '('.htmlspecialchars($clase['nombre_clase']).')' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span><i class="fas fa-calendar-alt"></i> Periodo:</span>
            <select name="periodo" onchange="this.form.submit()">
                <?php foreach($periodos as $p): ?>
                    <option value="<?= $p ?>" <?= ($periodo==$p?'selected':'') ?>><?= $p ?></option>
                <?php endforeach; ?>
            </select>
            <span><i class="fas fa-user-graduate"></i> Alumno:</span>
            <select name="id_alumno" onchange="this.form.submit()">
                <?php foreach($alumnos as $alumno): ?>
                    <option value="<?= $alumno['ID'] ?>" <?= ($id_alumno==$alumno['ID']?'selected':'') ?>>
                        <?= htmlspecialchars($alumno['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a class="editar-link" href="editar_descripciones_rubros.php?id_clase=<?= $id_clase ?>&periodo=<?= $periodo ?>">
                <i class="fas fa-edit"></i> Editar descripciones de rubros
            </a>
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
            <button type="submit">
                <i class="fas fa-save"></i> Guardar Notas
            </button>
        </form>
        <?php elseif ($id_clase && $materia): ?>
            <div style="color:#800">No hay alumnos en esta clase.</div>
        <?php else: ?>
            <div style="color:#800">Selecciona una clase/materia.</div>
        <?php endif; ?>
    </div>
    <!-- Botón scroll top -->

    <!-- FontAwesome CDN, solo si no lo tienes ya en el proyecto -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        // Mostrar el botón al hacer scroll
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            let btn = document.getElementById("btn-top");
            if (document.body.scrollTop > 160 || document.documentElement.scrollTop > 160) {
                btn.style.display = "flex";
            } else {
                btn.style.display = "none";
            }
        }
        // Scroll suave hacia arriba
        document.getElementById('btn-top').onclick = function() {
            window.scrollTo({top:0, behavior:'smooth'});
        };
    </script>
</body>
</html>