<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slider</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="contenedor">

        <section class="header">
            <nav>
                <a href=""> <img src="../img/Real-Madrid-Logo-1.png" alt=""></a>
                <div class="links">
                    <ul>
                        <li><a href="../registrosCards/Inicio.php">Inicia sesion </a></li>
                        <li><a href="../contactanos/contactanos.php">Contactanos </a></li>
                        <li><a href="">Nosotros</a></li>
                    </ul>
                </div>
            </nav> 
    
        </section>
        <!-- Contenido estático (títulos y botón) -->
        <div class="contenido-estatico">
            <h1>EDUSOFT</h1>
            <h2>Bienvenido a nuestra plataforma global de aprendizaje.
                Accede a material de estudio desde cualquier lugar y alcanza tus metas académicas.
                ¡Empieza hoy!</h2>
            <a href="../registrosCards/registro.php">Unete</a>
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
    
        <!-- apartado que somos -->
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
          <p>Ayudar a todos los estudiantes que no cuentan con la tecnologia ni servicios a integrarse
            a una mejor Educación mucho mas avanzada..</p>
          <a href="#">Leer más</a>
        </div>
      </div>
    </div>

    <div class="fila fila-invertida">
      <div class="card chica">
        <img src="../img/imagen3.webp" alt="Noticias">
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
<!-- contactaos-->




     <!-- footer -->
     <footer>
        <div class="footerContainer">
            <div class="socialIcons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
                <a href=""><i class="fa-brands fa-google-plus"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="footerNav">
                <ul><li><a href="">Home</a></li>
                    <li><a href="">News</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="">our Team</a></li>
                </ul>
            </div>
            
        </div>
        <div class="footerBottom">
            <p>Copyright &copy;2023; Designed by <span class="designer">Noman</span></p>
        </div>
    </footer>
    <script src="main.js"></script>

</body>

</html>