<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EDUSOFT - Plataforma Educativa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenedor">
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
                            <a href="#inicio" class="nav-link active">
                                <i class="fas fa-home"></i>
                                <span data-i18n="inicioV">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../nosotros/nosotros.php" class="nav-link">
                                <i class="fas fa-users"></i>
                                <span data-i18n="nosotrosV">Nosotros</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../contactanos/contactanos.php" class="nav-link">
                                <i class="fas fa-envelope"></i>
                                <span data-i18n="contactoV">Contacto</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Botones de acción -->
                <div class="nav-actions">
                    <a data-i18n="iniciarS" href="../registrosCards/Inicio.php" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                    <a data-i18n="unete" href="../registrosCards/registro.php" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Únete
                    </a>
                </div>

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

        <!-- Contenido estático (títulos y botón) -->
        <div class="contenido-estatico">
            <h1 data-i18n="Welcome">EDUSOFT</h1>
            <h2 data-i18n="subtitle">Bienvenido a nuestra plataforma global de aprendizaje.
                Accede a material de estudio desde cualquier lugar y alcanza tus metas académicas.
                ¡Empieza hoy!</h2>
            <a href="../registrosCards/registro.php" data-i18n="join_now">Únete Ahora</a>
        </div>

        <!-- Contenedor del slider que contiene solo las imágenes de fondo -->
        <div class="slider-contenedor">
            <section class="contenido-slider">
                <div></div>
            </section>
            <section class="contenido-slider">
                <div></div>
            </section>
            <section class="contenido-slider">
                <div></div>
            </section>
            <section class="contenido-slider">
                <div></div>
            </section>
        </div>
    </div>

    <section class="contenedor-principal">
        <div class="fila">
            <div class="card grande">
                <img src="../img/imageen1.jpg" alt="Iniciativas">
                <div class="card-texto">
                    <h2 data-i18n="iniciativas">Iniciativas</h2>
                    <p data-i18n="parrafo_i">Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="../principal/iniciativas/iniciativa.php" data-i18n="leer_mas">Leer más</a>
                </div>
            </div>
            <div class="card chica">
                <img src="../img/imagen2.jpg" alt="Misión">
                <div class="card-texto">
                    <h2 data-i18n="mision">Misión</h2>
                    <p data-i18n="parrafo_m">Ayudar a todos los estudiantes que no cuentan con la tecnología ni servicios a integrarse
                        a una mejor Educación mucho más avanzada.</p>
                    <a href="../principal/mision/mision.php" data-i18n="leer_mas">Leer más</a>
                </div>
            </div>
        </div>
        <div class="fila fila-invertida">
            <div class="card chica">
                <img src="../img/imagen3.webp" alt="Noticias">
                <div class="card-texto">
                    <h2 data-i18n="noticias">politica</h2>
                    <p data-i18n="parrafo_n">Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="../principal/politica/politica.php" data-i18n="leer_mas">Leer más</a>
                </div>
            </div>
            <div class="card grande">
                <img src="../img/imagen4.jpg" alt="Participa">
                <div class="card-texto">
                    <h2 data-i18n="participa">Valores</h2>
                    <p data-i18n="parrafo_p">Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="../principal/valores/valores.php" data-i18n="leer_mas">Leer más</a>
                </div>
            </div>
        </div>
    </section>

    <div class="h1bajo">
        <h1 data-i18n="abajo">2025 en números</h1>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-number">
                <span class="big">4</span><span class="small" data-i18n="mil">mil</span>
            </div>
            <div class="line"></div>
            <div class="stat-text" data-i18n="dolares">
                Dólares recaudados
            </div>
        </div>
        <div class="stat">
            <div class="stat-number">
                <span class="big">8</span><span class="small" data-i18n="mil">mil</span>
            </div>
            <div class="line"></div>
            <div class="stat-text" data-i18n="alumnos">
                Alumnos graduados
            </div>
        </div>
        <div class="stat">
            <div class="stat-number">
                <span class="big">120</span>
            </div>
            <div class="line"></div>
            <div class="stat-text" data-i18n="centros">
                Centros tecnológicos
            </div>
        </div>
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
                    <h4 data-i18n="recursosP">Recursos</h4>
                    <ul>
                        <li><a href="#" data-i18n="biblioteca">Biblioteca Digital</a></li>
                        <li><a href="#" data-i18n="tutoriales">Tutoriales</a></li>
                        <li><a href="#" onclick="openModal('faqModal')" data-i18n="preguntas_frecuentes">Preguntas Frecuentes</a></li>
                        <li><a href="#" onclick="openModal('soporteModal')" data-i18n="soporte">Soporte Técnico</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 data-i18n="legal">Legal</h4>
                    <ul>
                        <li><a href=".././principal/politica/politica.php" data-i18n="terminos">Términos y Condiciones</a></li>
                        <li><a href=".././principal/politica/politica.php" data-i18n="politica">Política de Privacidad</a></li>
                        <li><a href=".././principal/politica/politica.php" data-i18n="cookies">Política de Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p data-i18n="copy">&copy; 2024 EDUSOFT - Plataforma Educativa. Desarrollado por estudiantes de Bachillerato Técnico.</p>
        </div>
    </footer>

    <!-- Modal FAQ -->
<!-- Modal FAQ - REEMPLAZA TODO TU MODAL ACTUAL -->
<div id="faqModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Preguntas Frecuentes</h2>
            <span class="close" onclick="closeModal('faqModal')">&times;</span>
        </div>
        <div class="modal-body">
            <div class="modal-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <p class="modal-description">Encuentra respuestas rápidas a las consultas más comunes de nuestros usuarios.</p>
            
            <div class="faq-container">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Cómo puedo registrarme en EduSoft?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Para registrarte en EduSoft, haz clic en el botón "Únete" en la parte superior de la página. Completa el formulario con tu nombre, correo electrónico, DUI y crea una contraseña segura. Recibirás un correo de confirmación para activar tu cuenta.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Qué funciones están disponibles para estudiantes?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Los estudiantes pueden acceder a sus horarios de clases, ver calificaciones, descargar material de estudio, participar en foros de discusión, entregar tareas y comunicarse con sus profesores a través de mensajería interna.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Cómo pueden los maestros gestionar sus clases?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Los maestros pueden crear y gestionar clases, subir material educativo, asignar tareas, calificar trabajos, tomar asistencia, generar reportes de progreso y comunicarse con estudiantes y padres de familia.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Es segura mi información personal?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Sí, EduSoft utiliza encriptación de datos y medidas de seguridad avanzadas para proteger tu información personal. Solo recopilamos los datos necesarios para el funcionamiento de la plataforma educativa.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Puedo acceder a EduSoft desde mi móvil?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Sí, EduSoft es completamente responsive y funciona perfectamente en dispositivos móviles, tablets y computadoras. Puedes acceder desde cualquier navegador web moderno.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Qué hago si olvido mi contraseña?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>En la página de inicio de sesión, haz clic en "¿Olvidaste tu contraseña?". Ingresa tu correo electrónico y recibirás instrucciones para restablecer tu contraseña de forma segura.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Soporte Técnico -->
<div id="soporteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Soporte Técnico</h2>
            <span class="close" data-modal="soporteModal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="support-container">
                <div class="support-intro">
                    <p>Nuestro equipo de soporte está aquí para ayudarte. Elige la opción que mejor se adapte a tu consulta:</p>
                </div>
                
                <div class="support-options">
                    <div class="support-option">
                        <div class="support-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Contacto por Email</h3>
                        <p>Para consultas generales y reportes de problemas, utiliza nuestro formulario de contacto.</p>
                        <button class="support-btn" onclick="window.location.href='../contactanos/contactanos.php'">
                            Ir a Contacto
                        </button>
                    </div>
                    
                    <div class="support-option">
                        <div class="support-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Preguntas Frecuentes</h3>
                        <p>Encuentra respuestas rápidas a las consultas más comunes de nuestros usuarios.</p>
                        <button class="support-btn" onclick="closeModal('soporteModal'); openModal('faqModal')">
                            Ver FAQ
                        </button>
                    </div>
                </div>
                
                <div class="support-hours">
                    <h3>Horarios de Atención</h3>
                    <p><strong>Lunes a Viernes:</strong> 8:00 AM - 6:00 PM</p>
                    <p><strong>Sábados:</strong> 9:00 AM - 2:00 PM</p>
                    <p><strong>Domingos:</strong> Cerrado</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Términos y Condiciones -->
<div id="terminosModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Términos y Condiciones</h2>
            <span class="close" data-modal="terminosModal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="legal-content">
                <div class="legal-section">
                    <h3>1. Aceptación de los Términos</h3>
                    <p>Al acceder y utilizar EduSoft, usted acepta estar sujeto a estos términos y condiciones de uso. Si no está de acuerdo con alguna parte de estos términos, no debe utilizar nuestro servicio.</p>
                </div>
                
                <div class="legal-section">
                    <h3>2. Descripción del Servicio</h3>
                    <p>EduSoft es una plataforma de gestión educativa desarrollada por estudiantes de bachillerato técnico en El Salvador. Proporciona herramientas para la gestión de clases, estudiantes, calificaciones y comunicación entre maestros y alumnos.</p>
                </div>
                
                <div class="legal-section">
                    <h3>3. Registro y Cuenta de Usuario</h3>
                    <p>Para utilizar ciertos servicios, debe registrarse y crear una cuenta. Usted es responsable de mantener la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta.</p>
                </div>
                
                <div class="legal-section">
                    <h3>4. Uso Aceptable</h3>
                    <p>Usted se compromete a utilizar EduSoft únicamente para fines educativos legítimos. Está prohibido:</p>
                    <ul>
                        <li>Usar la plataforma para actividades ilegales o no autorizadas</li>
                        <li>Interferir con el funcionamiento del servicio</li>
                        <li>Acceder a cuentas de otros usuarios sin autorización</li>
                        <li>Subir contenido ofensivo, difamatorio o inapropiado</li>
                    </ul>
                </div>
                
                <div class="legal-section">
                    <h3>5. Propiedad Intelectual</h3>
                    <p>Todo el contenido de EduSoft, incluyendo textos, gráficos, logos y software, está protegido por derechos de autor y otras leyes de propiedad intelectual.</p>
                </div>
                
                <div class="legal-section">
                    <h3>6. Limitación de Responsabilidad</h3>
                    <p>EduSoft se proporciona "tal como está" sin garantías de ningún tipo. No seremos responsables por daños directos, indirectos, incidentales o consecuentes.</p>
                </div>
                
                <div class="legal-section">
                    <h3>7. Modificaciones</h3>
                    <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en la plataforma.</p>
                </div>
                
                <div class="legal-footer">
                    <p><strong>Última actualización:</strong> Enero 2025</p>
                    <p><strong>EduSoft</strong> - Plataforma Educativa desarrollada en El Salvador</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Política de Privacidad -->
<div id="privacidadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Política de Privacidad</h2>
            <span class="close" data-modal="privacidadModal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="legal-content">
                <div class="legal-section">
                    <h3>1. Información que Recopilamos</h3>
                    <p>En EduSoft recopilamos la siguiente información personal:</p>
                    <ul>
                        <li><strong>Nombre completo:</strong> Para identificación y personalización del servicio</li>
                        <li><strong>Correo electrónico:</strong> Para comunicación y recuperación de cuenta</li>
                        <li><strong>DUI:</strong> Para verificación de identidad (solo en El Salvador)</li>
                        <li><strong>Contraseña:</strong> Almacenada de forma encriptada para seguridad de la cuenta</li>
                    </ul>
                </div>
                
                <div class="legal-section">
                    <h3>2. Cómo Utilizamos su Información</h3>
                    <p>Utilizamos su información personal para:</p>
                    <ul>
                        <li>Proporcionar y mantener nuestro servicio educativo</li>
                        <li>Gestionar su cuenta y perfil de usuario</li>
                        <li>Comunicarnos con usted sobre actualizaciones y servicios</li>
                        <li>Mejorar la funcionalidad de la plataforma</li>
                        <li>Cumplir con requisitos legales y educativos</li>
                    </ul>
                </div>
                
                <div class="legal-section">
                    <h3>3. Protección de Datos</h3>
                    <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su información:</p>
                    <ul>
                        <li>Encriptación de contraseñas y datos sensibles</li>
                        <li>Acceso restringido a información personal</li>
                        <li>Monitoreo regular de seguridad</li>
                        <li>Copias de seguridad regulares y seguras</li>
                    </ul>
                </div>
                
                <div class="legal-section">
                    <h3>4. Sus Derechos</h3>
                    <p>Usted tiene derecho a:</p>
                    <ul>
                        <li>Acceder a su información personal</li>
                        <li>Corregir datos inexactos</li>
                        <li>Solicitar la eliminación de su cuenta</li>
                        <li>Retirar su consentimiento en cualquier momento</li>
                    </ul>
                </div>
                
                <div class="legal-footer">
                    <p><strong>Última actualización:</strong> Enero 2025</p>
                    <p><strong>EduSoft</strong> - Comprometidos con la protección de su privacidad</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Política de Cookies -->
<div id="cookiesModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Política de Cookies</h2>
            <span class="close" data-modal="cookiesModal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="legal-content">
                <div class="legal-section">
                    <h3>¿Qué son las Cookies?</h3>
                    <p>Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita EduSoft. Nos ayudan a mejorar su experiencia y el funcionamiento de nuestra plataforma educativa.</p>
                </div>
                
                <div class="legal-section">
                    <h3>Tipos de Cookies que Utilizamos</h3>
                    
                    <div class="cookie-type">
                        <h4>Cookies Esenciales</h4>
                        <p>Necesarias para el funcionamiento básico de la plataforma:</p>
                        <ul>
                            <li>Mantener su sesión activa</li>
                            <li>Recordar sus preferencias de idioma</li>
                            <li>Garantizar la seguridad de su cuenta</li>
                        </ul>
                    </div>
                    
                    <div class="cookie-type">
                        <h4>Cookies de Funcionalidad</h4>
                        <p>Mejoran su experiencia de usuario:</p>
                        <ul>
                            <li>Recordar sus configuraciones personales</li>
                            <li>Mantener el estado de navegación</li>
                            <li>Personalizar la interfaz según sus preferencias</li>
                        </ul>
                    </div>
                </div>
                
                <div class="legal-section">
                    <h3>Gestión de Cookies</h3>
                    <p>Puede controlar y gestionar las cookies a través de la configuración de su navegador.</p>
                    <p><strong>Nota:</strong> Deshabilitar las cookies esenciales puede afectar el funcionamiento de EduSoft.</p>
                </div>
                
                <div class="legal-footer">
                    <p><strong>Última actualización:</strong> Enero 2025</p>
                    <p><strong>EduSoft</strong> - Uso responsable de cookies para mejorar su experiencia educativa</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="main.js"></script>
    <script src="lang.js"></script>
    <script src="idioma.js"></script>
</body>
</html>
