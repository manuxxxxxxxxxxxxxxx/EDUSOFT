<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciativas - EDUSOFT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="iniciativa.css">
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
                            <i class="fas fa-lightbulb"></i>
                            <span>Iniciativas</span>
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
    <section class="hero-iniciativas">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-badge">
                    <i class="fas fa-rocket"></i>
                    Transformando la Educación
                </span>
                <h1>Nuestras Iniciativas</h1>
                <p>Descubre cómo EDUSOFT está revolucionando la educación a través de proyectos innovadores que conectan tecnología, aprendizaje y oportunidades para todos.</p>
                <div class="hero-buttons">
                    <a href="#iniciativas-principales" class="btn-primary">
                        <i class="fas fa-arrow-down"></i>
                        Explorar Iniciativas
                    </a>
                    <a href="#impacto" class="btn-secondary">
                        <i class="fas fa-chart-line"></i>
                        Ver Impacto
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="floating-cards">
                    <div class="floating-card card-1">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Educación Digital</span>
                    </div>
                    <div class="floating-card card-2">
                        <i class="fas fa-laptop-code"></i>
                        <span>Tecnología</span>
                    </div>
                    <div class="floating-card card-3">
                        <i class="fas fa-users"></i>
                        <span>Comunidad</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Iniciativas Principales -->
    <section class="iniciativas-principales" id="iniciativas-principales">
        <div class="container">
            <div class="section-header">
                <h2>Iniciativas Principales</h2>
                <p>Proyectos que están marcando la diferencia en la educación global</p>
            </div>

            <div class="iniciativas-grid">
                <!-- Iniciativa 1 -->
                <div class="iniciativa-card featured">
                    <div class="card-image">
                        <img src="/img/aulas.webp" alt="Aulas Digitales">
                        <div class="card-badge">Destacada</div>
                    </div>
                    <div class="card-content">
                        <div class="card-category">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Infraestructura Digital
                        </div>
                        <h3>Aulas Digitales Inteligentes</h3>
                        <p>Transformamos espacios educativos tradicionales en entornos de aprendizaje interactivos equipados con tecnología de vanguardia.</p>
                        <div class="card-stats">
                            <div class="stat">
                                <span class="number">150+</span>
                                <span class="label">Aulas Equipadas</span>
                            </div>
                            <div class="stat">
                                <span class="number">25,000+</span>
                                <span class="label">Estudiantes Beneficiados</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Iniciativa 2 -->
                <div class="iniciativa-card">
                    <div class="card-image">
                        <img src="/img/becas.jpg" alt="Becas Tecnológicas">
                    </div>
                    <div class="card-content">
                        <div class="card-category">
                            <i class="fas fa-scholarship"></i>
                            Becas y Apoyo
                        </div>
                        <h3>Programa de Becas Tecnológicas</h3>
                        <p>Brindamos acceso gratuito a cursos de tecnología y programación para estudiantes de bajos recursos.</p>
                        <div class="card-stats">
                            <div class="stat">
                                <span class="number">500+</span>
                                <span class="label">Becas Otorgadas</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Iniciativa 3 -->
                <div class="iniciativa-card">
                    <div class="card-image">
                        <img src="/img/docentes.jpg" alt="Capacitación Docente">
                    </div>
                    <div class="card-content">
                        <div class="card-category">
                            <i class="fas fa-user-graduate"></i>
                            Formación Docente
                        </div>
                        <h3>Capacitación Docente Digital</h3>
                        <p>Formamos a educadores en el uso de herramientas digitales para mejorar la calidad educativa.</p>
                        <div class="card-stats">
                            <div class="stat">
                                <span class="number">1,200+</span>
                                <span class="label">Docentes Capacitados</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Iniciativa 4 -->
                <div class="iniciativa-card">
                    <div class="card-image">
                        <img src="/img/internet.jpg" alt="Conectividad Rural">
                    </div>
                    <div class="card-content">
                        <div class="card-category">
                            <i class="fas fa-wifi"></i>
                            Conectividad
                        </div>
                        <h3>Internet para Todos</h3>
                        <p>Llevamos conectividad a internet a comunidades rurales para garantizar el acceso a la educación digital.</p>
                        <div class="card-stats">
                            <div class="stat">
                                <span class="number">80+</span>
                                <span class="label">Comunidades Conectadas</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Iniciativa 5 -->
                <div class="iniciativa-card">
                    <div class="card-image">
                        <img src="/img/lobaratorios.jpg" alt="Laboratorios Móviles">
                    </div>
                    <div class="card-content">
                        <div class="card-category">
                            <i class="fas fa-truck"></i>
                            Innovación Móvil
                        </div>
                        <h3>Laboratorios Móviles</h3>
                        <p>Unidades móviles equipadas con tecnología que llegan a escuelas en zonas remotas.</p>
                        <div class="card-stats">
                            <div class="stat">
                                <span class="number">15</span>
                                <span class="label">Unidades Activas</span>
                            </div>
                        </div>

                    </div>
                </div>

                

            </div>
        </div>
    </section>

    <!-- Impacto Global -->
    <section class="impacto-global" id="impacto">
        <div class="container">
            <div class="section-header">
                <h2>Nuestro Impacto Global</h2>
                <p>Números que reflejan el alcance de nuestras iniciativas</p>
            </div>

            <div class="impacto-grid">
                <div class="impacto-card">
                    <div class="impacto-icon">
                        <i class="fas fa-globe-americas"></i>
                    </div>
                    <div class="impacto-number">25</div>
                    <div class="impacto-label">Países Alcanzados</div>
                    <div class="impacto-description">Presencia en 5 continentes</div>
                </div>

                <div class="impacto-card">
                    <div class="impacto-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="impacto-number">100K+</div>
                    <div class="impacto-label">Estudiantes Beneficiados</div>
                    <div class="impacto-description">Acceso a educación de calidad</div>
                </div>

                <div class="impacto-card">
                    <div class="impacto-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="impacto-number">500+</div>
                    <div class="impacto-label">Instituciones Aliadas</div>
                    <div class="impacto-description">Red educativa global</div>
                </div>

                <div class="impacto-card">
                    <div class="impacto-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="impacto-number">15</div>
                    <div class="impacto-label">Reconocimientos</div>
                    <div class="impacto-description">Premios internacionales</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonios">
        <div class="container">
            <div class="section-header">
                <h2>Historias de Éxito</h2>
                <p>Voces de quienes han sido parte de nuestras iniciativas</p>
            </div>

            <div class="testimonios-grid">
                <div class="testimonio-card">
                    <div class="testimonio-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"Gracias a EDUSOFT, nuestra escuela rural ahora tiene acceso a tecnología que antes parecía imposible. Los estudiantes están más motivados que nunca."</p>
                    </div>
                    <div class="testimonio-author">
                        <img src="/img/kim.jpg" alt="María González">
                        <div class="author-info">
                            <h4>María González</h4>
                            <span>Directora, Escuela Rural San José</span>
                        </div>
                    </div>
                </div>

                <div class="testimonio-card">
                    <div class="testimonio-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"El programa de becas tecnológicas cambió mi vida. Ahora trabajo como desarrollador gracias a las habilidades que aprendí."</p>
                    </div>
                    <div class="testimonio-author">
                        <img src="/img/carlos.jpg" alt="Carlos Mendoza">
                        <div class="author-info">
                            <h4>Carlos Mendoza</h4>
                            <span>Ex-becario, Desarrollador Full Stack</span>
                        </div>
                    </div>
                </div>

                <div class="testimonio-card">
                    <div class="testimonio-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"La capacitación docente me permitió integrar herramientas digitales en mis clases. Mis estudiantes aprenden de manera más interactiva."</p>
                    </div>
                    <div class="testimonio-author">
                        <img src="/img/sara.jpg" alt="Ana Rodríguez">
                        <div class="author-info">
                            <h4>Ana Rodríguez</h4>
                            <span>Profesora de Matemáticas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>¿Quieres ser parte del cambio?</h2>
                <p>Únete a nuestras iniciativas y ayuda a transformar la educación global</p>
                <div class="cta-buttons">
                    <a href="#" class="btn-primary">
                        <i class="fas fa-hands-helping"></i>
                        Colaborar con Nosotros
                    </a>
                    <a href="#" class="btn-secondary">
                        <i class="fas fa-download"></i>
                        Descargar Propuesta
                    </a>
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
                    <h4>Plataforma</h4>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Iniciativas</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Iniciativas</h4>
                    <ul>
                        <li><a href="#">Aulas Digitales</a></li>
                        <li><a href="#">Becas Tecnológicas</a></li>
                        <li><a href="#">Capacitación Docente</a></li>
                        <li><a href="#">Conectividad Rural</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Términos de Uso</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 EDUSOFT - Plataforma Educativa. Desarrollado por estudiantes de Bachillerato Técnico.</p>
        </div>
    </footer>

    <script src="iniciativas.js"></script>
</body>
</html>
