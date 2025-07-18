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
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#nosotros" class="nav-link">
                                <i class="fas fa-users"></i>
                                <span>Nosotros</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../contactanos/contactanos.php" class="nav-link">
                                <i class="fas fa-envelope"></i>
                                <span>Contacto</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Botones de acción -->
                <div class="nav-actions">
                    <a href="../registrosCards/Inicio.php" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                    <a href="../registrosCards/registro.php" class="btn-register">
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

        <!-- Contenido estático (títulos y botón) -->
        <div class="contenido-estatico">
            <h1>EDUSOFT</h1>
            <h2>Bienvenido a nuestra plataforma global de aprendizaje.
                Accede a material de estudio desde cualquier lugar y alcanza tus metas académicas.
                ¡Empieza hoy!</h2>
            <a href="../registrosCards/registro.php">Únete Ahora</a>
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

    <!-- Resto del contenido existente -->
    <section class="contenedor-principal">
        <div class="fila">
            <div class="card grande">
                <img src="../img/imageen1.jpg" alt="Iniciativas">
                <div class="card-texto">
                    <h2>Iniciativas</h2>
                    <p>Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="#">Leer más</a>
                </div>
            </div>
            <div class="card chica">
                <img src="../img/imagen2.jpg" alt="Misión">
                <div class="card-texto">
                    <h2>Misión</h2>
                    <p>Ayudar a todos los estudiantes que no cuentan con la tecnología ni servicios a integrarse
                        a una mejor Educación mucho más avanzada.</p>
                    <a href="#">Leer más</a>
                </div>
            </div>
        </div>
        <div class="fila fila-invertida">
            <div class="card chica">
                <img src="./img/imagen3.webp" alt="Noticias">
                <div class="card-texto">
                    <h2>Noticias</h2>
                    <p>Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="#">Leer más</a>
                </div>
            </div>
            <div class="card grande">
                <img src="../img/imagen4.jpg" alt="Participa">
                <div class="card-texto">
                    <h2>Participa</h2>
                    <p>Párrafo. Haz clic aquí para agregar tu propio texto y editar. Es fácil.</p>
                    <a href="#">Leer más</a>
                </div>
            </div>
        </div>
    </section>

    <div class="h1bajo">
        <h1>2025 en números</h1>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-number">
                <span class="big">4</span><span class="small">mil</span>
            </div>
            <div class="line"></div>
            <div class="stat-text">
                Dólares<br>recaudados
            </div>
        </div>
        <div class="stat">
            <div class="stat-number">
                <span class="big">8</span><span class="small">mil</span>
            </div>
            <div class="line"></div>
            <div class="stat-text">
                Alumnos<br>graduados
            </div>
        </div>
        <div class="stat">
            <div class="stat-number">
                <span class="big">120</span>
            </div>
            <div class="line"></div>
            <div class="stat-text">
                Centros<br>tecnológicos
            </div>
        </div>
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
                    <h4>Plataforma</h4>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Cursos</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Recursos</h4>
                    <ul>
                        <li><a href="#">Biblioteca Digital</a></li>
                        <li><a href="#">Tutoriales</a></li>
                        <li><a href="#">Preguntas Frecuentes</a></li>
                        <li><a href="#">Soporte Técnico</a></li>
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

    <script src="main.js"></script>
</body>
</html>
