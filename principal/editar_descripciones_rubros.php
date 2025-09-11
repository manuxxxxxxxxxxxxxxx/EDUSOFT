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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="editar.css">
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
   <button id="btn-back" title="Volver" onclick="window.location.href='../principal/sistema_notas_profes.php'">
    <i class="fas fa-arrow-left"></i>
   </button>

<div class="desc-box">
    <h2>Editar descripciones de rubros</h2>
    <form method="GET">
        <span class="filtros-label">Clase:</span>
        <select name="id_clase" onchange="this.form.submit()">
            <?php foreach($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>" <?= ($id_clase==$clase['id']?'selected':'') ?>>
                    <?= htmlspecialchars($clase['materia']) ?> (<?= htmlspecialchars($clase['nombre_clase']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <span class="filtros-label">Periodo:</span>
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
        <button type="submit">Guardar descripciones</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>
</html>