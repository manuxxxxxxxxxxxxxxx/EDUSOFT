<?php
require_once "conexion.php";
require_once "DiarioPedagogico.php";
require_once "CodigoConducta.php";

session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'profesor' || !isset($_SESSION['id'])) {
    echo "Acceso denegado.";
    exit;
}

$diario = new DiarioPedagogico($conn);
$codigoConducta = new CodigoConducta($conn);

$estudiantes = $diario->listarEstudiantes();
$codigos = $codigoConducta->listarCodigos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar entrada al Diario Pedagógico</title>
    <link rel="stylesheet" href="profedp.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <style>
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
    <button id="btn-back" title="Volver" onclick="window.location.href='../frontend_maestros/index.php';">
        <i class="fas fa-arrow-left"></i>
    </button>
<div class="diario-bg-art">
  <i class="fa-solid fa-book-open-reader book-icon"></i>
</div>
    <?php if (isset($_GET['toast'])): ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index:1300;">
    <div id="toastUniversal" class="toast show align-items-center text-bg-success border-0 shadow-lg rounded-4" role="alert" aria-live="polite" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body d-flex align-items-center fw-semibold fs-5">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11.5l-3-3L5.5 7l1.5 1.5L10.5 5l1.5 1.5-4 5z"/></svg>
          <span><?= htmlspecialchars($_GET['toast']) ?></span>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    setTimeout(function() {
      var toastEl = document.getElementById("toastUniversal");
      var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
      toast.hide();
    }, 3500);
  </script>
<?php endif; ?>

    <h2>Registrar entrada al Diario Pedagógico</h2>
    <form method="POST" action="controlador.php">
        <label>Estudiante:</label>
        <select name="id_estudiante" required>
            <option value="">-- Seleccionar alumno --</option>
            <?php foreach ($estudiantes as $e): ?>
                <option value="<?= htmlspecialchars($e['ID']) ?>"><?= htmlspecialchars($e['nombre']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Código de conducta:</label>
        <select name="id_codigo">
            <option value="">-- Sin código --</option>
            <?php foreach ($codigos as $c): ?>
                <option value="<?= htmlspecialchars($c['id']) ?>">
                    <?= htmlspecialchars($c['codigo']) ?> (<?= htmlspecialchars($c['descripcion']) ?>)
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Observación:</label>
        <textarea name="observacion" rows="3"></textarea><br>

        <label>Tipo de entrada:</label>
        <select name="tipo_entrada" required>
            <option value="codigo">Código</option>
            <option value="observacion">Observación</option>
            <option value="notificacion">Notificación</option>
        </select><br>

        <label>Nivel falta:</label>
        <select name="nivel_falta">
            <option value="">-- No aplica --</option>
            <option value="positivo">Positivo</option>
            <option value="leve">Leve</option>
            <option value="grave">Grave</option>
            <option value="muy grave">Muy grave</option>
        </select><br>

        <button type="submit" name="accion" value="guardar_diario">Guardar</button>
    </form>
</body>
</html>