<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nosotros - EDUSOFT</title>

  <link rel="stylesheet" href="../nosotros/nosotros.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  
      <!-- Navbar mejorado -->
        <header class="navbar">
            <nav class="nav-container">
                <!-- Logo y marca -->
                <div class="nav-brand">
                    <a href="#" class="brand-link">
                        <img src="../img/EDUSOFT2.png" alt="EDUSOFT Logo" class="brand-logo">
                    </a>
                </div>

                <!-- Enlaces de navegación -->
                <div class="nav-links" id="navLinks">
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="http://127.0.0.1:5000/" class="nav-link">
                                <i class="fas fa-robot"></i>
                                <span data-i18n="AteneaV">Atenea</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../cursos.php" class="nav-link">
                                <i class="fas fa-envelope"></i>
                                <span data-i18n="contactV">Cursos</span>
                            </a>
                        </li>
                    </ul>
                </div>


  <div class="layout"> 

<div class="language-dropdown">
  <button class="lang-dropdown-btn" id="langDropdownBtn">
    <img id="currentLangFlag" src="/img/mexico.png" alt="Idioma actual" width="18">
    <span id="currentLangText">Español</span>
    <i class="fas fa-chevron-down"></i>
  </button>
  <div class="lang-dropdown-list" id="langDropdownList">
    <button class="lang-option" data-lang="es">
      <img src="/img/mexico.png" alt="Español" width="18"> Español
    </button>
    <button class="lang-option" data-lang="en">
      <img src="/img/estados.png" alt="English" width="18"> English
    </button>
  </div>
</div>

                <!-- Botón hamburguesa para móvil -->
                <button class="nav-toggle" id="navToggle">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </nav>
        </header>
    <!-- Contenido Principal -->
    <main class="main-content">
      <header class="top-header">
        <button id="sidebar-toggle" class="sidebar-toggle">
          <i class="fas fa-bars"></i>
        </button>
        <div class="user-info">
          <span>Bienvenido</span>
          <a href="#" class="user-link">
            <i class="fas fa-user-circle"></i>
          </a>
        </div>
      </header>
      
      <!-- Hero section -->
      <div class="about-hero">
        <div class="about-hero-content">
          <h1 data-i18n="noso">Nosotros</h1>
          <p data-i18n="Nestudiantes">Estudiantes de bachillerato técnico creando el futuro de la educación digital</p>
        </div>
      </div>

      <!-- Contenido de Nosotros -->
      <div class="about-container">
        <!-- Sección de Quiénes Somos -->
        <section class="about-section">
          <div class="section-header">
            <h2 data-i18n="somosN">Quiénes Somos</h2>
            <div class="section-divider"></div>
          </div>
          <div class="about-content">
            <div class="about-text">
              <p data-i18n="somosP">Somos un equipo de estudiantes apasionados del Bachillerato Técnico en Desarrollo de Software del Colegio Don Bosco. Nuestra plataforma educativa nació como un proyecto escolar que evolucionó hasta convertirse en una herramienta integral para el aprendizaje digital.</p>
              <p data-i18n="somosP2">Combinamos nuestros conocimientos técnicos con una visión fresca de la educación para crear soluciones innovadoras que faciliten el acceso al conocimiento. Creemos que la tecnología debe ser un puente, no una barrera, para el aprendizaje efectivo.</p>
            </div>
            <div class="about-image">
              <img src="../img/docentes.jpg" alt="Equipo de estudiantes trabajando">
            </div>
          </div>
        </section>

        <!-- Sección de Misión y Visión -->
        <section class="mission-vision">
          <div class="mission-box">
            <div class="icon-container">
              <i class="fas fa-bullseye"></i>
            </div>
            <h3 data-i18n="misionN">Nuestra Misión</h3>
            <p data-i18n="somosp3">Democratizar el acceso a la educación de calidad mediante herramientas tecnológicas innovadoras, desarrolladas por y para estudiantes, que faciliten el aprendizaje colaborativo y personalizado.</p>
          </div>
          <div class="vision-box">
            <div class="icon-container">
              <i class="fas fa-binoculars"></i>
            </div>
            <h3 data-i18n="visionN">Nuestra Visión</h3>
            <p data-i18n="somosp4">Ser reconocidos como pioneros en el desarrollo de soluciones educativas digitales creadas por estudiantes, inspirando a nuevas generaciones a utilizar la tecnología como herramienta de transformación social.</p>
          </div>
        </section>

        <!-- Sección de Valores -->
        <section class="about-section values-section">
          <div class="section-header">
            <h2 data-i18n="valoresN">Nuestros Valores</h2>
            <div class="section-divider"></div>
          </div>
          <div class="values-grid">
            <div class="value-card">
              <div class="value-icon">
                <i class="fas fa-lightbulb"></i>
              </div>
              <h3 data-i18n="innovacionN">Innovación</h3>
              <p data-i18n="somosp5">Buscamos constantemente nuevas formas de mejorar la experiencia educativa a través de la tecnología.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">
                <i class="fas fa-hands-helping"></i>
              </div>
              <h3 data-i18n="colaboracion">Colaboración</h3>
              <p data-i18n="somosp6">Creemos en el poder del trabajo en equipo y el intercambio de conocimientos para lograr objetivos comunes.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">
                <i class="fas fa-universal-access"></i>
              </div>
              <h3 data-i18n="accesibilidad">Accesibilidad</h3>
              <p data-i18n="somosp7">Nos esforzamos por hacer que el conocimiento sea accesible para todos, independientemente de sus circunstancias.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">
                <i class="fas fa-rocket"></i>
              </div>
              <h3 data-i18n="excenlencia">Excelencia</h3>
              <p data-i18n="somosp8">Nos comprometemos a ofrecer la más alta calidad en cada aspecto de nuestra plataforma educativa.</p>
            </div>
          </div>
        </section>

        <!-- Sección de Nuestro Equipo -->
        <section class="about-section team-section">
          <div class="section-header">
            <h2 data-i18n="nuestroN">Nuestro Equipo</h2>
            <div class="section-divider"></div>
          </div>
          <div class="team-description">
            <p data-i18n="somosp9">Somos estudiantes del Bachillerato Técnico en Desarrollo de Software, unidos por la pasión de crear soluciones tecnológicas para la educación. Cada uno aporta habilidades únicas que, en conjunto, nos permiten desarrollar una plataforma educativa completa y funcional.</p>
          </div>
          <div class="team-grid">
            <div class="team-member">
              <div class="member-photo">
                <img src="../img/manuel.jpg" alt="Foto de miembro del equipo">
              </div>
              <h3>Manuel Campos</h3>
              <p class="member-role" data-i18n="front">Desarrollo Frontend</p>
              <p data-i18n="especialista">Especialista en crear interfaces intuitivas y atractivas para nuestra plataforma.</p>
            </div>
            <div class="team-member">
              <div class="member-photo">
                <img src="../img/shots.jpg" alt="Foto de miembro del equipo">
              </div>
              <h3>Gabriel Alvarado</h3>
              <p class="member-role" data-i18n="back">Desarrollo Backend</p>
              <p data-i18n="experto">Experto en la lógica y funcionamiento interno de nuestra plataforma educativa.</p>
            </div>
            <div class="team-member">
              <div class="member-photo">
                <img src="../img/chistofer.jpg" alt="Foto de miembro del equipo">
              </div>
              <h3>Christopher Flores</h3>
              <p class="member-role" data-i18n="back">Desarrollo de Backend/p>
              <p data-i18n="experto">Creador de experiencias de usuario que facilitan el aprendizaje digital.</p>
            </div>
            <div class="team-member">
              <div class="member-photo">
                <img src="../img/victor.jpg" alt="Foto de miembro del equipo">
              </div>
              <h3>Ernesto Calderon</h3>
              <p class="member-role" data-i18n="front">Desarrollo Frontend</p>
              <p data-i18n="especialista">Responsable de asegurar la calidad y relevancia del material didáctico.</p>
            </div>
          </div>
        </section>

        <!-- Sección de Trayectoria -->
        <section class="about-section journey-section">
          <div class="section-header">
            <h2 data-i18n="trayectoria">Nuestra Trayectoria</h2>
            <div class="section-divider"></div>
          </div>
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h3>2021</h3>
                <h4 data-i18n="elN">El Inicio</h4>
                <p data-i18n="somosp10">Comenzamos como un proyecto escolar para la feria de ciencias del colegio, con la idea de crear una simple plataforma de recursos educativos.</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h3>2022</h3>
                <h4 data-i18n="pasos">Primeros Pasos</h4>
                <p data-i18n="somosp11">Desarrollamos la primera versión funcional de la plataforma y comenzamos a implementarla en algunas clases de nuestro colegio.</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h3>2023</h3>
                <h4 data-i18n="crecimiento">Crecimiento</h4>
                <p data-i18n="somosp12">Expandimos la plataforma para incluir más materias y funcionalidades, recibiendo reconocimiento a nivel regional por nuestra iniciativa.</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <h3>2024</h3>
                <h4 data-i18n="actulidad">Actualidad</h4>
                <p data-i18n="somosp13">Hoy nuestra plataforma es utilizada por estudiantes de diferentes instituciones, y seguimos trabajando para mejorarla cada día.</p>
              </div>
            </div>
          </div>
        </section>

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
  <script src="cursos.js"></script>
  <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>
