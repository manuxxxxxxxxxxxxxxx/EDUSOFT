<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas - EDUSOFT</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="politica.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="../index.php" class="brand-link">
                    <img src="/img/EDUSOFT2.png" alt="EDUSOFT Logo" class="brand-logo">
                </a>
            </div>
            
            <div class="nav-links" id="nav-links">
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
                        <a href="/nosotros/nosotros.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Nosotros</span>
                        </a>
                    </li>
                    

                    <li class="nav-item">
                        <a href="" class="nav-link active">
                            <i class="fas fa-shield-alt"></i>
                            <span>Políticas</span>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="/contactanos/contactanos.php" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Contacto</span>
                        </a>
                    </li>



                </ul>
                
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
            </div>
            
            <button class="nav-toggle" id="nav-toggle">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="policy-hero">
        <div class="hero-background">
            <div class="floating-icons">
                <i class="fas fa-shield-alt"></i>
                <i class="fas fa-lock"></i>
                <i class="fas fa-balance-scale"></i>
                <i class="fas fa-handshake"></i>
                <i class="fas fa-eye"></i>
                <i class="fas fa-certificate"></i>
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-shield-check"></i>
                <span>Transparencia Total</span>
            </div>
            <h1 class="hero-title">
                Nuestras <span class="gradient-text">Políticas</span>
            </h1>
            <p class="hero-subtitle">
                Comprometidos con la transparencia, la ética y la protección de nuestra comunidad educativa
            </p>
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number" data-target="100">0</div>
                    <div class="stat-label">% Transparencia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-target="15">0</div>
                    <div class="stat-label">Políticas Activas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-target="24">0</div>
                    <div class="stat-label">Horas Soporte</div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- POLICY NAVIGATION -->
    <section class="policy-nav">
        <div class="container">
            <div class="nav-grid">
                <a href="#privacidad" class="nav-card" data-policy="privacidad">
                    <div class="card-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Privacidad</h3>
                    <p>Protección de datos personales</p>
                </a>
                <a href="#terminos" class="nav-card" data-policy="terminos">
                    <div class="card-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Términos de Uso</h3>
                    <p>Condiciones de servicio</p>
                </a>
                <a href="#cookies" class="nav-card" data-policy="cookies">
                    <div class="card-icon">
                        <i class="fas fa-cookie-bite"></i>
                    </div>
                    <h3>Cookies</h3>
                    <p>Gestión de cookies</p>
                </a>
                <a href="#academica" class="nav-card" data-policy="academica">
                    <div class="card-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Integridad Académica</h3>
                    <p>Código de honor estudiantil</p>
                </a>
                <a href="#seguridad" class="nav-card" data-policy="seguridad">
                    <div class="card-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Seguridad</h3>
                    <p>Protección de la plataforma</p>
                </a>
                <a href="#accesibilidad" class="nav-card" data-policy="accesibilidad">
                    <div class="card-icon">
                        <i class="fas fa-universal-access"></i>
                    </div>
                    <h3>Accesibilidad</h3>
                    <p>Inclusión digital</p>
                </a>
            </div>
        </div>
    </section>

    <!-- PRIVACY POLICY -->
    <section id="privacidad" class="policy-section">
        <div class="container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2>Política de Privacidad</h2>
                <p>Tu privacidad es nuestra prioridad. Conoce cómo protegemos tus datos.</p>
            </div>
            
            <div class="policy-content">
                <div class="content-grid">
                    <div class="content-main">
                        <div class="policy-card">
                            <h3><i class="fas fa-info-circle"></i> Información que Recopilamos</h3>
                            <ul>
                                <li><strong>Datos de Registro:</strong> Nombre, email, institución educativa</li>
                                <li><strong>Datos de Uso:</strong> Progreso académico, tiempo de estudio, preferencias</li>
                                <li><strong>Datos Técnicos:</strong> IP, navegador, dispositivo (anonimizados)</li>
                                <li><strong>Comunicaciones:</strong> Mensajes de soporte, feedback, evaluaciones</li>
                            </ul>
                        </div>

                        <div class="policy-card">
                            <h3><i class="fas fa-cogs"></i> Cómo Usamos tu Información</h3>
                            <div class="usage-grid">
                                <div class="usage-item">
                                    <i class="fas fa-chart-line"></i>
                                    <h4>Personalización</h4>
                                    <p>Adaptar contenido educativo a tu nivel y preferencias</p>
                                </div>
                                <div class="usage-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <h4>Seguridad</h4>
                                    <p>Proteger tu cuenta y prevenir uso no autorizado</p>
                                </div>
                                <div class="usage-item">
                                    <i class="fas fa-envelope"></i>
                                    <h4>Comunicación</h4>
                                    <p>Enviarte actualizaciones importantes y soporte</p>
                                </div>
                                <div class="usage-item">
                                    <i class="fas fa-analytics"></i>
                                    <h4>Mejora</h4>
                                    <p>Analizar uso para mejorar nuestros servicios</p>
                                </div>
                            </div>
                        </div>

                        <div class="policy-card">
                            <h3><i class="fas fa-user-cog"></i> Tus Derechos</h3>
                            <div class="rights-list">
                                <div class="right-item">
                                    <i class="fas fa-eye"></i>
                                    <div>
                                        <h4>Acceso</h4>
                                        <p>Ver todos los datos que tenemos sobre ti</p>
                                    </div>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-edit"></i>
                                    <div>
                                        <h4>Rectificación</h4>
                                        <p>Corregir información incorrecta o incompleta</p>
                                    </div>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-trash"></i>
                                    <div>
                                        <h4>Eliminación</h4>
                                        <p>Solicitar la eliminación de tus datos</p>
                                    </div>
                                </div>
                                <div class="right-item">
                                    <i class="fas fa-download"></i>
                                    <div>
                                        <h4>Portabilidad</h4>
                                        <p>Exportar tus datos en formato legible</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-sidebar">
                        <div class="sidebar-card">
                            <h4><i class="fas fa-clock"></i> Última Actualización</h4>
                            <p>15 de Enero, 2024</p>
                        </div>
                        <div class="sidebar-card">
                            <h4><i class="fas fa-envelope"></i> Contacto DPO</h4>
                            <p>privacy@edusoft.com</p>
                            <p>+1 (555) 123-4567</p>
                        </div>
                        <div class="sidebar-card">
                            <h4><i class="fas fa-certificate"></i> Certificaciones</h4>
                            <div class="cert-badges">
                                <span class="cert-badge">GDPR</span>
                                <span class="cert-badge">COPPA</span>
                                <span class="cert-badge">FERPA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMS OF SERVICE -->
    <section id="terminos" class="policy-section alt-bg">
        <div class="container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <h2>Términos de Uso</h2>
                <p>Las reglas que rigen el uso de nuestra plataforma educativa.</p>
            </div>

            <div class="terms-timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Registro y Cuenta</h3>
                        <p>Al crear una cuenta, confirmas que tienes al menos 13 años y proporcionas información veraz. Eres responsable de mantener la seguridad de tu cuenta.</p>
                        <ul>
                            <li>Una cuenta por persona</li>
                            <li>Información veraz y actualizada</li>
                            <li>Contraseña segura y confidencial</li>
                            <li>Notificar uso no autorizado</li>
                        </ul>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Uso Educativo</h3>
                        <p>Nuestra plataforma está diseñada exclusivamente para fines educativos. El contenido debe usarse de manera responsable y ética.</p>
                        <div class="usage-examples">
                            <div class="example-card allowed">
                                <i class="fas fa-check"></i>
                                <h4>Permitido</h4>
                                <ul>
                                    <li>Estudiar y aprender</li>
                                    <li>Compartir conocimiento</li>
                                    <li>Colaborar en proyectos</li>
                                    <li>Crear contenido educativo</li>
                                </ul>
                            </div>
                            <div class="example-card prohibited">
                                <i class="fas fa-times"></i>
                                <h4>Prohibido</h4>
                                <ul>
                                    <li>Uso comercial sin autorización</li>
                                    <li>Compartir credenciales</li>
                                    <li>Contenido inapropiado</li>
                                    <li>Violación de derechos de autor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Derechos y Responsabilidades</h3>
                        <p>Tanto EDUSOFT como los usuarios tienen derechos y responsabilidades específicas para mantener un ambiente educativo positivo.</p>
                        <div class="rights-grid">
                            <div class="rights-column">
                                <h4><i class="fas fa-building"></i> EDUSOFT se compromete a:</h4>
                                <ul>
                                    <li>Proporcionar servicio confiable 99.9% uptime</li>
                                    <li>Proteger la privacidad de los usuarios</li>
                                    <li>Mantener contenido educativo actualizado</li>
                                    <li>Ofrecer soporte técnico 24/7</li>
                                    <li>Respetar los derechos de propiedad intelectual</li>
                                </ul>
                            </div>
                            <div class="rights-column">
                                <h4><i class="fas fa-users"></i> Los usuarios deben:</h4>
                                <ul>
                                    <li>Usar la plataforma de manera responsable</li>
                                    <li>Respetar a otros miembros de la comunidad</li>
                                    <li>No compartir contenido inapropiado</li>
                                    <li>Reportar problemas o violaciones</li>
                                    <li>Cumplir con las leyes locales aplicables</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACADEMIC INTEGRITY -->
    <section id="academica" class="policy-section">
        <div class="container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>Política de Integridad Académica</h2>
                <p>Promovemos la honestidad académica y el aprendizaje auténtico.</p>
            </div>

            <div class="integrity-content">
                <div class="hackathon-showcase">
                    <div class="showcase-images">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/hackaton-y9fZMmkxFxiEopCTSRqpY5vE4lGtgM.avif" alt="Hackathon colaborativo" class="showcase-img">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/hackaton-9S03BhoXuXBLUeFtmqA2nOdRq3zo15.avif" alt="Estudiantes programando" class="showcase-img">
                    </div>
                    <div class="showcase-content">
                        <h3><i class="fas fa-trophy"></i> Hackathons y Competencias</h3>
                        <p>Nuestros eventos fomentan la colaboración ética y la innovación responsable. Cada hackathon es una oportunidad para demostrar integridad académica en acción.</p>
                        <div class="hackathon-stats">
                            <div class="stat">
                                <span class="number" data-target="50">0</span>
                                <span class="label">Hackathons Anuales</span>
                            </div>
                            <div class="stat">
                                <span class="number" data-target="5000">0</span>
                                <span class="label">Participantes</span>
                            </div>
                            <div class="stat">
                                <span class="number" data-target="100">0</span>
                                <span class="label">% Fair Play</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="integrity-principles">
                    <h3>Principios Fundamentales</h3>
                    <div class="principles-grid">
                        <div class="principle-card">
                            <div class="principle-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h4>Honestidad</h4>
                            <p>Presentar trabajo original y citar fuentes apropiadamente. No plagiar ni copiar contenido sin atribución.</p>
                        </div>
                        <div class="principle-card">
                            <div class="principle-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>Colaboración Ética</h4>
                            <p>Trabajar en equipo de manera justa, respetando las contribuciones de todos los miembros.</p>
                        </div>
                        <div class="principle-card">
                            <div class="principle-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4>Transparencia</h4>
                            <p>Ser claro sobre métodos, fuentes y procesos utilizados en proyectos y evaluaciones.</p>
                        </div>
                        <div class="principle-card">
                            <div class="principle-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>Responsabilidad</h4>
                            <p>Asumir la responsabilidad de las propias acciones y reportar violaciones observadas.</p>
                        </div>
                    </div>
                </div>

                <div class="violation-consequences">
                    <h3><i class="fas fa-exclamation-triangle"></i> Consecuencias de Violaciones</h3>
                    <div class="consequences-timeline">
                        <div class="consequence-level level-1">
                            <div class="level-indicator">1</div>
                            <div class="level-content">
                                <h4>Primera Violación</h4>
                                <p>Advertencia formal y sesión educativa sobre integridad académica</p>
                            </div>
                        </div>
                        <div class="consequence-level level-2">
                            <div class="level-indicator">2</div>
                            <div class="level-content">
                                <h4>Segunda Violación</h4>
                                <p>Suspensión temporal de 30 días y plan de mejora personalizado</p>
                            </div>
                        </div>
                        <div class="consequence-level level-3">
                            <div class="level-indicator">3</div>
                            <div class="level-content">
                                <h4>Violación Grave</h4>
                                <p>Suspensión permanente y revisión del caso por comité académico</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECURITY POLICY -->
    <section id="seguridad" class="policy-section alt-bg">
        <div class="container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h2>Política de Seguridad</h2>
                <p>Protegemos tu información con los más altos estándares de seguridad.</p>
            </div>

            <div class="security-dashboard">
                <div class="security-metrics">
                    <div class="metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div class="metric-value">256-bit</div>
                        <div class="metric-label">Encriptación SSL</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="metric-value">99.9%</div>
                        <div class="metric-label">Uptime Garantizado</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-value">24/7</div>
                        <div class="metric-label">Monitoreo</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-backup"></i>
                        </div>
                        <div class="metric-value">3x</div>
                        <div class="metric-label">Respaldo Diario</div>
                    </div>
                </div>

                <div class="security-measures">
                    <h3>Medidas de Protección</h3>
                    <div class="measures-grid">
                        <div class="measure-item">
                            <i class="fas fa-fingerprint"></i>
                            <h4>Autenticación Multifactor</h4>
                            <p>Verificación en dos pasos para mayor seguridad de cuentas</p>
                        </div>
                        <div class="measure-item">
                            <i class="fas fa-fire-extinguisher"></i>
                            <h4>Firewall Avanzado</h4>
                            <p>Protección contra ataques DDoS y accesos no autorizados</p>
                        </div>
                        <div class="measure-item">
                            <i class="fas fa-eye-slash"></i>
                            <h4>Anonimización</h4>
                            <p>Datos sensibles anonimizados para análisis y mejoras</p>
                        </div>
                        <div class="measure-item">
                            <i class="fas fa-history"></i>
                            <h4>Auditoría Continua</h4>
                            <p>Registro y monitoreo de todas las actividades del sistema</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACCESSIBILITY POLICY -->
    <section id="accesibilidad" class="policy-section">
        <div class="container">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-universal-access"></i>
                </div>
                <h2>Política de Accesibilidad</h2>
                <p>Educación inclusiva para todos, sin barreras ni limitaciones.</p>
            </div>

            <div class="accessibility-content">
                <div class="wcag-compliance">
                    <h3><i class="fas fa-certificate"></i> Cumplimiento WCAG 2.1 AA</h3>
                    <div class="compliance-grid">
                        <div class="compliance-item">
                            <div class="compliance-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4>Perceptible</h4>
                            <ul>
                                <li>Texto alternativo para imágenes</li>
                                <li>Subtítulos para videos</li>
                                <li>Contraste de color adecuado</li>
                                <li>Texto redimensionable hasta 200%</li>
                            </ul>
                        </div>
                        <div class="compliance-item">
                            <div class="compliance-icon">
                                <i class="fas fa-hand-pointer"></i>
                            </div>
                            <h4>Operable</h4>
                            <ul>
                                <li>Navegación por teclado completa</li>
                                <li>Sin contenido que cause convulsiones</li>
                                <li>Tiempo suficiente para leer</li>
                                <li>Ayuda para navegación</li>
                            </ul>
                        </div>
                        <div class="compliance-item">
                            <div class="compliance-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            <h4>Comprensible</h4>
                            <ul>
                                <li>Texto claro y simple</li>
                                <li>Funcionalidad predecible</li>
                                <li>Ayuda para evitar errores</li>
                                <li>Etiquetas e instrucciones claras</li>
                            </ul>
                        </div>
                        <div class="compliance-item">
                            <div class="compliance-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h4>Robusto</h4>
                            <ul>
                                <li>Compatible con tecnologías asistivas</li>
                                <li>Código HTML válido</li>
                                <li>Funciona en múltiples navegadores</li>
                                <li>Adaptable a nuevas tecnologías</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="assistive-technologies">
                    <h3>Tecnologías Asistivas Soportadas</h3>
                    <div class="tech-grid">
                        <div class="tech-item">
                            <i class="fas fa-volume-up"></i>
                            <h4>Lectores de Pantalla</h4>
                            <p>JAWS, NVDA, VoiceOver, TalkBack</p>
                        </div>
                        <div class="tech-item">
                            <i class="fas fa-keyboard"></i>
                            <h4>Navegación por Teclado</h4>
                            <p>Acceso completo sin mouse</p>
                        </div>
                        <div class="tech-item">
                            <i class="fas fa-microphone"></i>
                            <h4>Reconocimiento de Voz</h4>
                            <p>Dragon NaturallySpeaking, Voice Control</p>
                        </div>
                        <div class="tech-item">
                            <i class="fas fa-search-plus"></i>
                            <h4>Magnificadores</h4>
                            <p>ZoomText, MAGic, zoom del navegador</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
   

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="/img/ELEFANTE.png" alt="EDUSOFT">
                <h3>EDUSOFT</h3>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Plataforma</h4>
                    <ul>
                        <li><a href="#">Cursos</a></li>
                        <li><a href="#">Certificaciones</a></li>
                        <li><a href="#">Recursos</a></li>
                        <li><a href="#">Comunidad</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Empresa</h4>
                    <ul>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Carreras</a></li>
                        <li><a href="#">Prensa</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Soporte</h4>
                    <ul>
                        <li><a href="#">Centro de Ayuda</a></li>
                        <li><a href="#">Documentación</a></li>
                        <li><a href="#">API</a></li>
                        <li><a href="#">Estado del Sistema</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#privacidad">Privacidad</a></li>
                        <li><a href="#terminos">Términos</a></li>
                        <li><a href="#cookies">Cookies</a></li>
                        <li><a href="#accesibilidad">Accesibilidad</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 EDUSOFT. Todos los derechos reservados. Transformando la educación global.</p>
        </div>
    </footer>

    <script src="main.js"></script>
    <script src="politica.js"></script>
</body>
</html>
