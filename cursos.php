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
            <li><a href="#" data-i18n="ActividadesN">Actividades extrarriculares</a></li>
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
            <li><a href="#" data-i18n="biologiaN">Biología</a></li>
            <li><a href="#" data-i18n="lenguajeN">Lenguaje</a></li>
            <li><a href="#" data-i18n="cienciasN">Ciencia</a></li>
            <li><a href="#" data-i18n="matematicasN">Matemática</a></li>
            <li><a href="#" data-i18n="quimicaN">Química</a></li>
            <li><a href="#" data-i18n="Ciencias_socialesN">Ciencias Sociales</a></li>
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
          <a href="#" class="user-link">
            <i class="fas fa-user-circle"></i>
          </a>
        </div>
      </header>
      
      <!-- Imagen principal -->
      <div class="hero">
        <h1 data-i18n="cursos">Nuestros cursos</h1>
      </div>

      <div class="container">
        <div class="unirse-clase">
          <h3>Unirse a una clase</h3>
          <form method="POST" action="unirse_clase.php">
              <input type="text" name="codigo_clase" placeholder="Código de la clase" required>
              <button type="submit">Unirse</button>
          </form>
        </div>
        <?php
              require_once 'conexiones/conexion.php';  // Asegúrate que esta ruta es correcta

              $id_estudiante = $_SESSION['id'];  // Asegúrate de tener esto guardado en la sesión

              $query = "SELECT c.nombre_clase, c.materia, p.nombre AS nombre_profesor 
                        FROM clases_estudiantes ce
                        JOIN clases c ON ce.id_clase = c.id
                        JOIN profesores p ON c.profesor_id = p.id
                        WHERE ce.id_estudiante = ?";
              $stmt = $conn->prepare($query);
              $stmt->bind_param("i", $id_estudiante);
              $stmt->execute();
              $resultado = $stmt->get_result();


              // Dentro de un ciclo o de forma individual
              while ($clases = $resultado->fetch_assoc()) {
                  // Mostrar tarjeta (ya corregida como arriba)
              }
          ?>

          <?php if (empty($clases_estudiantes)): ?>
            <p>No estás inscrito en ninguna clase. Usa el código para unirte.</p>
          <?php else: ?>

            <?php foreach ($clases_estudiantes as $clases): 
              // Determinar imagen basada en la materia
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
                    <?php if (isset($clases) && is_array($clases)) : ?>
                      <div class="card-content">
                        <h2><?= htmlspecialchars($clases['nombre_clase'] ?? 'Sin nombre') ?></h2>
                        <p class="card-title">
                            <?= htmlspecialchars($clases['materia'] ?? 'Materia desconocida') ?>
                            - Prof. <?= htmlspecialchars($clases['nombre'] ?? 'Desconocido') ?>
                        </p>
                        <a href="../materias/<?= htmlspecialchars($clases['materia'] ?? 'materia') ?>.php" class="btn" data-i18n="mas_informacion">Más información</a>
                      </div>
                    <?php else : ?>
                      <p class="text-danger">No se pudo cargar la clase correctamente.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
          <?php endif; ?>


          
        <div class="card bg-blue">
          <div class="card-image-container">
            <img src="../img/biologia.jpg" class="card-img" alt="Biología">
          </div>
          <div class="card-content">
            <h2>1</h2>
            <p class="card-title" data-i18n="biologia">Biología</p>
            <a href="../materias/biologia.php" class="btn" data-i18n="mas_informacion">Más información</a>
          </div>
        </div>
        
        <div class="card bg-green">
          <div class="card-image-container">
            <img src="../img/lenguaje_cursos.jpg" class="card-img" alt="Lenguaje">
          </div>
          <div class="card-content">
            <h2>2</h2>
            <p class="card-title" data-i18n="lenguaje">Lenguaje</p>
            <a href="../materias/lenguaje.php" class="btn" data-i18n="mas_informacion">Más información</a>
          </div>
        </div>
        
        <div class="card bg-yellow">
          <div class="card-image-container">
            <img src="../img/ciencias_cursos.png" class="card-img" alt="Ciencia">
          </div>
          <div class="card-content">
            <h2>3</h2>
            <p class="card-title" data-i18n="ciencias">Ciencia</p>
            <a href="../materias/ciencias.php" class="btn" data-i18n="mas_informacion">Más información</a>
          </div>
        </div>
        
        <div class="card bg-blue">
          <div class="card-image-container">
            <img src="../img/mate_cursos.webp" class="card-img" alt="Matemática">
          </div>
          <div class="card-content">
            <h2>4</h2>
            <p class="card-title" data-i18n="matematicas">Matemática</p>
            <a href="../materias/matematica.php" class="btn" data-i18n="mas_informacion">Más información</a>
          </div>
        </div>
        
        <!-- Más tarjetas aquí... -->
      </div>
    </main>
  </div>

   <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="/placeholder.svg?height=60&width=60" alt="Logo EDUSOFT" class="logo">
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
