<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selección de Usuario - EDUSOFT</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="selection-container">
    <!-- Elementos decorativos de fondo -->
    <div class="background-elements">
      <div class="geometric-pattern"></div>
      <div class="code-rain"></div>
      <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
      </div>
    </div>

    <!-- Header innovador -->
    <header class="selection-header">
      <div class="header-content">
        <div class="logo-section">
          <div class="logo-container">
  <a href="javascript:history.back()" class="logo-back" title="Volver atrás">
    <img src="../img/ELEFANTE.png" alt="" class="logo">
  </a>
  <div class="logo-pulse"></div>
</div>
          <div class="logo-text">
            <h1>EDUSOFT</h1>
            <p data-i18n="innovacion">Innovación Educativa Digital</p>
          </div>
        </div>
        
        <div class="header-stats">
          <div class="stat-item">
            <span class="stat-number" data-target="1250">0</span>
            <span class="stat-label" data-i18n="estudiantes">Estudiantes</span>
          </div>
          <div class="stat-item">
            <span class="stat-number" data-target="85">0</span>
            <span class="stat-label" data-i18n="prefesores">Profesores</span>
          </div>
          <div class="stat-item">
            <span class="stat-number" data-target="12">0</span>
            <span class="stat-label" data-i18n="materias">Materias</span>
          </div>
      
        </div>
      </div>
    </header>
    

    <!-- Contenido principal -->
    <main class="selection-main">
      <!-- Sección de bienvenida con diseño único -->
      <div class="welcome-section">
        <div class="welcome-content">
          <div class="title-container">
            <h2 data-i18n="bienvenida">Bienvenido a <span class="highlight" data-i18n="bienvenida2"> nuestra plataforma educativa</span></h2>
            <div class="subtitle-animation">
              <p data-i18n="desarrollo" class="typing-text">Desarrollada por estudiantes para estudiantes y profesores</p>
            </div>
          </div>
          
          <div class="connection-line">
            <div class="line-segment"></div>
            <div class="center-node">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="line-segment"></div>
          </div>
        </div>
      </div>

      <!-- Tarjetas de usuario con diseño de 3 columnas -->
      <div class="user-selection-area">
        <div class="selection-grid-two">
          <!-- Tarjeta de Profesor -->
          <div class="user-card professor-card" data-user="professor">
            <div class="card-header">
              <div class="card-number">01</div>
              <div data-i18n="educador" class="card-category">Educador</div>
            </div>
            
            <div class="card-illustration">
              <svg class="custom-svg professor-svg" viewBox="0 0 200 200">
                <!-- Pizarra -->
                <rect x="20" y="40" width="120" height="80" rx="5" fill="#2c5f7e" stroke="#1a3a54" stroke-width="2"/>
                <rect x="25" y="45" width="110" height="70" fill="#34495e"/>
                <!-- Contenido de la pizarra -->
                <line x1="35" y1="55" x2="65" y2="55" stroke="#9fc7e8" stroke-width="2"/>
                <line x1="35" y1="65" x2="85" y2="65" stroke="#9fc7e8" stroke-width="2"/>
                <line x1="35" y1="75" x2="75" y2="75" stroke="#9fc7e8" stroke-width="2"/>
                <!-- Gráfico -->
                <polyline points="95,105 105,95 115,85 125,75" stroke="#ffc107" stroke-width="2" fill="none"/>
                <circle cx="95" cy="105" r="2" fill="#ffc107"/>
                <circle cx="105" cy="95" r="2" fill="#ffc107"/>
                <circle cx="115" cy="85" r="2" fill="#ffc107"/>
                <circle cx="125" cy="75" r="2" fill="#ffc107"/>
                <!-- Laptop -->
                <rect x="60" y="130" width="80" height="50" rx="3" fill="#ecf0f1" stroke="#bdc3c7" stroke-width="1"/>
                <rect x="65" y="135" width="70" height="40" fill="#2c3e50"/>
                <line x1="75" y1="145" x2="95" y2="145" stroke="#9fc7e8" stroke-width="1"/>
                <line x1="75" y1="150" x2="125" y2="150" stroke="#9fc7e8" stroke-width="1"/>
                <line x1="75" y1="155" x2="115" y2="155" stroke="#9fc7e8" stroke-width="1"/>
                <!-- Elementos decorativos -->
                <circle cx="160" cy="60" r="15" fill="rgba(159, 199, 232, 0.3)"/>
                <polygon points="170,100 180,120 160,120" fill="rgba(255, 193, 7, 0.3)"/>
              </svg>
            </div>
            
            <div class="card-content">
              <h3 data-i18n="soyprofe">Soy Profesor</h3>
              <p data-i18n="p_profe">Herramientas avanzadas para crear, gestionar y evaluar contenido educativo de manera eficiente</p>
              
              <div class="features-grid">
                <div class="feature-item">
                  <i class="fas fa-chalkboard-teacher"></i>
                  <span data-i18n="gestion">Gestión de Clases</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-file-upload"></i>
                  <span data-i18n="subir">Subir Contenido</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-chart-line"></i>
                  <span data-i18n="analasis">Análisis de Progreso</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-clipboard-check"></i>
                  <span data-i18n="evaluaciones">Evaluaciones</span>
                </div>
              </div>
            </div>
            
            <button class="access-btn professor-btn" onclick="window.location.href='../Registros/registroProfe.php'">
              <span class="btn-text" data-i18n="acceder_como">Acceder como Profesor</span>
              <div class="btn-icon">
                <i class="fas fa-arrow-right"></i>
              </div>
              <div class="btn-ripple"></div>
            </button>
          </div>

          <!-- Tarjeta de Estudiante -->
          <div class="user-card student-card" data-user="student">
            <div class="card-header">
              <div class="card-number">02</div>
              <div class="card-category" data-i18n="estudiante">Estudiante</div>
            </div>
            
            <div class="card-illustration">
              <svg class="custom-svg student-svg" viewBox="0 0 200 200">
                <!-- Escritorio -->
                <rect x="30" y="140" width="140" height="40" rx="5" fill="#ecf0f1" stroke="#bdc3c7" stroke-width="2"/>
                <!-- Laptop abierta -->
                <rect x="60" y="100" width="80" height="50" rx="3" fill="#2c3e50" stroke="#34495e" stroke-width="2"/>
                <rect x="65" y="105" width="70" height="40" fill="#3498db"/>
                <!-- Pantalla con código -->
                <line x1="75" y1="115" x2="95" y2="115" stroke="#fff" stroke-width="1"/>
                <line x1="75" y1="120" x2="125" y2="120" stroke="#9fc7e8" stroke-width="1"/>
                <line x1="85" y1="125" x2="115" y2="125" stroke="#fff" stroke-width="1"/>
                <line x1="75" y1="130" x2="105" y2="130" stroke="#ffc107" stroke-width="1"/>
                <line x1="95" y1="135" x2="125" y2="135" stroke="#fff" stroke-width="1"/>
                <!-- Libros apilados -->
                <rect x="20" y="120" width="30" height="4" fill="#e74c3c"/>
                <rect x="22" y="115" width="26" height="4" fill="#3498db"/>
                <rect x="24" y="110" width="22" height="4" fill="#2ecc71"/>
                <!-- Taza de café -->
                <ellipse cx="160" cy="130" rx="8" ry="6" fill="#8b4513"/>
                <ellipse cx="160" cy="128" rx="6" ry="4" fill="#d2691e"/>
                <path d="M 168 130 Q 175 125 175 135 Q 175 145 168 140" stroke="#8b4513" stroke-width="2" fill="none"/>
                <!-- Elementos flotantes de aprendizaje -->
                <circle cx="40" cy="70" r="12" fill="rgba(52, 152, 219, 0.3)"/>
                <text x="40" y="75" text-anchor="middle" fill="#3498db" font-size="10" font-weight="bold">A+</text>
                <polygon points="160,50 170,70 150,70" fill="rgba(46, 204, 113, 0.3)"/>
                <text x="160" y="65" text-anchor="middle" fill="#2ecc71" font-size="8">✓</text>
                <!-- Bombilla de idea -->
                <circle cx="100" cy="40" r="8" fill="#f39c12" opacity="0.7"/>
                <rect x="97" y="48" width="6" height="8" fill="#f39c12" opacity="0.7"/>
                <line x1="95" y1="56" x2="105" y2="56" stroke="#f39c12" stroke-width="2"/>
              </svg>
            </div>
            
            <div class="card-content">
              <h3 data-i18n="soyestudiante">Soy Estudiante</h3>
              <p data-i18n="p_estudiante">Accede a cursos interactivos, realiza actividades y sigue tu progreso académico personalizado</p>
              
              <div class="features-grid">
                <div class="feature-item">
                  <i class="fas fa-book-open"></i>
                  <span data-i18n="cursos">Cursos Interactivos</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-tasks"></i>
                  <span data-i18n="actividades">Actividades</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-trophy"></i>
                  <span data-i18n="logros">Logros</span>
                </div>
                <div class="feature-item">
                  <i class="fas fa-chart-bar"></i>
                  <span data-i18n="progreso">Mi Progreso</span>
                </div>
              </div>
            </div>
            
            <button class="access-btn student-btn" onclick="window.location.href='../Registros/Registro.php'">
              <span class="btn-text" data-i18n="acceder_estudiante">Acceder como Estudiante</span>
              <div class="btn-icon">
                <i class="fas fa-arrow-right"></i>
              </div>
              <div class="btn-ripple"></div>
            </button>
          </div>

          <!-- Tarjeta de Administrador -->

        </div>
      </div>

      <!-- Sección de información adicional con diseño innovador -->
      <div class="additional-section">
        <div class="section-title">
          <h3 data-i18n="porque">¿Por qué elegir nuestra plataforma?</h3>
          <div class="title-underline"></div>
        </div>
        
        <div class="info-grid">
          <div class="info-card">
            <div class="card-icon">
              <i class="fas fa-code"></i>
            </div>
            <h4 data-i18n="desarrollada">Desarrollado por Estudiantes</h4>
            <p data-i18n="creado">Creado por estudiantes de bachillerato técnico que entienden las necesidades reales del aprendizaje moderno</p>
          </div>
          
          <div class="info-card">
            <div class="card-icon">
              <i class="fas fa-rocket"></i>
            </div>
            <h4 data-i18n="tecnologia">Tecnología Moderna</h4>
            <p data-i18n="tecnologias">Utilizamos las últimas tecnologías web para ofrecer una experiencia rápida, segura y confiable</p>
          </div>
          
          <div class="info-card">
            <div class="card-icon">
              <i class="fas fa-users"></i>
            </div>
            <h4 data-i18n="comunidad">Comunidad Activa</h4>
            <p data-i18n="aprandizaje">Únete a una comunidad de aprendizaje donde estudiantes y profesores colaboran activamente</p>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer con diseño único -->
    <footer class="selection-footer">
      <div class="footer-pattern"></div>
      <div class="footer-content">
        <div class="footer-left">
          <p>&copy; EDUSOFT</p>
          <span class="footer-separator">|</span>
          <p data-i18n="edusoft">Desarrollado con  <i class="fas fa-heart heart-beat"></i> por estudiantes de Bachillerato Técnico</p>
        </div>
        <div class="footer-right">
          <div class="footer-links">
            <a href="nosotros.php" data-i18n="nosotros">Nosotros</a>
            <a href="#" data-i18n="ayuda">Ayuda</a>
            <a href="#" data-i18n="contacto">Contacto</a>
          </div>
          <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="registro.js"></script>
  <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>