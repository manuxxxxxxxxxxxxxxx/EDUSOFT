<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "estudiante") {
    echo "<script>alert('Debes iniciar sesión como estudiante.'); window.location.href='loginAlumno.php';</script>";
    exit;
}

require_once 'conexiones/conexion.php';

$id_alumno = $_SESSION['id_estudiante'] ?? null;
$imagenAlumno = '';

if ($id_alumno) {
    $stmt = $conn->prepare("SELECT imagen, nombre FROM estudiantes WHERE ID = ?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $stmt->bind_result($imagen, $nombreAlumno);
    $stmt->fetch();
    $stmt->close();

    // Muestra avatar por defecto si no tiene imagen
    if ($imagen) {
        // Si es una URL externa
        if (filter_var($imagen, FILTER_VALIDATE_URL)) {
            $imagenAlumno = $imagen;
        } else {
            // Si es una ruta interna
            $imagenAlumno = "../" . htmlspecialchars($imagen);
        }
    } else {
        // Avatar por defecto usando nombre
        $imagenAlumno = "https://ui-avatars.com/api/?name=" . urlencode($nombreAlumno ?? $_SESSION['nombre'] ?? "Alumno") . "&background=cccccc&color=555555";
    }
} else {
    $imagenAlumno = "https://ui-avatars.com/api/?name=Alumno&background=cccccc&color=555555";
}
// BLOQUE UNIVERSAL MODERN BOOTSTRAP TOAST MULTITIPO CON ICONOS PERSONALIZADOS
if (isset($_GET['toast'])) {
    $mensaje = htmlspecialchars($_GET['toast']);
    $tipo = $_GET['toast_type'] ?? 'info';

    // ICONOS SVG PERSONALIZADOS
    $toastConfig = [
        'success' => [
            'class' => 'toast-success',
            // Icono de éxito (check-circle)
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11.5l-3-3L5.5 7l1.5 1.5L10.5 5l1.5 1.5-4 5z"/></svg>',
        ],
        'error' => [
            'class' => 'toast-error',
            // Icono moderno de error/advertencia (octagon con signo de exclamación)
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 16 16"><path d="M7.001 1.002a2 2 0 0 1 1.998 0l5.999 3.464a2 2 0 0 1 .998 1.732v6.604a2 2 0 0 1-.998 1.732l-5.999 3.464a2 2 0 0 1-1.998 0l-5.999-3.464A2 2 0 0 1 .003 12.802V6.198a2 2 0 0 1 .998-1.732l5.999-3.464zm.999 3.998a1 1 0 1 0-2 0v4a1 1 0 1 0 2 0v-4zm-1 6a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/></svg>',
        ],
        'warning' => [
            'class' => 'toast-warning',
            // Icono de advertencia (triángulo)
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 16 16"><path d="M7.938 2.016a.13.13 0 0 1 .124 0l6.857 11.856c.03.052.035.11.015.164a.13.13 0 0 1-.124.075H1.19a.13.13 0 0 1-.124-.075.13.13 0 0 1 .015-.164L7.938 2.016zM8 4.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-3A.5.5 0 0 0 8 4.5zm-.5 6.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0z"/></svg>',
        ],
        'info' => [
            'class' => 'toast-info',
            // Icono de usuario con check (para "ya inscrito")
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 16 16"><path d="M15.854 5.854a.5.5 0 0 0-.708-.708L13.5 6.793l-1.146-1.147a.5.5 0 0 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l2-2z"/><path d="M9 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4a5.978 5.978 0 0 0-4.468 2.096.5.5 0 0 0 .374.854h10.188a.5.5 0 0 0 .374-.854A5.978 5.978 0 0 0 6 10z"/></svg>',
        ],
    ];
    $cfg = $toastConfig[$tipo] ?? $toastConfig['info'];

    echo '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .toast-success { background: #43a047 !important; color: #fff !important; }
      .toast-error   { background: #e53935 !important; color: #fff !important; }
      .toast-warning { background: #fbc02d !important; color: #fff !important; }
      .toast-info    { background: #1976d2 !important; color: #fff !important; }
      .toast { font-weight: 500; }
      .toast .btn-close { filter: invert(1); }
      @media (max-width: 600px) {
        .custom-toast-pos { left: 50%!important; transform: translateX(-50%)!important; width: 90%!important; }
      }
    </style>
    <div class="position-fixed bottom-0 start-50 translate-middle-x custom-toast-pos p-3" style="z-index:1300;">
      <div id="toastUniversal" class="toast show align-items-center ' . $cfg['class'] . ' border-0 shadow-lg rounded-4" role="alert" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center fw-semibold fs-5">
            '.$cfg['icon'].'
            <span>'.$mensaje.'</span>
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
    ';
}

// NOTIFICACIÓN DE BIENVENIDA (opcional, si usas parámetro bienvenido)
if (isset($_GET['bienvenido'])) {
    $nombre = htmlspecialchars($_GET['bienvenido']);
    echo '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index:1300;">
      <div id="toastBienvenida" class="toast show align-items-center text-bg-success border-0 shadow-lg rounded-4" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center fw-semibold fs-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-person-check me-2" viewBox="0 0 16 16"><path d="M15.854 5.854a.5.5 0 0 0-.708-.708L13.5 6.793l-1.146-1.147a.5.5 0 0 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l2-2z"/><path d="M9 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4a5.978 5.978 0 0 0-4.468 2.096.5.5 0 0 0 .374.854h10.188a.5.5 0 0 0 .374-.854A5.978 5.978 0 0 0 6 10z"/></svg>
            <span>¡Bienvenido, ' . $nombre . '!</span>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      setTimeout(function() {
        var toastEl = document.getElementById("toastBienvenida");
        var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        toast.hide();
      }, 3000);
    </script>
    ';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programas - Edusoft </title>
  <link rel="stylesheet" href="styleCursos.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap CSS solo si no está ya incluido arriba -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="layout">
    <!-- Sidebar -->
    <nav class="sidebar collapsed">
      <div class="sidebar-header">
        <img src="../img/ELEFANTE.png" alt="Logo Colegio Balbuena" class="logo">
        <h2>EDUSOFT</h2>
        <button id="collapse-toggle" class="collapse-toggle">
          <i class="fas fa-chevron-left"></i>
        </button>
      </div>
      
      <ul class="sidebar-menu">
        <li class="sidebar-item active">
          <a href="#" class="sidebar-link" title="Inicio">
            <i class="fas fa-home"></i>
            <span data-i18n="inicioN">Inicio</span>
          </a>
        </li>
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Programas Académicos">
            <i class="fas fa-book"></i>
            <span data-i18n="ProgramasN">Programas Académicos</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu">
            <li><a href="extracurriculares.php" data-i18n="ActividadesN">Actividades extrarriculares</a></li>
            <li><a href="#" data-i18n="Primaria">Primaria</a></li>
            <li><a href="#" data-i18n="secundaria">Secundaria</a></li>
            <li><a href="#" data-i18n="bachillerato">Bachillerato</a></li>
          </ul>
        </li>
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Cursos">
            <i class="fas fa-graduation-cap"></i>
            <span data-i18n="cursosN">Cursos</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          
        </li>
        
        <li class="sidebar-item">
          <a href="../calendario/calendario.php" class="sidebar-link" title="Calendario">
            <i class="fas fa-calendar-alt"></i>
            <span data-i18n="calendario">Calendario</span>
          </a>
        </li>
        
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Comunidad">
            <i class="fas fa-users"></i>
            <span data-i18n="comunidadN">Comunidad</span>
            <!-- <i class="fas fa-chevron-down arrow"></i> -->
          </a>
        </li>
        
        <li class="sidebar-item">
          <a href="#" class="sidebar-link" title="Noticias">
            <i class="fas fa-newspaper"></i>
            <span data-i18n="noticiasN">Noticias</span>
          </a>
        </li>
        
        <li class="sidebar-item">
          <a href="../contactanos/contactanos.php" class="sidebar-link" title="Contacto">
            <i class="fas fa-envelope"></i>
            <span data-i18n="contactoN">Contacto</span>
          </a>
        </li>
      </ul>
      
      <div class="sidebar-footer">
        <a href="../conexiones/logout.php" class="sidebar-link" title="Cerrar sesión">
          <i class="fas fa-sign-in-alt"></i>
          <span data-i18n="cerrarN">Cerrar sesion</span>
        </a>
      </div>
    </nav>
    <!-- Contenido Principal -->
    <main class="main-content">
      <header class="top-header">
        <button id="sidebar-toggle" class="sidebar-toggle">
          <i class="fas fa-bars"></i>
        </button>
        <div class="user-info">
            <span data-i18n="bienvenido">Bienvenido</span>
            <span><?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) :'estudiante'; ?></span>
            <img src="<?= $imagenAlumno ?>" alt="Foto perfil" class="user-img" style="width:65px; height:65px; border-radius:50%; object-fit:cover; margin-left:10px; box-shadow:0 1px 6px rgba(0,0,0,0.10); border:2px solid #e8eaf6;">
        </div>
      </header>

      <!-- Imagen principal -->
      <div class="hero">
        <h1 data-i18n="cursos">Nuestros cursos</h1>
      </div>

<div class="container-top">
  <div class="quick-access-cards-row">
    <!-- Card: Únete a una clase -->
    <div class="qa-card full-card">
      <i class="fa-solid fa-chalkboard-user"></i>
      <h4>Únete a una clase</h4>
      <form method="POST" action="unirse_clase.php" class="card-form">
        <input type="text" name="codigo_clase" placeholder="Código de la clase" required>
        <button type="submit" class="qa-btn qa-btn-long"><i class="fa-solid fa-sign-in-alt"></i> Unirse</button>
      </form>
      <p class="card-hint">¿No tienes código? Pide a tu profesor que te lo proporcione.</p>
    </div>
    <!-- Card: Calendario -->
    <div class="qa-card">
      <i class="fa-solid fa-calendar-alt"></i>
      <h4>Calendario</h4>
      <p>Consulta tus eventos y fechas importantes.</p>
      <a href="../calendario/calendario.php" class="qa-btn">Ir</a>
    </div>
    <!-- Card: Avisos -->
    <div class="qa-card">
      <i class="fa-solid fa-bell"></i>
      <h4>Avisos</h4>
      <p>Revisa las últimas novedades y mensajes de tus profesores.</p>
      <a href="../avisos/avisos.php" class="qa-btn">Ir</a>
    </div>
  </div>
  <div class="motivational-phrase">
    <span>¡Aprender juntos es mejor! Descubre nuevas clases cada día.</span>
  </div>

</div>
        <!-- Mensaje si no hay clases -->
        <?php
          require_once 'conexiones/conexion.php';
          $id_estudiante = $_SESSION['id_estudiante'];
          $query = "SELECT c.id AS id_clase, c.nombre_clase, c.materia, p.nombre AS nombre_profesor 
                    FROM clases_estudiantes ce
                    JOIN clases c ON ce.id_clase = c.id
                    JOIN profesores p ON c.profesor_id = p.id
                    WHERE ce.id_estudiante = ?";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("i", $id_estudiante);
          $stmt->execute();
          $resultado = $stmt->get_result();

          $clases_estudiantes = [];
          while ($row = $resultado->fetch_assoc()) {
            $clases_estudiantes[] = $row;
          }
        ?>

        <?php if (empty($clases_estudiantes)): ?>
          <p class="no-class-msg">No estás inscrito en ninguna clase. Usa el código para unirte.</p>
        <?php endif; ?>
      </div>

      <!-- NUEVO: Contenedor solo para tarjetas -->
      <div class="container-cards">
        <?php
                    $slug_archivo = [
            'lenguaje'   => 'lenguaje',
            'matemática' => 'matematica',
            'matematica' => 'matematica',
            'ciencias'   => 'ciencias',
            'ciencia'    => 'ciencias',
            'biología'   => 'biologia',
            'biologia'   => 'biologia',
            'química'    => 'quimica',
            'quimica'    => 'quimica',
            'ingles'     => 'ingles',
            'sociales'   => 'sociales',
          ];
        ?>
        <?php foreach ($clases_estudiantes as $clases): 
        
          $materia = strtolower($clases['materia']);
          $imagenes = [
            'lenguaje' => '../img/lenguaje_cursos.jpg',
            'matemática' => '../img/mate_cursos.webp',
            'matematica' => '../img/mate_cursos.webp',
            'ciencias' => '../img/ciencias_cursos.png',
            'biología' => '../img/biologia.jpg',
            'biologia' => '../img/biologia.jpg',
            'química' => '../img/quimica.jpg',
            'quimica' => '../img/quimica.jpg',
          ];
          $img = $imagenes[$materia] ?? '../img/default.jpg';
          $materia_slug = $slug_archivo[$materia] ?? $materia;
        ?>
          <div class="card bg-green">
            <div class="card-image-container">
              <img src="<?= $img ?>" class="card-img" alt="<?= htmlspecialchars($clases['materia']) ?>">
            </div>
            <div class="card-content">
              <h2><?= htmlspecialchars($clases['nombre_clase']) ?></h2>
              <p class="card-title">
                <?= htmlspecialchars($clases['materia']) ?> - Prof. <?= htmlspecialchars($clases['nombre_profesor']) ?>
              </p>
              <?php
                $materia_slug = $slug_archivo[strtolower($clases['materia'])] ?? strtolower($clases['materia']);
              ?>
                <a href="../materias/<?php echo $materia_slug; ?>.php?id_clase=<?php echo $clases['id_clase']; ?>" class="btn">Más información</a>

                <form method="POST" action="salir_clase.php" style="display:inline;">
                  <input type="hidden" name="id_clase" value="<?php echo $clases['id_clase']; ?>">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro que quieres salir de esta clase?');">Salir de la clase</button>
                </form>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </main>
  </div>

  <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="../img/ELEFANTE.png" alt="Logo EDUSOFT" class="logo">
                <h3>EDUSOFT</h3>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4 data-i18n="h4">Plataforma</h4>
                    <ul>
                        <li><a href="#" data-i18n="inicio">Inicio</a></li>
                        <li><a href="#" data-i18n="cursos">Cursos</a></li>
                        <li><a href="#" data-i18n="nosotros">Nosotros</a></li>
                        <li><a href="#" data-i18n="contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Recursos</h4>
                    <ul>
                        <li><a href="#" data-i18n="biblioteca">Biblioteca Digital</a></li>
                        <li><a href="#" data-i18n="tutoriales">Tutoriales</a></li>
                        <li><a href="#" data-i18n="preguntas_frecuentes">Preguntas Frecuentes</a></li>
                        <li><a href="#" data-i18n="soporte">Soporte Técnico</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 data-i18n="legal">Legal</h4>
                    <ul>
                        <li data-i18n="terminos"><a href="#">Términos de Uso</a></li>
                        <li data-i18n="politica"><a href="#">Política de Privacidad</a></li>
                        <li data-i18n="cookies"><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p data-i18n="copy">&copy; 2024 EDUSOFT - Plataforma Educativa. Desarrollado por estudiantes de Bachillerato Técnico.</p>
        </div>
    </footer>

  <script src="../nosotros/cursos.js"></script>
  <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>