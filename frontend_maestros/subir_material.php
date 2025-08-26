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

// Para redirección JS en el modal de éxito
$id_clase = isset($_GET['id_clase']) ? $_GET['id_clase'] : '';
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

    <form class="task-form" id="formSubirMaterial" action="procesar_material.php" method="POST" enctype="multipart/form-data">
      <div class="task-row">
        <label for="id_clase" data-i18n="subir_material_label_clase">Selecciona una clase:</label>
        <select name="id_clase" id="id_clase" required data-i18n="subir_material_select_clase">
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
        <input type="text" name="titulo" id="titulo" required data-i18n="subir_material_input_titulo">
      </div>

      <div class="task-row">
        <label for="descripcion" data-i18n="subir_material_label_descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="3" data-i18n="subir_material_textarea_descripcion"></textarea>
      </div>

      <div class="task-row">
        <label for="archivo" data-i18n="subir_material_label_archivo">Archivo:</label>
        <input type="file" name="archivo" id="archivo" required data-i18n="subir_material_input_archivo">
      </div>

      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn" data-i18n="subir_material_btn_submit">Subir material</button>
      </div>
    </form>
  </div>

  <!-- Modal bonito de éxito para material con letras naranjas -->
  <div id="modalExitoMaterial" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
      <div style="background-color:white; padding:30px; max-width:400px; margin:100px auto; border-radius:8px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
          <h2 data-i18n="crear_material_modal_exito" style="color:orange;">✅ Material subido con éxito</h2>
          <p data-i18n="crear_material_modal_exito_desc" style="color:orange;">Tu material ha sido registrado correctamente.</p>
          <button onclick="cerrarModalMaterial()" style="padding:8px 16px; margin-top:10px; background-color:#FF9800; color:white; border:none; border-radius:4px;" data-i18n="crear_material_modal_aceptar">Aceptar</button>
      </div>
  </div>

  <script>
    function cerrarModalMaterial() {
        // Extrae id_clase de los parámetros GET, no de PHP
        var params = new URLSearchParams(window.location.search);
        var id_clase = params.get("id_clase") || "<?= htmlspecialchars($id_clase) ?>";
        window.location.href = "../frontend_maestros/index.php?id_clase=" + encodeURIComponent(id_clase) + "#seccion-materiales";
    }
    window.onload = function () {
        var params = new URLSearchParams(window.location.search);
        if (params.get("exito") === "1") {
            document.getElementById("modalExitoMaterial").style.display = "block";
        }
    }
  </script>
</body>
</html>