<?php
require_once "../conexiones/conexion.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    die("Acceso denegado.");
}
$profesor_id = $_SESSION["id"];

// Traer clases del profesor para el select
$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();
$clases = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Procesar el formulario
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_clase = intval($_POST["id_clase"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha_subida = trim($_POST["fecha_subida"] ?? date("Y-m-d"));

    if (!$id_clase || !$titulo || !$descripcion || !$fecha_subida) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO avisos (id_clase, titulo, descripcion, fecha_subida) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_clase, $titulo, $descripcion, $fecha_subida);
        if ($stmt->execute()) {
            // Redirigir al panel del maestro automáticamente
            header("Location: ../frontend_maestros/index.php?seccion=avisos");
            exit;
        } else {
            $error = "Hubo un error al guardar el aviso.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear aviso | Edusoft</title>
    <link rel="stylesheet" href="../frontend_maestros/crear_aviso.css">
</head>
<body>
    <h2 data-i18n="maestro_panel_crear_aviso_title">Crear aviso</h2>
    <?php if ($error): ?>
        <p style="color:red;" data-i18n="maestro_panel_aviso_error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="id_clase" data-i18n="maestro_panel_aviso_label_clase"><b>Clase/Materia:</b></label>
        <select name="id_clase" id="id_clase" required data-i18n="maestro_panel_aviso_select_clase">
            <option value="" data-i18n="maestro_panel_aviso_option_default">Seleccione una clase</option>
            <?php foreach ($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>" data-i18n="maestro_panel_aviso_option_clase">
                    <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="titulo" data-i18n="maestro_panel_aviso_label_titulo"><b>Nombre del aviso:</b></label>
        <input type="text" name="titulo" id="titulo" required data-i18n="maestro_panel_aviso_input_titulo"><br><br>

        <label for="descripcion" data-i18n="maestro_panel_aviso_label_descripcion"><b>Descripción:</b></label>
        <textarea name="descripcion" id="descripcion" cols="40" rows="4" required data-i18n="maestro_panel_aviso_textarea_descripcion"></textarea><br><br>

        <label for="fecha_subida" data-i18n="maestro_panel_aviso_label_fecha"><b>Fecha de subida:</b></label>
        <input type="date" name="fecha_subida" id="fecha_subida" value="<?= date('Y-m-d') ?>" required data-i18n="maestro_panel_aviso_input_fecha"><br><br>

        <button type="submit" data-i18n="maestro_panel_aviso_btn_submit">Crear aviso</button>
    </form>
      <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>