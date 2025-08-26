<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuestros Valores - EDUSOFT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="valores.css">
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
                        <a href="" class="nav-link active">
                            <i class="fas fa-heart"></i>
                            <span>Valores</span>
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
    <section class="hero-valores">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-badge">
                    <i class="fas fa-gem"></i>
                    Lo Que Nos Define
                </span>
                <h1>Nuestros Valores</h1>
                <p class="hero-statement">
                    "Los valores no son solo palabras en una pared. Son la brújula que guía cada decisión, 
                    cada acción y cada sueño que hacemos realidad en EDUSOFT."
                </p>
                <div class="hero-buttons">
                    <a href="#valores-principales" class="btn-primary">
                        <i class="fas fa-arrow-down"></i>
                        Descubrir Valores
                    </a>
                    <a href="#valores-accion" class="btn-secondary">
                        <i class="fas fa-play"></i>
                        Ver en Acción
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="valores-constellation">
                    <div class="constellation-center">
                        <i class="fas fa-heart"></i>
                        <span>EDUSOFT</span>
                    </div>
                    <div class="valor-orbit orbit-1">
                        <div class="valor-point">
                            <i class="fas fa-balance-scale"></i>
                            <span>Equidad</span>
                        </div>
                    </div>
                    <div class="valor-orbit orbit-2">
                        <div class="valor-point">
                            <i class="fas fa-rocket"></i>
                            <span>Innovación</span>
                        </div>
                    </div>
                    <div class="valor-orbit orbit-3">
                        <div class="valor-point">
                            <i class="fas fa-shield-alt"></i>
                            <span>Integridad</span>
                        </div>
                    </div>
                    <div class="valor-orbit orbit-4">
                        <div class="valor-point">
                            <i class="fas fa-hands-helping"></i>
                            <span>Colaboración</span>
                        </div>
                    </div>
                    <div class="valor-orbit orbit-5">
                        <div class="valor-point">
                            <i class="fas fa-leaf"></i>
                            <span>Sostenibilidad</span>
                        </div>
                    </div>
                    <div class="valor-orbit orbit-6">
                        <div class="valor-point">
                            <i class="fas fa-star"></i>
                            <span>Excelencia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Introducción a los Valores -->
    <section class="intro-valores">
        <div class="container">
            <div class="intro-content">
                <div class="intro-text">
                    <h2>Más que Principios, Son Nuestro ADN</h2>
                    <p>
                        En EDUSOFT, nuestros valores no son conceptos abstractos colgados en la pared. 
                        Son la fuerza motriz detrás de cada línea de código, cada aula digital que construimos, 
                        cada estudiante que empoderamos y cada sueño que ayudamos a hacer realidad.
                    </p>
                    <p>
                        Estos valores nacieron de la convicción profunda de que la educación puede y debe 
                        ser el gran ecualizador de oportunidades en el mundo. Cada día, millones de personas 
                        en nuestro equipo, estudiantes y comunidades aliadas viven estos valores, 
                        transformándolos en acciones concretas que cambian vidas.
                    </p>
                    <div class="intro-stats">
                        <div class="stat-item">
                            <div class="stat-number" data-target="100">0</div>
                            <div class="stat-label">% de Decisiones Basadas en Valores</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-target="6">0</div>
                            <div class="stat-label">Valores Fundamentales</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-target="1000000">0</div>
                            <div class="stat-label">Vidas Impactadas por Nuestros Valores</div>
                        </div>
                    </div>
                </div>
                <div class="intro-visual">
                    <div class="values-tree">
                        <div class="tree-trunk"></div>
                        <div class="tree-branches">
                            <div class="branch branch-1"></div>
                            <div class="branch branch-2"></div>
                            <div class="branch branch-3"></div>
                            <div class="branch branch-4"></div>
                            <div class="branch branch-5"></div>
                            <div class="branch branch-6"></div>
                        </div>
                        <div class="tree-leaves">
                            <div class="leaf leaf-1"><i class="fas fa-graduation-cap"></i></div>
                            <div class="leaf leaf-2"><i class="fas fa-globe"></i></div>
                            <div class="leaf leaf-3"><i class="fas fa-lightbulb"></i></div>
                            <div class="leaf leaf-4"><i class="fas fa-users"></i></div>
                            <div class="leaf leaf-5"><i class="fas fa-heart"></i></div>
                            <div class="leaf leaf-6"><i class="fas fa-star"></i></div>
                        </div>
                        <div class="tree-roots">
                            <div class="root root-1"></div>
                            <div class="root root-2"></div>
                            <div class="root root-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores Principales -->
    <section class="valores-principales" id="valores-principales">
        <div class="container">
            <div class="section-header">
                <h2>Los 6 Pilares de EDUSOFT</h2>
                <p>Cada valor es una promesa que hacemos al mundo y a nosotros mismos</p>
            </div>

            <div class="valores-grid">
                <!-- Valor 1: Equidad -->
                <div class="valor-card" data-valor="equidad">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="valor-number">01</div>
                    </div>
                    <div class="valor-content">
                        <h3>Equidad e Inclusión</h3>
                        <p class="valor-description">
                            Creemos firmemente que cada persona, sin importar su origen, ubicación geográfica 
                            o situación económica, merece acceso a una educación de calidad mundial.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Becas completas para estudiantes de bajos recursos</li>
                                <li>Contenido adaptado a diferentes culturas y idiomas</li>
                                <li>Tecnología accesible para personas con discapacidades</li>
                                <li>Programas especiales para comunidades marginadas</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">85%</span>
                                <span class="impact-label">de nuestros estudiantes provienen de comunidades vulnerables</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"La equidad no es dar a todos lo mismo, sino dar a cada uno lo que necesita para triunfar."</p>
                            <span class="quote-author">- Filosofía EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Valor 2: Innovación -->
                <div class="valor-card" data-valor="innovacion">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="valor-number">02</div>
                    </div>
                    <div class="valor-content">
                        <h3>Innovación y Excelencia</h3>
                        <p class="valor-description">
                            No nos conformamos con lo existente. Constantemente buscamos formas revolucionarias 
                            de hacer que el aprendizaje sea más efectivo, atractivo y transformador.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Inversión del 25% de ingresos en I+D</li>
                                <li>Laboratorio de innovación educativa</li>
                                <li>Inteligencia artificial personalizada</li>
                                <li>Realidad virtual y aumentada en aulas</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">150+</span>
                                <span class="impact-label">patentes de tecnología educativa registradas</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"La innovación es nuestra forma de honrar el potencial ilimitado de cada estudiante."</p>
                            <span class="quote-author">- Equipo de Innovación EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Valor 3: Integridad -->
                <div class="valor-card" data-valor="integridad">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="valor-number">03</div>
                    </div>
                    <div class="valor-content">
                        <h3>Integridad y Transparencia</h3>
                        <p class="valor-description">
                            Actuamos con honestidad absoluta en cada decisión. Nuestros estudiantes, 
                            socios y comunidades merecen transparencia total en todo lo que hacemos.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Reportes públicos trimestrales de impacto</li>
                                <li>Auditorías independientes anuales</li>
                                <li>Código de ética estricto para todo el equipo</li>
                                <li>Política de puertas abiertas con la comunidad</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">100%</span>
                                <span class="impact-label">transparencia en el uso de fondos y recursos</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"La confianza se construye con transparencia y se mantiene con integridad."</p>
                            <span class="quote-author">- Consejo Directivo EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Valor 4: Colaboración -->
                <div class="valor-card" data-valor="colaboracion">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="valor-number">04</div>
                    </div>
                    <div class="valor-content">
                        <h3>Colaboración y Comunidad</h3>
                        <p class="valor-description">
                            Sabemos que los grandes cambios solo suceden cuando trabajamos juntos. 
                            Construimos puentes entre estudiantes, educadores, familias y comunidades.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Red global de 50,000+ educadores colaboradores</li>
                                <li>Plataformas de co-creación de contenido</li>
                                <li>Alianzas estratégicas con universidades</li>
                                <li>Programas de mentoría peer-to-peer</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">500+</span>
                                <span class="impact-label">organizaciones aliadas en todo el mundo</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"Solos podemos hacer poco; juntos podemos transformar el mundo."</p>
                            <span class="quote-author">- Red de Colaboradores EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Valor 5: Sostenibilidad -->
                <div class="valor-card" data-valor="sostenibilidad">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="valor-number">05</div>
                    </div>
                    <div class="valor-content">
                        <h3>Sostenibilidad y Responsabilidad</h3>
                        <p class="valor-description">
                            Construimos para las generaciones futuras. Cada decisión considera su impacto 
                            a largo plazo en el planeta, las comunidades y la educación global.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Operaciones 100% carbono neutral</li>
                                <li>Capacitación local para autonomía tecnológica</li>
                                <li>Materiales educativos reutilizables y adaptables</li>
                                <li>Programas de economía circular en tecnología</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">0</span>
                                <span class="impact-label">huella de carbono neta en nuestras operaciones</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"No heredamos la Tierra de nuestros ancestros; la tomamos prestada de nuestros hijos."</p>
                            <span class="quote-author">- Compromiso Ambiental EDUSOFT</span>
                        </div>
                    </div>
                </div>

                <!-- Valor 6: Excelencia -->
                <div class="valor-card" data-valor="excelencia">
                    <div class="valor-header">
                        <div class="valor-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="valor-number">06</div>
                    </div>
                    <div class="valor-content">
                        <h3>Excelencia y Mejora Continua</h3>
                        <p class="valor-description">
                            Nos comprometemos con los más altos estándares de calidad en todo lo que hacemos. 
                            La excelencia no es un destino, sino un viaje de mejora constante.
                        </p>
                        <div class="valor-details">
                            <h4>¿Cómo lo vivimos?</h4>
                            <ul>
                                <li>Certificaciones internacionales de calidad</li>
                                <li>Evaluación continua de programas educativos</li>
                                <li>Feedback constante de estudiantes y educadores</li>
                                <li>Benchmarking con las mejores prácticas mundiales</li>
                            </ul>
                        </div>
                        <div class="valor-impact">
                            <div class="impact-stat">
                                <span class="impact-number">98%</span>
                                <span class="impact-label">satisfacción de estudiantes con nuestros programas</span>
                            </div>
                        </div>
                        <div class="valor-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"La excelencia es un hábito, no un acto. Somos lo que hacemos repetidamente."</p>
                            <span class="quote-author">- Estándar de Calidad EDUSOFT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores en Acción -->
    <section class="valores-accion" id="valores-accion">
        <div class="container">
            <div class="section-header">
                <h2>Nuestros Valores en Acción</h2>
                <p>Historias reales de cómo nuestros valores transforman vidas cada día</p>
            </div>

            <div class="accion-timeline">
                <div class="timeline-item" data-valor="equidad">
                    <div class="timeline-marker">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-badge">Equidad en Acción</div>
                        <h3>Programa "Oportunidades Sin Fronteras"</h3>
                        <p>
                            Cuando María, una joven de una comunidad rural en Guatemala, no podía costear 
                            sus estudios universitarios, nuestro valor de equidad se activó. No solo le 
                            otorgamos una beca completa, sino que adaptamos todo el contenido a su idioma 
                            nativo y le proporcionamos un mentor personal.
                        </p>
                        <div class="timeline-result">
                            <strong>Resultado:</strong> María se graduó como ingeniera de software y ahora 
                            lidera un centro tecnológico que ha beneficiado a 500+ jóvenes de su región.
                        </div>
                        <div class="timeline-stats">
                            <div class="stat">
                                <span class="number">2,500+</span>
                                <span class="label">Becas similares otorgadas</span>
                            </div>
                            <div class="stat">
                                <span class="number">15</span>
                                <span class="label">Idiomas locales incluidos</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-valor="innovacion">
                    <div class="timeline-marker">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-badge">Innovación en Acción</div>
                        <h3>Aulas Virtuales con IA Emocional</h3>
                        <p>
                            Cuando notamos que muchos estudiantes se sentían desconectados en el aprendizaje 
                            virtual, nuestro valor de innovación nos llevó a desarrollar la primera IA 
                            educativa que reconoce y responde a las emociones de los estudiantes en tiempo real.
                        </p>
                        <div class="timeline-result">
                            <strong>Resultado:</strong> 89% de mejora en engagement estudiantil y 67% 
                            reducción en tasas de abandono escolar.
                        </div>
                        <div class="timeline-stats">
                            <div class="stat">
                                <span class="number">1M+</span>
                                <span class="label">Estudiantes usando IA emocional</span>
                            </div>
                            <div class="stat">
                                <span class="number">3</span>
                                <span class="label">Patentes internacionales</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-valor="integridad">
                    <div class="timeline-marker">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-badge">Integridad en Acción</div>
                        <h3>Transparencia Total en Crisis</h3>
                        <p>
                            Durante la pandemia, cuando muchas organizaciones ocultaron sus dificultades, 
                            nuestro valor de integridad nos llevó a ser completamente transparentes sobre 
                            nuestros desafíos financieros y operativos con toda nuestra comunidad.
                        </p>
                        <div class="timeline-result">
                            <strong>Resultado:</strong> La comunidad respondió con apoyo masivo, donaciones 
                            voluntarias y colaboración que nos permitió no solo sobrevivir, sino expandirnos.
                        </div>
                        <div class="timeline-stats">
                            <div class="stat">
                                <span class="number">$2.5M</span>
                                <span class="label">Donaciones comunitarias</span>
                            </div>
                            <div class="stat">
                                <span class="number">100%</span>
                                <span class="label">Transparencia financiera</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-valor="colaboracion">
                    <div class="timeline-marker">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-badge">Colaboración en Acción</div>
                        <h3>Red Global de Mentores</h3>
                        <p>
                            Cuando nos dimos cuenta de que el conocimiento técnico no era suficiente, 
                            nuestro valor de colaboración nos inspiró a crear una red donde profesionales 
                            exitosos mentorean a estudiantes de todo el mundo, sin importar las barreras geográficas.
                        </p>
                        <div class="timeline-result">
                            <strong>Resultado:</strong> 78% de estudiantes mentorados consiguen empleo 
                            en menos de 6 meses, comparado con 34% sin mentoría.
                        </div>
                        <div class="timeline-stats">
                            <div class="stat">
                                <span class="number">25,000+</span>
                                <span class="label">Mentores voluntarios activos</span>
                            </div>
                            <div class="stat">
                                <span class="number">85</span>
                                <span class="label">Países en la red</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Compromiso de Valores -->
    <section class="compromiso-valores">
        <div class="container">
            <div class="compromiso-content">
                <div class="compromiso-text">
                    <h2>Nuestro Compromiso Inquebrantable</h2>
                    <p class="compromiso-intro">
                        Estos valores no son solo aspiraciones; son promesas sagradas que hacemos 
                        a cada estudiante, educador y comunidad que confía en nosotros.
                    </p>
                    
                    <div class="promesas-grid">
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3>Promesa de Equidad</h3>
                            <p>Nunca dejaremos que la situación económica sea una barrera para la educación de calidad.</p>
                        </div>
                        
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3>Promesa de Innovación</h3>
                            <p>Siempre estaremos a la vanguardia, creando el futuro de la educación hoy.</p>
                        </div>
                        
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3>Promesa de Integridad</h3>
                            <p>Cada decisión será tomada con honestidad, transparencia y el mejor interés de nuestros estudiantes.</p>
                        </div>
                        
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Promesa de Colaboración</h3>
                            <p>Construiremos puentes, no muros, uniendo a personas de todo el mundo por la educación.</p>
                        </div>
                        
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h3>Promesa de Sostenibilidad</h3>
                            <p>Cada acción considerará su impacto en las generaciones futuras y el planeta.</p>
                        </div>
                        
                        <div class="promesa-item">
                            <div class="promesa-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h3>Promesa de Excelencia</h3>
                            <p>Nunca nos conformaremos con "suficientemente bueno" cuando se trata del futuro de nuestros estudiantes.</p>
                        </div>
                    </div>
                </div>
                
                <div class="compromiso-visual">
                    <div class="valores-pledge">
                        <div class="pledge-seal">
                            <i class="fas fa-certificate"></i>
                            <span>Compromiso EDUSOFT</span>
                        </div>
                        <div class="pledge-text">
                            <h3>"Compromiso de Valores"</h3>
                            <p>
                                Nosotros, el equipo de EDUSOFT, nos comprometemos solemnemente a vivir 
                                estos valores cada día, en cada decisión, y en cada interacción. 
                                Este no es solo nuestro trabajo; es nuestra misión de vida.
                            </p>
                            <div class="pledge-signature">
                                <div class="signature-line"></div>
                                <span>Equipo Fundador EDUSOFT</span>
                                <span class="signature-date">2024</span>
                            </div>
                        </div>
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
                    <h4>Nuestros Valores</h4>
                    <ul>
                        <li><a href="#">Equidad e Inclusión</a></li>
                        <li><a href="#">Innovación y Excelencia</a></li>
                        <li><a href="#">Integridad y Transparencia</a></li>
                        <li><a href="#">Colaboración y Comunidad</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Valores en Acción</h4>
                    <ul>
                        <li><a href="#">Historias de Impacto</a></li>
                        <li><a href="#">Reportes de Transparencia</a></li>
                        <li><a href="#">Código de Ética</a></li>
                        <li><a href="#">Compromiso Social</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Únete</h4>
                    <ul>
                        <li><a href="#">Vivir Nuestros Valores</a></li>
                        <li><a href="#">Programa de Voluntarios</a></li>
                        <li><a href="#">Red de Mentores</a></li>
                        <li><a href="#">Alianzas Estratégicas</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 EDUSOFT - Valores que transforman vidas, educación que cambia el mundo. Desarrollado por estudiantes de Bachillerato Técnico.</p>
        </div>
    </footer>

    <script src="valores.js"></script>
</body>
</html>
