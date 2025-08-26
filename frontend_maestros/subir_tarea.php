
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
<!-- Modal bonito de éxito para tarea con letras naranjas -->
    <div id="modalExitoTarea" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="background-color:white; padding:30px; max-width:400px; margin:100px auto; border-radius:8px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <h2 data-i18n="crear_tarea_modal_exito" style="color:orange;">✅ Tarea creada con éxito</h2>
            <p data-i18n="crear_tarea_modal_exito_desc" style="color:orange;">Tu tarea ha sido registrada correctamente.</p>
            <button onclick="cerrarModalTarea()" style="padding:8px 16px; margin-top:10px; background-color:#FF9800; color:white; border:none; border-radius:4px;" data-i18n="crear_tarea_modal_aceptar">Aceptar</button>
        </div>
    </div>

    <script>
    function validarFormularioTarea() {
        // Puedes agregar validaciones JS si lo necesitas
        return true;
    }
    function cerrarModalTarea() {
        // Redirige a la sección de tareas del panel con el id_clase
        var id_clase = "<?= htmlspecialchars($id_clase ?? '') ?>";
        window.location.href = "../frontend_maestros/index.php?id_clase=" + encodeURIComponent(id_clase) + "#seccion-tareas";
    }
    window.onload = function () {
        var params = new URLSearchParams(window.location.search);
        if (params.get("exito") === "1") {
            document.getElementById("modalExitoTarea").style.display = "block";
        }
    }
    </script>
</body>
</html>