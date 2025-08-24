
<!--
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Tarea</title>
  <link rel="stylesheet" href="prueba.css">
</head>
<body>

  <button class="btn" onclick="mostrarFormulario()">+ Crear nueva tarea</button>

  <div class="form-container" id="formTarea">
    <form action="procesar_tarea.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="titulo">Título de la tarea:</label>
        <input type="text" id="titulo" name="titulo" required>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label for="material">Añadir material:</label>
        <input type="file" id="material" name="material[]" multiple>
      </div>

      <button type="submit" class="btn submit-btn">Publicar tarea</button>
    </form>
  </div>

  <script src="prueba.js"></script>
</body>
</html>

-->
<?php
session_start();
require_once "../conexiones/conexion.php";

// Validar sesión del profesor
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"]; // Asegúrate que este ID esté bien en la sesión

// Consulta: Obtener clases creadas por este profesor
$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$resultado = $stmt->get_result();

$clases = [];
while ($fila = $resultado->fetch_assoc()) {
    $clases[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Tarea</title>
  <link rel="stylesheet" href="prueba.css">
</head>
<body>
  <div class="task-modal">
    <div class="task-header">
      <span class="task-title" data-i18n="maestro_panel_titulo_tareas">Tarea</span>
      <button class="task-close" onclick="cerrarModal()" aria-label="Cerrar" data-i18n="maestro_panel_cerrar">✕</button>
    </div>
    <form class="task-form" action="procesar_tarea.php" method="POST" enctype="multipart/form-data">
      <div class="task-row">
        <label for="id_clase" data-i18n="maestro_panel_tarea_label_clase">Selecciona una clase:</label>
        <select name="id_clase" id="id_clase" required data-i18n="maestro_panel_tarea_select_clase">
          <option value="" data-i18n="maestro_panel_tarea_option_default">-- Selecciona una clase --</option>
          <?php foreach ($clases as $clase): ?>
            <option value="<?php echo $clase['id']; ?>" data-i18n="maestro_panel_tarea_option_clase">
              <?php echo htmlspecialchars($clase['nombre_clase']) . " – " . ucfirst($clase['materia']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="task-row">
        <label for="titulo" data-i18n="maestro_panel_tarea_label_titulo">Título</label>
        <input type="text" id="titulo" name="titulo" placeholder="#001 Exponentes" required data-i18n="maestro_panel_tarea_input_titulo">
      </div>
      <div class="task-row">
        <label for="descripcion" data-i18n="maestro_panel_tarea_label_descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="3" data-i18n="maestro_panel_tarea_textarea_descripcion"></textarea>
      </div>
      <div class="task-row task-meta">
        <div>
          <label data-i18n="maestro_panel_tarea_label_puntos">Puntos</label>
          <input type="number" min="0" max="100" value="20" name="puntos" data-i18n="maestro_panel_tarea_input_puntos">
        </div>
        <div>
          <label data-i18n="maestro_panel_tarea_label_fecha_entrega">Fecha de entrega</label>
          <input type="date" name="fecha_entrega" data-i18n="maestro_panel_tarea_input_fecha_entrega">
        </div>
        <div>
          <label data-i18n="maestro_panel_tarea_label_tema">Tema</label>
          <input type="text" name="tema" value="Tarea" data-i18n="maestro_panel_tarea_input_tema">
        </div>
      </div>
      <div class="task-row task-material">
        <label data-i18n="maestro_panel_tarea_label_material">Material</label>
        <input type="file" name="material[]" multiple data-i18n="maestro_panel_tarea_input_material">
      </div>
      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn" data-i18n="maestro_panel_tarea_btn_submit">Asignar</button>
      </div>
    </form>
  </div>
  <script>
    function cerrarModal() {
      document.querySelector('.task-modal').style.display = 'none';
    }
  </script>
    <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>