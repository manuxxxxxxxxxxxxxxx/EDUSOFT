<?php
session_start();
require_once "../conexiones/conexion.php";

// Verificar si el usuario está logueado como profesor o como estudiante
if (!isset($_SESSION['id']) && !isset($_SESSION['id_estudiante'])) {
    die("⚠️ Debes iniciar sesión como profesor o estudiante para acceder a esta materia.");
}

// Lógica para estudiantes
if (isset($_SESSION['id_estudiante'])) {
    $id_estudiante = $_SESSION['id_estudiante'];
    $materia = 'biologia'; // Puedes cambiar esto dinámicamente si lo deseas

    // Obtener tareas que subió este estudiante en esta materia
    $sql = "SELECT nombre_archivo, ruta_archivo, fecha_subida FROM tareas WHERE id_estudiante = ? AND materia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_estudiante, $materia);
    $stmt->execute();
    $resultado_tareas = $stmt->get_result();
}

// Lógica para profesores
if (isset($_SESSION['id']) && $_SESSION['rol'] === 'profesor') {
    $profesor_id = $_SESSION['id'];

    if (!isset($_GET['id_clase'])) {
        die("Clase no especificada.");
    }

    $id_clase = intval($_GET['id_clase']);

    // Verificar que la clase pertenezca al profesor
    $sql = "SELECT * FROM clases WHERE id = ? AND profesor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_clase, $profesor_id);
    $stmt->execute();
    $result_clase = $stmt->get_result();

    if ($result_clase->num_rows === 0) {
        die("No tienes acceso a esta clase.");
    }

    $clase = $result_clase->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Inglés</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleIngles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-language" style="color: #00bcd4;"></i> <span>EduSoft</span>
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
                <span class="header-title">Segundo año B <span class="header-materia">Inglés</span></span> 
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-ingles" id="banner-ingles"> 
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1>ENGLISH</h1> 
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern" style="background-image: url('https://ui-avatars.com/api/?name=Laura+Smith&background=80deea&color=006064');"></div>
                        <p>Profesor<br><strong>Laura Smith</strong></p>
                    </div>
                    <div class="tareas-container">
                        <div class="tarea" data-titulo="Reading Comprehension" data-descripcion="Read the article 'The Future of AI' and answer the comprehension questions. Due next Friday.">
                            <h4>Reading Comprehension</h4>
                            <p>Read the article 'The Future of AI' and answer the comprehension questions. Due next Friday.</p>
                        </div>
                        <div class="tarea" data-titulo="Grammar Practice" data-descripcion="Complete exercises on Present Perfect vs. Simple Past. Check your answers online.">
                            <h4>Grammar Practice</h4>
                            <p>Complete exercises on Present Perfect vs. Simple Past. Check your answers online.</p>
                        </div>
                        <div class="tarea" data-titulo="Vocabulary Quiz" data-descripcion="Prepare for a quiz on Unit 4 vocabulary next Tuesday.">
                            <h4>Vocabulary Quiz</h4>
                            <p>Prepare for a quiz on Unit 4 vocabulary next Tuesday.</p>
                        </div>
                        <div class="tarea" data-titulo="Speaking Assignment" data-descripcion="Record a 2-minute video introducing yourself and your hobbies. Upload to the platform.">
                            <h4>Speaking Assignment</h4>
                            <p>Record a 2-minute video introducing yourself and your hobbies. Upload to the platform.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-book-reader"></i>
                        <span>Reading Comprehension</span>
                        <p>Read 'The Future of AI' and answer questions.</p>
                        <small>Fecha límite: 25 de julio</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-spell-check"></i>
                        <span>Grammar Practice</span>
                        <p>Complete exercises on Present Perfect vs. Simple Past.</p>
                        <small>Fecha límite: 28 de julio</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Diego Torres</span>
                        <p>Número de estudiante: 009</p>
                        <small>Correo electrónico: diego.torres@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Valeria Castro</span>
                        <p>Número de estudiante: 010</p>
                        <small>Correo electrónico: valeria.castro@gmail.com</small>
                    </li>
                </ul>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>English Club Meeting</span>
                        <p>The English Club will meet this Wednesday at 3 PM in the library.</p>
                        <small>Fecha: 23 de julio</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Speaking Test Schedule</span>
                        <p>Individual speaking tests will be held on August 1st and 2nd. Check the detailed schedule.</p>
                        <small>Fecha: 20 de julio</small>
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
    
    <script src="../materias/js/scriptIngles.js"></script>
</body>
</html>