<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Deportes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleDeportes.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-running" style="color: #66bb6a;"></i> <span>EduSoft</span>
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
                <span class="header-title">Segundo año B <span class="header-materia">Deportes</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-deportes" id="banner-deportes"> 
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1>DEPORTES</h1> 
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern" style="background-image: url('https://ui-avatars.com/api/?name=Javier+Solis&background=a5d6a7&color=1b5e20');"></div>
                        <p>Profesor<br><strong>Javier Solís</strong></p>
                    </div>
                    <div class="tareas-container">
                        <div class="tarea" data-titulo="Rutina de Calentamiento" data-descripcion="Practicar la rutina de calentamiento antes de cada actividad física.">
                            <h4>Rutina de Calentamiento</h4>
                            <p>Practicar la rutina de calentamiento antes de cada actividad física.</p>
                        </div>
                        <div class="tarea" data-titulo="Reglas del Fútbol" data-descripcion="Estudiar las reglas básicas del fútbol para el próximo partido.">
                            <h4>Reglas del Fútbol</h4>
                            <p>Estudiar las reglas básicas del fútbol para el próximo partido.</p>
                        </div>
                        <div class="tarea" data-titulo="Nutrición Deportiva" data-descripcion="Investigar sobre la importancia de la hidratación en el deporte.">
                            <h4>Nutrición Deportiva</h4>
                            <p>Investigar sobre la importancia de la hidratación en el deporte.</p>
                        </div>
                        <div class="tarea" data-titulo="Entrenamiento de Resistencia" data-descripcion="Realizar 30 minutos de cardio 3 veces por semana. Registrar el progreso.">
                            <h4>Entrenamiento de Resistencia</h4>
                            <p>Realizar 30 minutos de cardio 3 veces por semana. Registrar el progreso.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-heartbeat"></i>
                        <span>Rutina de Calentamiento</span>
                        <p>Practicar la rutina de calentamiento.</p>
                        <small>Fecha límite: 27 de julio</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-futbol"></i>
                        <span>Reglas del Fútbol</span>
                        <p>Estudiar las reglas básicas del fútbol.</p>
                        <small>Fecha límite: 30 de julio</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Miguel Flores</span>
                        <p>Número de estudiante: 013</p>
                        <small>Correo electrónico: miguel.flores@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Camila Díaz</span>
                        <p>Número de estudiante: 014</p>
                        <small>Correo electrónico: camila.diaz@gmail.com</small>
                    </li>
                </ul>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Torneo Interclases de Baloncesto</span>
                        <p>Inscripciones abiertas para el torneo de baloncesto. Fecha límite: 5 de agosto.</p>
                        <small>Fecha: 24 de julio</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Clases de Yoga al Aire Libre</span>
                        <p>Clases de yoga gratuitas todos los jueves en el patio principal.</p>
                        <small>Fecha: 21 de julio</small>
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
    
    <script src="../materias/js/scriptDeportes.js"></script>
</body>
</html>