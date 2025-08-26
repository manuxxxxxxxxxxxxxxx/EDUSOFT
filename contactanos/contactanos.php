<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page | Living Code</title>
    <link rel="stylesheet" href="../contactanos/contactanos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Si tu .container tiene position: relative puedes quitar position: absolute de .back-arrow */
    </style>
</head>
<body>
    <!-- Flecha para volver atrás -->
    <a href="javascript:history.back()" class="back-arrow" title="Volver atrás">
    <i class="fa-solid fa-arrow-left"></i>
</a>

    <div class="container">
        <div class="box-info">
            <h1 data-i18n="contacto">CONTÁCTATE CON NOSOTROS</h1>
            <div class="data">
                <p><i class="fa-solid fa-phone"></i> +503 7800 2012</p>
                <p><i class="fa-solid fa-envelope"></i> Edusoft@gmail.com</p>
                <p><i class="fa-solid fa-location-dot"></i> Soyapango San Salvador El Salvador</p>
            </div>
            <div class="links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
        <form action="ContacDB.php" method="post">
            <div class="input-box">
                <input data-i18n="nombreCo" type="text"  name="Nombre" placeholder="Nombre y apellido" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input  data-i18n="correoCo" type="email" name="Email" required placeholder="Correo electrónico">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input data-i18n="asuntoCo" type="text"  name="Asunto" placeholder="Asunto">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="input-box">
                <textarea data-i18n="escribe"  name="Msj" placeholder="Escribe tu mensaje..."></textarea>
            </div>
            <button type="submit" data-i18n="enviarCo">Enviar mensaje</button>
        </form>
    </div>

    <script src="../principal/lang.js"></script>
    <script src="../principal/idioma.js"></script>
</body>
</html>