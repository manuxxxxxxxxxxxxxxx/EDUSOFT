
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
        if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
              die("Acceso denegado. No eres profesor.");
        header("Location: ../loginProfes.php");
        exit;
        }
?>s
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
      <span class="task-title">Tarea</span>
      <button class="task-close" onclick="cerrarModal()">✕</button>
    </div>
    <form class="task-form" action="procesar_tarea.php" method="POST" enctype="multipart/form-data">
      <div class="task-row">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" placeholder="#001 Exponentes" required>
      </div>
      <div class="task-row">
        <label for="descripcion">Descripción </label>
        <textarea id="descripcion" name="descripcion" rows="3"></textarea>
      </div>
      <div class="task-row task-meta">
        <div>
          <label>Puntos</label>
          <input type="number" min="0" max="100" value="20" name="puntos">
        </div>
        <div>
          <label>Fecha de entrega</label>
          <input type="date" name="fecha_entrega">
        </div>
        <div>
          <label>Tema</label>
          <input type="text" name="tema" value="Tarea">
        </div>
      </div>
      <div class="task-row task-material">
        <label>Material</label>
        <input type="file" name="material[]" multiple>
      </div>
      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn">Asignar</button>
      </div>
    </form>
  </div>
  <script>
    function cerrarModal() {
      document.querySelector('.task-modal').style.display = 'none';
    }
  </script>
</body>
</html>