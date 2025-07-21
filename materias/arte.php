<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Arte</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleArte.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-palette" style="color: #ffa726;"></i> <span>EduSoft</span>
        </div>
        <nav>
            <button id="tablon-btn" class="active"><i class="fas fa-th-large"></i>Tablón</button>
            <button id="tareas-btn"><i class="fas fa-tasks"></i>Tareas</button>
            <button id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
            <button id="avisos-btn"><i class="fas fa-bell"></i>Avisos</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span class="header-title">Segundo año B <span class="header-materia">Arte</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-arte" id="banner-arte"> 
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1>ARTE</h1> 
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern" style="background-image: url('https://ui-avatars.com/api/?name=Sofia+Reyes&background=ffcc80&color=e65100');"></div>
                        <p>Profesor<br><strong>Sofía Reyes</strong></p>
                    </div>
                    <div class="tareas-container">
                        <div class="tarea" data-titulo="Proyecto de Dibujo" data-descripcion="Crear un bodegón utilizando técnicas de sombreado. Entregar boceto la próxima clase.">
                            <h4>Proyecto de Dibujo</h4>
                            <p>Crear un bodegón utilizando técnicas de sombreado. Entregar boceto la próxima clase.</p>
                        </div>
                        <div class="tarea" data-titulo="Historia del Arte: Renacimiento" data-descripcion="Investigar sobre un artista del Renacimiento y presentar un resumen.">
                            <h4>Historia del Arte: Renacimiento</h4>
                            <p>Investigar sobre un artista del Renacimiento y presentar un resumen.</p>
                        </div>
                        <div class="tarea" data-titulo="Técnicas de Acuarela" data-descripcion="Practicar las técnicas básicas de acuarela siguiendo el tutorial adjunto.">
                            <h4>Técnicas de Acuarela</h4>
                            <p>Practicar las técnicas básicas de acuarela siguiendo el tutorial adjunto.</p>
                        </div>
                        <div class="tarea" data-titulo="Visita Virtual a Museo" data-descripcion="Realizar una visita virtual al Museo del Prado y elegir tu obra favorita para comentar.">
                            <h4>Visita Virtual a Museo</h4>
                            <p>Realizar una visita virtual al Museo del Prado y elegir tu obra favorita para comentar.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-pencil-alt"></i>
                        <span>Proyecto de Dibujo</span>
                        <p>Crear un bodegón utilizando técnicas de sombreado.</p>
                        <small>Fecha límite: 29 de julio</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-book-open"></i>
                        <span>Historia del Arte: Renacimiento</span>
                        <p>Investigar sobre un artista del Renacimiento.</p>
                        <small>Fecha límite: 1 de agosto</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Andrea Fuentes</span>
                        <p>Número de estudiante: 011</p>
                        <small>Correo electrónico: andrea.fuentes@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Ricardo Luna</span>
                        <p>Número de estudiante: 012</p>
                        <small>Correo electrónico: ricardo.luna@gmail.com</small>
                    </li>
                </ul>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Exposición de Arte Escolar</span>
                        <p>La exposición de arte anual será el 15 de agosto. ¡Preparen sus mejores obras!</p>
                        <small>Fecha: 26 de julio</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Taller de Cerámica</span>
                        <p>Se abrirá un taller de cerámica los sábados. Interesados inscribirse con la profesora.</p>
                        <small>Fecha: 22 de julio</small>
                    </li>
                </ul>
            </section>
        </main>
    </div>
    
    <div id="modalTarea" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitulo">Título de la tarea</h2>
            <p id="modalDescripcion">Descripción de la tarea</p>
            <div class="modal-section">
                <label for="archivoSubir">Subir archivos:</label>
                <input type="file" id="archivoSubir" multiple>
                <ul id="listaArchivos"></ul>
            </div>
            <div class="modal-section">
                <label for="enlaceInput">Añadir enlace:</label>
                <input type="url" id="enlaceInput" placeholder="https://">
                <button id="agregarEnlace">Agregar enlace</button>
                <ul id="listaEnlaces"></ul>
            </div>
        </div>
    </div>
    
    <script src="../materias/js/scriptArte.js"></script>
</body>
</html>