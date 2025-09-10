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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas del Alumno - EduSoft</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="notas_alumno.css">
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
    <button id="btn-back" title="Volver" onclick="window.location.href='../registrosCards/inicio.php';">
        <i class="fas fa-arrow-left"></i>
    </button>

    <div class="table-container">
        <div class="header" style="background:transparent; margin:0; padding-bottom:8px;">
            <h1 style="font-size:1.7rem; margin-bottom:0;">
                <i class="fas fa-graduation-cap"></i> EduSoft
            </h1>
            <p class="subtitle" style="margin:0; color:#667eea;">
                Sistema de Gestión Académica - Notas de <?= htmlspecialchars($_SESSION["nombre"]) ?>
            </p>
        </div>

        <!-- Controls -->
        <div class="controls-card" style="margin-bottom:28px;">
            <div class="controls-title">
                <i class="fas fa-sliders-h"></i>
                Filtros de Consulta
            </div>
            <form method="GET" class="controls-form">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-book"></i> Seleccionar Clase
                    </label>
                    <select name="id_clase" class="form-select" onchange="this.form.submit()">
                        <?php foreach($clases as $clase): ?>
                            <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                                <?= htmlspecialchars($clase['materia']) ?> <?= $clase['nombre_clase'] ? '('.$clase['nombre_clase'].')' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i> Período Académico
                    </label>
                    <select name="periodo" class="form-select" onchange="this.form.submit()">
                        <?php foreach($periodos as $p): ?>
                            <option value="<?= $p ?>" <?= ($periodo==$p?'selected':'') ?>>Período <?= $p ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- Notas (tabla tipo EduSoft) -->
        <div class="subject-header">
            <span class="subject">
                Materia:
                <b>
                    <?php
                    // Mostrar materia y nombre_clase seleccionada
                    $materia = '';
                    foreach($clases as $clase){
                        if($clase['id'] == $id_clase){
                            $materia = htmlspecialchars($clase['materia']);
                            if($clase['nombre_clase']) $materia .= ' (' . htmlspecialchars($clase['nombre_clase']) . ')';
                        }
                    }
                    echo $materia ?: '---';
                    ?>
                </b>
            </span>
            <span class="teacher">
                <!-- Aquí podrías poner el nombre del docente si tienes esa info -->
            </span>
        </div>

        <table class="edusoft-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tarea</th>
                    <th>Porcentaje</th>
                    <th>Descripción</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($notas): ?>
                    <?php
                    $n = 1;
                    foreach($rubros as $campo=>$nombre):
                        preg_match('/\((.*?)\)/', $nombre, $pct); // para el porcentaje
                        $porcentaje = $pct[1] ?? '';
                    ?>
                        <tr>
                            <td class="number"><?= $n++ ?></td>
                            <td><?= preg_replace('/\s*\(.*?\)/', '', $nombre) ?></td>
                            <td class="percentage"><?= $porcentaje ?></td>
                            <td class="description">
                                <?= isset($descripciones[$campo]) ? htmlspecialchars($descripciones[$campo]) : 'No hay descripción disponible.' ?>
                            </td>
                            <td class="grade">
                                <span class="edusoft-grade">
                                    <?= isset($notas[$campo]) ? number_format($notas[$campo],2) : '-' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#667eea; font-weight:500;">
                            <i class="fas fa-clipboard-list"></i> No hay calificaciones registradas para esta clase y período.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($notas): ?>
            <div class="table-footer">
                <span class="label">Promedio del período</span>
                <span class="footer-grade"><?= isset($notas['promedio_final']) ? number_format($notas['promedio_final'],2) : '-' ?></span>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>
</html>