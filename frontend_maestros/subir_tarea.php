<?php
session_start();
require_once "../conexiones/conexion.php";

// Validar sesión del profesor
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION["id"]; 

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

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
<body>
  <button id="btn-back" title="Volver" onclick="window.location.href='../frontend_maestros/index.php'">
    <i class="fas fa-arrow-left"></i>
</button>

  <div class="task-modal">
    <div class="task-header">
      <span class="task-title" style="color:#232323;">Tarea</span>
      <button class="task-close" onclick="cerrarModal()" aria-label="Cerrar">✕</button>
    </div>
    <form class="task-form" action="procesar_tarea.php" method="POST" enctype="multipart/form-data" id="formTareaRubrica">
      <div class="task-row">
        <label for="id_clase" style="color:#232323;">Selecciona una clase:</label>
        <select name="id_clase" id="id_clase" required>
          <option value="">-- Selecciona una clase --</option>
          <?php foreach ($clases as $clase): ?>
            <option value="<?php echo $clase['id']; ?>">
              <?php echo htmlspecialchars($clase['nombre_clase']) . " – " . ucfirst($clase['materia']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="task-row">
        <label for="titulo" style="color:#232323;">Título</label>
        <input type="text" id="titulo" name="titulo" placeholder="#001 Exponentes" required>
      </div>
      <div class="task-row">
        <label for="descripcion" style="color:#232323;">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="3"></textarea>
      </div>
      <div class="task-row task-meta">
        <div>
          <label style="color:#232323;">Fecha de entrega</label>
          <input type="datetime-local" name="fecha_entrega" required>
        </div>
        <div>
          <label style="color:#232323;">Tema</label>
          <input type="text" name="tema" value="Tarea">
        </div>
      </div>
      <div class="task-row">
        <label for="categoria_tarea" style="color:#232323;">Categoría de la tarea</label>
        <select name="categoria_tarea" id="categoria_tarea" required>
          <option value="">-- Selecciona categoría --</option>
          <option value="normal">Tarea Normal</option>
          <option value="aula">Tarea aula (10%)</option>
          <option value="integradora">Tarea integradora (30%)</option>
          <option value="prueba_objetiva">Prueba objetiva (20%)</option>
        </select>
        <small style="color:#666;">
          El tipo de tarea ayuda a los alumnos a identificar el peso de cada actividad en el promedio. <br>
          <b>Nota:</b> El examen de periodo (30%) y nota formativa (10%) se asignan solo desde el sistema de notas.
        </small>
      </div>
      <div class="task-row task-material">
        <label style="color:#232323;">Material</label>
        <input type="file" name="material[]" multiple>
      </div>

      <!-- Rubrica -->
      <hr>
      <div>
        <h4 style="color:#232323;">Rúbrica de evaluación</h4>
        <label for="rubrica_titulo" style="color:#232323;">Título de la rúbrica</label>
        <input type="text" id="rubrica_titulo" name="rubrica_titulo" placeholder="Ej: Evaluación Exponentes" required>
        <label for="rubrica_descripcion" style="color:#232323;">Descripción (opcional)</label>
        <textarea id="rubrica_descripcion" name="rubrica_descripcion" rows="2"></textarea>
        <div id="criterios-container">
          <h5 style="color:#232323;">Criterios (porcentaje, suma debe ser 100)</h5>
          <div>
            <input type="text" name="criterio_nombre[]" placeholder="Nombre del criterio" required>
            <input type="number" name="criterio_porcentaje[]" min="1" max="100" placeholder="Porcentaje (%)" required>
            <button type="button" onclick="agregarCriterio()">+ Agregar criterio</button>
          </div>
        </div>
      </div>

      <div class="task-row task-actions">
        <button type="submit" class="btn submit-btn">Asignar</button>
      </div>
    </form>
  </div>
  <div id="modalExitoTarea" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
    <div style="background-color:white; padding:30px; max-width:400px; margin:100px auto; border-radius:8px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
      <h2 style="color:orange;">✅ Tarea creada con éxito</h2>
      <p style="color:orange;">Tu tarea ha sido registrada correctamente.</p>
      <button onclick="cerrarModalTarea()" style="padding:8px 16px; margin-top:10px; background-color:#FF9800; color:white; border:none; border-radius:4px;">Aceptar</button>
    </div>
  </div>
  <script>
    function agregarCriterio() {
      var container = document.getElementById('criterios-container');
      var div = document.createElement('div');
      div.innerHTML = `
        <input type="text" name="criterio_nombre[]" placeholder="Nombre del criterio" required>
        <input type="number" name="criterio_porcentaje[]" min="1" max="100" placeholder="Porcentaje (%)" required>
        <button type="button" onclick="this.parentElement.remove()">Eliminar</button>
      `;
      container.appendChild(div);
    }
    document.getElementById('formTareaRubrica').onsubmit = function(e) {
      var porcentajes = document.querySelectorAll('[name="criterio_porcentaje[]"]');
      var suma = 0;
      for (var i = 0; i < porcentajes.length; i++) {
        suma += parseInt(porcentajes[i].value) || 0;
      }
      if (suma !== 100) {
        alert('La suma de los porcentajes de los criterios debe ser exactamente 100%. Actualmente suma: ' + suma + '%');
        e.preventDefault();
        return false;
      }
    };
    function cerrarModalTarea() {
      var id_clase = document.getElementById('id_clase').value;
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