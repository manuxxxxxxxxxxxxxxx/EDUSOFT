<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Misión - EDUSOFT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="mision.css">
</head>
<body>
    <!-- Navbar mejorado -->
    <header class="navbar">
        <nav class="nav-container">
            <!-- Logo y marca -->
            <div class="nav-brand">
                <a href="index.html" class="brand-link">
                    <img src="/img/EDUSOFT2.png" alt="EDUSOFT Logo" class="brand-logo">
                </a>
            </div>

            <!-- Enlaces de navegación -->
            <div class="nav-links" id="navLinks">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Inicio</span>
                        </a>
                    </li>

                    <li class="nav-item">
                            <a href="http://127.0.0.1:5000/" class="nav-link">
                                <i class="fas fa-robot"></i>
                                <span data-i18n="AteneaV">Atenea</span>
                            </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link active">
                            <i class="fas fa-bullseye"></i>
                            <span>Misión</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/nosotros/nosotros.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Nosotros</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/contactanos/contactanos.php" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Contacto</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Botones de acción -->
            <div class="nav-actions">
                    <a data-i18n="iniciarS" href="/registrosCards/Inicio.php" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                    <a data-i18n="unete" href="/registrosCards/registro.php" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Únete
                    </a>
            </div>

            <!-- Botón hamburguesa para móvil -->
            <button class="nav-toggle" id="navToggle">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-mision">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-badge">
                    <i class="fas fa-heart"></i>
                    Nuestro Propósito
                </span>
                <h1>Nuestra Misión</h1>
                <p class="hero-mission-statement">
                    "Democratizar el acceso a la educación de calidad mediante tecnología innovadora, 
                    empoderando a estudiantes de todas las condiciones socioeconómicas para alcanzar 
                    su máximo potencial académico y profesional."
                </p>
                <div class="hero-buttons">
                    <a href="#mision-detallada" class="btn-primary">
                        <i class="fas fa-arrow-down"></i>
                        Conocer Más
                    </a>
                    <a href="#impacto-mision" class="btn-secondary">
                        <i class="fas fa-chart-bar"></i>
                        Ver Impacto
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="mission-circle">
                    <div class="circle-content">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Educación para Todos</span>
                    </div>
                    <div class="orbit-item orbit-1">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="orbit-item orbit-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="orbit-item orbit-3">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="orbit-item orbit-4">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión Detallada -->
    <section class="mision-detallada" id="mision-detallada">
        <div class="container">
            <div class="section-header">
                <h2>¿Por qué Existimos?</h2>
                <p>Nuestra misión va más allá de la tecnología: transformamos vidas a través de la educación</p>
            </div>

            <div class="mision-content">
                <div class="mision-main">
                    <div class="mision-text">
                        <h3>El Desafío que Enfrentamos</h3>
                        <p>
                            En un mundo cada vez más digitalizado, millones de estudiantes siguen sin acceso 
                            a herramientas educativas modernas. La brecha digital no solo limita el aprendizaje, 
                            sino que perpetúa desigualdades sociales y económicas.
                        </p>
                        
                        <h3>Nuestra Respuesta</h3>
                        <p>
                            EDUSOFT nace como respuesta a esta realidad. Creemos firmemente que la educación 
                            de calidad es un derecho fundamental, no un privilegio. Por eso, desarrollamos 
                            soluciones tecnológicas accesibles que eliminan barreras geográficas, económicas 
                            y sociales.
                        </p>

                        <div class="mision-pillars">
                            <div class="pillar">
                                <div class="pillar-icon">
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <h4>Accesibilidad Universal</h4>
                                <p>Educación sin barreras para todos los estudiantes</p>
                            </div>
                            <div class="pillar">
                                <div class="pillar-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h4>Innovación Constante</h4>
                                <p>Tecnología de vanguardia al servicio del aprendizaje</p>
                            </div>
                            <div class="pillar">
                                <div class="pillar-icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <h4>Impacto Social</h4>
                                <p>Transformación positiva de comunidades enteras</p>
                            </div>
                        </div>
                    </div>
                    <div class="mision-visual">
                        <img src="/img/tecnologia.jpg" alt="Estudiantes usando tecnología">
                        <div class="visual-overlay">
                            <div class="stat-bubble bubble-1">
                                <span class="number">100K+</span>
                                <span class="label">Vidas Transformadas</span>
                            </div>
                            <div class="stat-bubble bubble-2">
                                <span class="number">25</span>
                                <span class="label">Países Alcanzados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores y Principios -->
   

    <!-- Visión y Futuro -->
    <section class="vision-futuro">
        <div class="container">
            <div class="vision-content">
                <div class="vision-text">
                    <span class="section-badge">
                        <i class="fas fa-telescope"></i>
                        Mirando al Futuro
                    </span>
                    <h2>Nuestra Visión 2030</h2>
                    <p class="vision-statement">
                        "Ser la plataforma educativa líder a nivel mundial, reconocida por eliminar 
                        la brecha digital educativa y empoderar a 10 millones de estudiantes para 
                        construir un futuro más equitativo y próspero."
                    </p>
                    
                    <div class="vision-goals">
                        <div class="goal">
                            <div class="goal-number">10M</div>
                            <div class="goal-text">Estudiantes Empoderados</div>
                        </div>
                        <div class="goal">
                            <div class="goal-number">100</div>
                            <div class="goal-text">Países con Presencia</div>
                        </div>
                        <div class="goal">
                            <div class="goal-number">50K</div>
                            <div class="goal-text">Educadores Capacitados</div>
                        </div>
                    </div>

                    <div class="roadmap">
                        <h3>Hoja de Ruta</h3>
                        <div class="roadmap-items">
                            <div class="roadmap-item">
                                <div class="year">2024</div>
                                <div class="milestone">Expansión a 10 nuevos países</div>
                            </div>
                            <div class="roadmap-item">
                                <div class="year">2026</div>
                                <div class="milestone">IA personalizada para cada estudiante</div>
                            </div>
                            <div class="roadmap-item">
                                <div class="year">2028</div>
                                <div class="milestone">Realidad virtual en todas las aulas</div>
                            </div>
                            <div class="roadmap-item">
                                <div class="year">2030</div>
                                <div class="milestone">Meta de 10M estudiantes alcanzada</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vision-visual">
                    <div class="future-globe">
                        <img src="/img/mundo.jpg" alt="Mundo conectado">
                        <div class="connection-lines">
                            <div class="line line-1"></div>
                            <div class="line line-2"></div>
                            <div class="line line-3"></div>
                            <div class="line line-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Cumplimos la Misión -->
    <section class="como-cumplimos">
        <div class="container">
            <div class="section-header">
                <h2>Cómo Hacemos Realidad Nuestra Misión</h2>
                <p>Estrategias concretas que nos permiten transformar vidas a través de la educación</p>
            </div>

            <div class="estrategias-grid">
                <div class="estrategia-card">
                    <div class="estrategia-number">01</div>
                    <div class="estrategia-content">
                        <h3>Tecnología Accesible</h3>
                        <p>Desarrollamos plataformas que funcionan incluso con conexiones lentas y dispositivos básicos.</p>
                        <ul>
                            <li>Aplicaciones offline</li>
                            <li>Interfaz optimizada</li>
                            <li>Soporte multiplataforma</li>
                        </ul>
                    </div>
                </div>

                <div class="estrategia-card">
                    <div class="estrategia-number">02</div>
                    <div class="estrategia-content">
                        <h3>Contenido Localizado</h3>
                        <p>Adaptamos nuestros materiales a las necesidades culturales y lingüísticas de cada región.</p>
                        <ul>
                            <li>Traducción a idiomas locales</li>
                            <li>Contextos culturales relevantes</li>
                            <li>Colaboración con educadores locales</li>
                        </ul>
                    </div>
                </div>

                <div class="estrategia-card">
                    <div class="estrategia-number">03</div>
                    <div class="estrategia-content">
                        <h3>Alianzas Estratégicas</h3>
                        <p>Trabajamos con gobiernos, ONGs y empresas para maximizar nuestro alcance e impacto.</p>
                        <ul>
                            <li>Partnerships gubernamentales</li>
                            <li>Colaboración con universidades</li>
                            <li>Apoyo de organizaciones internacionales</li>
                        </ul>
                    </div>
                </div>

                <div class="estrategia-card">
                    <div class="estrategia-number">04</div>
                    <div class="estrategia-content">
                        <h3>Formación Docente</h3>
                        <p>Capacitamos a educadores para que puedan aprovechar al máximo nuestras herramientas.</p>
                        <ul>
                            <li>Programas de certificación</li>
                            <li>Talleres presenciales y virtuales</li>
                            <li>Comunidad de práctica</li>
                        </ul>
                    </div>
                </div>

                <div class="estrategia-card">
                    <div class="estrategia-number">05</div>
                    <div class="estrategia-content">
                        <h3>Medición de Impacto</h3>
                        <p>Evaluamos constantemente nuestros resultados para mejorar y demostrar efectividad.</p>
                        <ul>
                            <li>Métricas de aprendizaje</li>
                            <li>Estudios longitudinales</li>
                            <li>Reportes de transparencia</li>
                        </ul>
                    </div>
                </div>

                <div class="estrategia-card">
                    <div class="estrategia-number">06</div>
                    <div class="estrategia-content">
                        <h3>Innovación Continua</h3>
                        <p>Invertimos en investigación y desarrollo para mantenernos a la vanguardia educativa.</p>
                        <ul>
                            <li>Laboratorio de innovación</li>
                            <li>Inteligencia artificial</li>
                            <li>Realidad aumentada y virtual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impacto de la Misión -->
    <section class="impacto-mision" id="impacto-mision">
        <div class="container">
            <div class="section-header">
                <h2>El Impacto de Nuestra Misión</h2>
                <p>Resultados tangibles que demuestran cómo estamos cumpliendo nuestro propósito</p>
            </div>

            <div class="impacto-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number" data-target="125000">0</div>
                    <div class="stat-label">Estudiantes Graduados</div>
                    <div class="stat-description">Con certificaciones reconocidas internacionalmente</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-number" data-target="89">0</div>
                    <div class="stat-suffix">%</div>
                    <div class="stat-label">Mejora en Calificaciones</div>
                    <div class="stat-description">Promedio de mejora académica de nuestros estudiantes</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-number" data-target="78">0</div>
                    <div class="stat-suffix">%</div>
                    <div class="stat-label">Inserción Laboral</div>
                    <div class="stat-description">De graduados consiguen empleo en 6 meses</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-number" data-target="45">0</div>
                    <div class="stat-suffix">%</div>
                    <div class="stat-label">Aumento Salarial</div>
                    <div class="stat-description">Incremento promedio en ingresos post-graduación</div>
                </div>
            </div>

            <div class="success-stories">
                <h3>Historias de Transformación</h3>
                <div class="stories-grid">
                    <div class="story-card">
                        <div class="story-image">
                            <img src="/img/kim.jpg" alt="María - Estudiante rural">
                        </div>
                        <div class="story-content">
                            <h4>María González</h4>
                            <span class="story-location">Oaxaca, México</span>
                            <p>"Gracias a EDUSOFT pude estudiar programación desde mi comunidad rural. Ahora trabajo remotamente para una empresa en Ciudad de México y ayudo a mi familia."</p>
                            <div class="story-impact">
                                <span class="impact-tag">Desarrollo Rural</span>
                                <span class="impact-tag">Empoderamiento Femenino</span>
                            </div>
                        </div>
                    </div>

                    <div class="story-card">
                        <div class="story-image">
                            <img src="/img/carlos.jpg" alt="Carlos - Docente">
                        </div>
                        <div class="story-content">
                            <h4>Carlos Mendoza</h4>
                            <span class="story-location">Lima, Perú</span>
                            <p>"Como docente, EDUSOFT me dio las herramientas para transformar mis clases. Mis estudiantes ahora participan más y aprenden mejor."</p>
                            <div class="story-impact">
                                <span class="impact-tag">Formación Docente</span>
                                <span class="impact-tag">Innovación Pedagógica</span>
                            </div>
                        </div>
                    </div>

                    <div class="story-card">
                        <div class="story-image">
                            <img src="/img/sara.jpg" alt="Ana - Emprendedora">
                        </div>
                        <div class="story-content">
                            <h4>Ana Rodríguez</h4>
                            <span class="story-location">Bogotá, Colombia</span>
                            <p>"Los cursos de matematicas me ayudaron a crear mi propia empresa. Ahora genero empleo para 15 personas en mi comunidad."</p>
                            <div class="story-impact">
                                <span class="impact-tag">Emprendimiento</span>
                                <span class="impact-tag">Generación de Empleo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-mision">
        <div class="container">
            <div class="cta-content">
                <h2>Únete a Nuestra Misión</h2>
                <p>Juntos podemos transformar la educación y crear un futuro más equitativo para todos</p>
                <div class="cta-options">
                    <div class="cta-option">
                        <div class="option-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Como Estudiante</h3>
                        <p>Accede a educación de calidad y transforma tu futuro</p>
                        <a href="#" class="option-btn">Comenzar Ahora</a>
                    </div>
                    <div class="cta-option">
                        <div class="option-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>Como Educador</h3>
                        <p>Únete a nuestra red de docentes innovadores</p>
                        <a href="#" class="option-btn">Ser Parte</a>
                    </div>
                    <div class="cta-option">
                        <div class="option-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Como Aliado</h3>
                        <p>Colabora con nosotros para amplificar el impacto</p>
                        <a href="#" class="option-btn">Colaborar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="/img/ELEFANTE.png" alt="Logo EDUSOFT" class="logo">
                <h3>EDUSOFT</h3>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Nuestra Misión</h4>
                    <ul>
                        <li><a href="#">Qué Hacemos</a></li>
                        <li><a href="#">Nuestros Valores</a></li>
                        <li><a href="#">Visión 2030</a></li>
                        <li><a href="#">Impacto Social</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Únete</h4>
                    <ul>
                        <li><a href="#">Como Estudiante</a></li>
                        <li><a href="#">Como Educador</a></li>
                        <li><a href="#">Como Aliado</a></li>
                        <li><a href="#">Voluntariado</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Transparencia</h4>
                    <ul>
                        <li><a href="#">Reportes de Impacto</a></li>
                        <li><a href="#">Finanzas</a></li>
                        <li><a href="#">Gobernanza</a></li>
                        <li><a href="#">Auditorías</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 EDUSOFT - Transformando vidas a través de la educación. Desarrollado por estudiantes de Bachillerato Técnico.</p>
        </div>
    </footer>

    <script src="mision.js"></script>
</body>
</html>
