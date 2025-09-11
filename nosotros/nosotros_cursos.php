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
<style>
    body {
      
      min-height: 100vh;
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    .back-arrow {
    position: absolute;
    top: 12px;
    left: 32px;
    width: 56px;
    height: 56px;
    background: #222;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 24px rgba(0,0,0,0.15);
    transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    z-index: 100;
}
.back-arrow i {
    color: #fff;
    font-size: 2rem;
    transition: color 0.2s;
}
.back-arrow:hover {
    background: #007bff;
    transform: scale(1.08);
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}
.back-arrow:active {
    transform: scale(0.95);
}
    
    .fc-toolbar-title,
    .navbar-brand,
    .text-pastel {
      color: #1976d2 !important;
    }
    .fc-event {
      background-color: #90caf9 !important; /* Azul pastel */
      color: #1976d2 !important;
      border: none !important;
      border-radius: 8px !important;
      font-size: 1rem;
      box-shadow: 0 2px 6px rgba(144,202,249,0.12);
      padding: 4px 8px;
      font-weight: 500;
    }
    .fc-daygrid-day:hover {
      background-color: #e3f2fd;
      cursor: pointer;
      transition: background 0.2s;
    }
    .custom-btn {
      background: #90caf9;
      color: #1976d2;
      border: none;
      border-radius: 8px;
      padding: 8px 18px;
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 18px;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(144,202,249,0.08);
    }
    .custom-btn:hover {
      background: #64b5f6;
      color: #fff;
    }
    .navbar-brand {
      font-size: 1.4rem;
      font-weight: 700;
      letter-spacing: 1px;
      color: #1976d2;
      padding-left: 30px;
    }
    .modal-header {
      background: #90caf9;
      color: #1976d2;
    }
    .modal-title {
      font-weight: 700;
      font-size: 1.2rem;
    }
    .form-label {
      font-weight: 500;
      color: #1976d2;
    }
    .btn-pastel {
      background: #90caf9;
      color: #1976d2;
      border: none;
      font-weight: 500;
    }
    .btn-pastel:hover {
      background: #1976d2;
      color: #fff;
    }
    .btn-outline-pastel {
      border-color: #90caf9;
      color: #1976d2;
    }
    .btn-outline-pastel:hover {
      background: #90caf9;
      color: #1976d2;
    }
    .alert-pastel {
      background: #e3f2fd;
      color: #1976d2;
      border: 1px solid #90caf9;
      box-shadow: 0 2px 8px rgba(144,202,249,0.08);
    }
  </style>
<body>
  <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">
    <div class="container">
       <a href="javascript:history.back()" class="back-arrow" title="Volver atrás">
  <i class="fa-solid fa-arrow-left"></i>
</a>
      <a class="navbar-brand" href="#"><img src="../img/ELEFANTE.png" alt="Logo" style="width: 60px; height: 60px;"> EduSoft Nosotros</a>
    </div>
  </nav>
  <div class="layout"> 
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
