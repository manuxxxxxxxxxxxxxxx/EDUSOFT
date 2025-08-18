<?php
session_start();
require_once "../conexiones/conexion.php";

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"];

$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();

$clases = [];
while ($fila = $res->fetch_assoc()) {
    $clases[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title data-i18n="subir_material_titulo">Subir Material</title>
  <link rel="stylesheet" href="prueba.css">
</head>
<body>
  <div class="task-modal">
    <div class="task-header">
      <span class="task-title" data-i18n="subir_material_titulo_modal">Material de Estudio</span>
      <button class="task-close" onclick="window.history.back()" aria-label="Cerrar" data-i18n="subir_material_cerrar_btn">✕</button>
    </div>

    <form class="task-form" action="procesar_material.php" method="POST" enctype="multipart/form-data">
      <div class="task-row">
        <label for="id_clase" data-i18n="subir_material_label_clase">Selecciona una clase:</label>
        <select name="id_clase" required data-i18n="subir_material_select_clase">
          <option value="" data-i18n="subir_material_opcion_default">-- Selecciona una clase --</option>
          <?php foreach ($clases as $clase): ?>
            <option value="<?= $clase['id'] ?>" data-i18n="subir_material_opcion_clase_<?= $clase['id'] ?>">
              <?= htmlspecialchars($clase['nombre_clase']) . " – " . ucfirst($clase['materia']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="task-row">
        <label for="titulo" data-i18n="subir_material_label_titulo">Título del material:</label>
        <input type="text" name="titulo" required data-i18n="subir_material_input_titulo">
      </div>

      <div class="task-row">
        <label for="descripcion" data-i18n="subir_material_label_descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3" data-i18n="subir_material_textarea_descripcion"></textarea>
      </div>

      <div class="task-row">
        <label for="archivo" data-i18n="subir_material_label_archivo">Archivo:</label>
        <input type="file" name="archivo" required data-i18n="subir_material_input_archivo">
      </div>

      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn" data-i18n="subir_material_btn_submit">Subir material</button>
      </div>
    </form>
  </div>
</body>
</html>