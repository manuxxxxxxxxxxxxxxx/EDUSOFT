<?php 
    session_start();
      if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "estudiante") {
        header("Location: ../loginAlumno.php");
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
    <!-- Navbar Vertical -->
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
            <span>Inicio</span>
          </a>
        </li>
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Programas Académicos">
            <i class="fas fa-book"></i>
            <span>Programas Académicos</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu">
            <li><a href="#">Actividades extrarriculares</a></li>
            <li><a href="#">Primaria</a></li>
            <li><a href="#">Secundaria</a></li>
            <li><a href="#">Bachillerato</a></li>
          </ul>
        </li>
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Cursos">
            <i class="fas fa-graduation-cap"></i>
            <span>Cursos</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu">
            <li><a href="#">Biología</a></li>
            <li><a href="#">Lenguaje</a></li>
            <li><a href="#">Ciencia</a></li>
            <li><a href="#">Matemática</a></li>
            <li><a href="#">Química</a></li>
            <li><a href="#">Ciencias Sociales</a></li>
          </ul>
        </li>
        
        <li class="sidebar-item">
          <a href="#" class="sidebar-link" title="Calendario">
            <i class="fas fa-calendar-alt"></i>
            <span>Calendario</span>
          </a>
        </li>

        <li class="sidebar-item active">
          <a href="../nosotros/nosotros.php" class="sidebar-link" title="Nosotros">
            <i class="fas fa-users"></i>
            <span>Nosotros</span>
          </a>
        </li>
        
        
        <li class="sidebar-item has-submenu">
          <a href="#" class="sidebar-link" title="Comunidad">
            <i class="fas fa-users"></i>
            <span>Comunidad</span>
            <i class="fas fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu">
            <li><a href="#">Profesores</a></li>
            <li><a href="#">Alumnos</a></li>
            <li><a href="#">Padres</a></li>
            <li><a href="#">Ex-alumnos</a></li>
          </ul>
        </li>
        
        <li class="sidebar-item">
          <a href="#" class="sidebar-link" title="Noticias">
            <i class="fas fa-newspaper"></i>
            <span>Noticias</span>
          </a>
        </li>
        
        <li class="sidebar-item">
          <a href="#" class="sidebar-link" title="Contacto">
            <i class="fas fa-envelope"></i>
            <span>Contacto</span>
          </a>
        </li>
      </ul>
      
      <div class="sidebar-footer">
        <a href="../conexiones/logout.php" class="sidebar-link" title="Cerrar sesión">
          <i class="fas fa-sign-in-alt"></i>
          <span>Cerrar sesion</span>
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
          <span>Bienvenido <?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'estudiante'; ?></span>
          <a href="#" class="user-link">
            <i class="fas fa-user-circle"></i>
          </a>
        </div>
      </header>
      
      <!-- Imagen principal -->
      <div class="hero">
        <h1>Nuestros cursos</h1>
      </div>

      <div class="container">
        <div class="card bg-blue">
          <div class="card-image-container">
            <img src="../img/biologia.jpg" class="card-img" alt="Biología">
          </div>
          <div class="card-content">
            <h2>1</h2>
            <p class="card-title">Biología</p>
            <a href="../materias/biologia.php" class="btn">Más información</a>
          </div>
        </div>
        
        <div class="card bg-green">
          <div class="card-image-container">
            <img src="../img/lenguaje_cursos.jpg" class="card-img" alt="Lenguaje">
          </div>
          <div class="card-content">
            <h2>2</h2>
            <p class="card-title">Lenguaje</p>
            <a href="../materias/lenguaje.php" class="btn">Más información</a>
          </div>
        </div>
        
        <div class="card bg-yellow">
          <div class="card-image-container">
            <img src="../img/ciencias_cursos.png" class="card-img" alt="Ciencia">
          </div>
          <div class="card-content">
            <h2>3</h2>
            <p class="card-title">Ciencia</p>
            <a href="../materias/ciencias.php" class="btn">Más información</a>
          </div>
        </div>
        
        <div class="card bg-blue">
          <div class="card-image-container">
            <img src="../img/mate_cursos.webp" class="card-img" alt="Matemática">
          </div>
          <div class="card-content">
            <h2>4</h2>
            <p class="card-title">Matemática</p>
            <a href="../materias/matematica.php" class="btn">Más información</a>
          </div>
        </div>
        
        <!-- Más tarjetas aquí... -->
      </div>
    </main>
  </div>

  <script src="../nosotros/cursos.js"></script>
</body>
</html>
