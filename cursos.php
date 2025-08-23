<?php 
    session_start();
    if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "estudiante") {
        echo "<script>alert('Debes iniciar sesión como estudiante.'); window.location.href='loginAlumno.php';</script>";
        exit;
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
          <ul class="submenu">
            <li><a href="../materias/biologia.php" data-i18n="biologiaN">Biología</a></li>
            <li><a href="../materias/lenguaje.php" data-i18n="lenguajeN">Lenguaje</a></li>
            <li><a href="../materias/ciencias.php" data-i18n="cienciasN">Ciencia</a></li>
            <li><a href="../materias/matematica.php" data-i18n="matematicasN">Matemática</a></li>
            <li><a href="../materias/quimica.php" data-i18n="quimicaN">Química</a></li>
            <li><a href="../materias/sociales.php" data-i18n="Ciencias_socialesN">Ciencias Sociales</a></li>
          </ul>
        </li>
        
        <li class="sidebar-item">
          <a href="../calendario/calendario.php" class="sidebar-link" title="Calendario">
            <i class="fas fa-calendar-alt"></i>
            <span data-i18n="calendario">Calendario</span>
          </a>
        </li>

        <li class="sidebar-item active">
          <a href="../nosotros/nosotros.php" class="sidebar-link" title="Nosotros">
            <i class="fas fa-users"></i>
            <span data-i18n="nosotros">Nosotros</span>
          </a>
        </li>
        
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Comunidad">
            <i class="fas fa-users"></i>
            <span data-i18n="comunidadN">Comunidad</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu">
            <li><a href="#" data-i18n="profesoresN">Profesores</a></li>
            <li><a href="#" data-i18n="alumnosN">Alumnos</a></li>
            <li><a href="#" data-i18n="padresN">Padres</a></li>
            <li><a href="#" data-i18n="exalumnosN">Ex-alumnos</a></li>
          </ul>
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
          <span><?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'estudiante'; ?></span>
          <a href="#" class="user-link"><i class="fas fa-user-circle"></i></a>
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
        <?php foreach ($clases_estudiantes as $clases): 
          $materia = strtolower($clases['materia']);
          $imagenes = [
            'lenguaje' => '../img/lenguaje_cursos.jpg',
            'matemática' => '../img/mate_cursos.webp',
            'matematica' => '../img/mate_cursos.webp',
            'ciencia' => '../img/ciencias_cursos.png',
            'biología' => '../img/biologia.jpg',
            'biologia' => '../img/biologia.jpg',
            'química' => '../img/quimica.jpg',
            'quimica' => '../img/quimica.jpg',
          ];
          $img = $imagenes[$materia] ?? '../img/default.jpg';
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
              <a href="../materias/<?php echo strtolower($clases['materia']); ?>.php?id_clase=<?php echo $clases['id_clase']; ?>" class="btn">Más información</a>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </main>
  </div>

  <!-- Footer -->
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