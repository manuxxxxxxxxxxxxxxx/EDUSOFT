<?php
session_start();
require_once "../conexiones/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $pass = trim($_POST['contraseña']);

    // Buscar en profesores
    $sql_prof = "SELECT id, nombre, pass FROM profesores WHERE nombre = ?";
    $stmt_prof = $conn->prepare($sql_prof);
    $stmt_prof->bind_param("s", $nombre);
    $stmt_prof->execute();
    $res_prof = $stmt_prof->get_result();

    if ($row = $res_prof->fetch_assoc()) {
        if (password_verify($pass, $row['pass'])) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["nombre"] = $row['nombre'];
            $_SESSION["rol"] = "profesor";
            header("Location: ../principal/sistema_notas_profes.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Buscar en estudiantes
        $sql_al = "SELECT ID, nombre, pass FROM estudiantes WHERE nombre = ?";
        $stmt_al = $conn->prepare($sql_al);
        $stmt_al->bind_param("s", $nombre);
        $stmt_al->execute();
        $res_al = $stmt_al->get_result();

        if ($row = $res_al->fetch_assoc()) {
            if (password_verify($pass, $row['pass'])) {
                $_SESSION["id_estudiante"] = $row['ID'];
                $_SESSION["nombre"] = $row['nombre'];
                $_SESSION["rol"] = "alumno";
                header("Location: ../principal/sistema_notas_alumno.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - ELEFANTE</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="prueba.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
   <a href="javascript:history.back()" class="back-arrow" title="Volver atrás">
  <i class="fa-solid fa-arrow-left"></i>
</a>
  <!-- Marca de agua: Elefante SVG -->
  <div class="elephant-watermark">
    <!-- Puedes reemplazar el SVG por una imagen si prefieres -->
    <img src="../img/ELEFANTE.png" alt="">
      <path d="M100 700 Q230 400 340 400 Q400 390 450 250 Q480 170 600 150 Q730 130 700 270 Q660 410 550 370 Q360 300 420 450 Q470 560 200 550 Q90 540 100 700 Z"
        stroke="#5398ed" stroke-width="20" fill="none" opacity="0.8"/>
      <!-- Dibuja tu elefante aquí, o reemplaza por imagen si lo prefieres -->
       
    </svg>
  </div>
  <div class="main-center-card">
    <div class="card-form-side">
      <div class="logo-elefante">
        <img src="../img/ELEFANTE.png" alt="Logo Elefante" style="height: 28px; vertical-align: middle;">
        <span class="brand">EDUSOFT</span>
      </div>
      <h2 data-i18n="inicioS">Inicio de Sesion</h2>
      <form  method="post">
        <div class="form-group">
            <i class='bx bxs-user'></i>
            <input data-i18n="nombre_usuario" type="text"  Name="nombre" placeholder="Nombre Usuario" required >
        </div>
        <div class="form-group">
            <i class='bx bxs-envelope' ></i>
          <input data-i18n="contraseña"   datype="password" name="contraseña" placeholder="Contraseña" required >
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            Iniciar Sesion
          </button>
        </div>
      </form>

    </div>
    <div class="card-image-side">
      <img src="../img/imagen4.jpg" alt="Imagen lateral">
    </div>
  </div>
  <script>
    // Animación elegante del elefante
    const card = document.querySelector('.main-center-card');
    const watermark = document.querySelector('.elephant-watermark');
    card.addEventListener('mouseenter', () => {
      watermark.style.opacity = '0.16';
      watermark.style.filter = 'blur(0.5px)';
    });
    card.addEventListener('mouseleave', () => {
      watermark.style.opacity = '0.08';
      watermark.style.filter = 'blur(2px)';
    });
  </script>
</body>
</html>