<?php
session_start();
require_once "../conexiones/conexion.php";

// Valor por defecto para evitar error si no se define $nombre
$nombre = "Nombre no disponible";

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

    // Obtener nombre si está definido en sesión
    if (isset($_SESSION['nombre'])) {
        $nombre = $_SESSION['nombre'];
    }

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

// Obtener tareas subidas por el profesor para esta clase
$sql_tareas = "SELECT * FROM tareas_profesor WHERE id_clase = ? ORDER BY fecha_creacion DESC";
$stmt_tareas = $conn->prepare($sql_tareas);
$stmt_tareas->bind_param("i", $id_clase);
$stmt_tareas->execute();
$resultado_tareas_profesor = $stmt_tareas->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSoft - Ciencia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleCiencias.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-atom"></i>
            <span>EduSoft</span>
        </div>
        <nav>
            <button data-i18n="tablon" id="tablon-btn" class="active"><i class="fas fa-th-large"></i>Tablón</button>
            <button  data-i18n="tareas" id="tareas-btn"><i class="fas fa-tasks"></i>Tareas</button>
             <button id="material-btn"><i class="fas fa-folder-open"></i>Material</button> 
            <button  data-i18n="alumnos" id="alumnos-btn"><i class="fas fa-users"></i>Alumnos</button>
            <button   data-i18n="avisos" id="avisos-btn"><i class="fas fa-bell"></i>Avisos</button>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <a href="../cursos.php" class="logo modern-back">
                <span class="back-btn"><i class="fas fa-arrow-left"></i></span>
                <span data-i18n="segundo"class="header-title">Segundo año B <span class="header-materia" data-i18n="ciencia">Ciencia</span></span>
            </a>
            <div class="icons">
                <span class="settings"><i class="fas fa-cog"></i></span>
                <span class="profile"><i class="fas fa-user-circle"></i></span>
            </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner banner-ciencia" id="banner3">
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                    <h1 data-i18n="ciencia">CIENCIA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern"></div>
                        <p data-i18n="profesor">Profesor<br><strong><?php echo htmlspecialchars($nombre); ?></strong></p>
                    </div>
                    <div class="tareas-container">
                            <?php if (isset($resultado_tareas_profesor) && $resultado_tareas_profesor->num_rows > 0): ?>
                            <?php while ($tarea = $resultado_tareas_profesor->fetch_assoc()): ?>
                                  <div class="tarea">
    
              <h4 data-i18n="titulo"><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
             <p data-i18n="descripcion"><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
        
 
             <small>
              <span data-i18n="fechal">Fecha límite</span>: <?php echo $tarea['fecha_entrega']; ?>
           | 
            <span data-i18n="puntos">Puntos</span>: <?php echo $tarea['puntos']; ?>
           </small>

                 <?php if (!empty($tarea['ruta_archivo'])): ?>
                <br>
              <a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank" data-i18n="archivo">📎 Ver archivo adjunto</a>
             <?php endif; ?>
            </div>
             <?php endwhile; ?>
         <?php else: ?>
          <p data-i18n="notareas">No se han asignado tareas aún.</p>
        <?php endif; ?>
       </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-atom"></i>
                        <span data-i18n="tareaC">Tarea de Física</span>
                        <p data-i18n="cp1">Resolver los problemas de física del capítulo 3.</p>
                        <small data-i18n="fecha">Fecha límite: 10 de abril</small>
                        <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i>
                        <span data-i18n="astronomia">Proyecto de Astronomía</span>
                        <p data-i18n="cp2">Crear un proyecto sobre el sistema solar.</p>
                        <small data-i18n="fecha">Fecha límite: 12 de abril</small>
                        <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-mountain"></i>
                        <span data-i18n="geologia">Examen de Geología</span>
                        <p data-i18n="cp3">Estudiar para el examen de geología que se realizará el próximo viernes.</p>
                        <small data-i18n="fecha">Fecha límite: 15 de abril</small>
                        <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-recycle"></i>
                        <span data-i18n="ambiental">Tarea de Ciencia Ambiental</span>
                        <p data-i18n="cp4">Escribir un ensayo sobre la importancia de la conservación del medio ambiente.</p>
                        <small data-i18n="fecha">Fecha límite: 17 de abril</small>
                        <button data-i18n="añadir" class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2 data-i18n="lista">Lista de Alumnos</h2>
                <ul class="lista-alumnos">
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Juan Pérez</span>
                        <p>Número de estudiante: 001</p>
                        <small>Correo electrónico: juan.perez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>María López</span>
                        <p>Número de estudiante: 002</p>
                        <small>Correo electrónico: maria.lopez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Carlos Gómez</span>
                        <p>Número de estudiante: 003</p>
                        <small>Correo electrónico: carlos.gomez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Ana Ramírez</span>
                        <p>Número de estudiante: 004</p>
                        <small>Correo electrónico: ana.ramirez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Luis Hernández</span>
                        <p>Número de estudiante: 005</p>
                        <small>Correo electrónico: luis.hernandez@gmail.com</small>
                    </li>
                    <li>
                        <i class="fas fa-user"></i>
                        <span>Sofía García</span>
                        <p>Número de estudiante: 006</p>
                        <small>Correo electrónico: sofia.garcia@gmail.com</small>
                    </li>
                </ul>
            </section>
            <section id="avisos" class="seccion" style="display: none;">
                <h2 data-i18n="avisos">Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Examen de Física</span>
                        <p>El próximo viernes se realizará el examen de física. Asegúrate de estudiar y prepararte adecuadamente.</p>
                        <small>Fecha: 15 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Entrega de Tareas</span>
                        <p>Recuerda que la tarea de astronomía debe ser entregada el próximo lunes. Asegúrate de tenerla lista y entregada a tiempo.</p>
                        <small>Fecha: 12 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Feria de Ciencias</span>
                        <p>La feria de ciencias se realizará el próximo sábado. Asegúrate de asistir y participar en los eventos y actividades programadas.</p>
                        <small>Fecha: 17 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Información Importante</span>
                        <p>Recuerda que la escuela estará cerrada el próximo martes por motivo de una reunión de padres y maestros. Asegúrate de planificar tus actividades adecuadamente.</p>
                        <small>Fecha: 13 de abril</small>
                    </li>
                </ul>
            </section>
            
            
            
            <section id="material" class="seccion" style="display: none;">
                <h2><i class="fas fa-folder-open"></i> Material de la materia</h2>
                <ul class="lista-material">
                    <li>
                        <i class="fas fa-file-pdf"></i>
                        <span>Guía de ejercicios</span>
                        <a href="materiales/guia_ejercicios.pdf" target="_blank">Descargar PDF</a>
                        <small>Subido: 01 de agosto</small>
                    </li>
                    <li>
                        <i class="fas fa-link"></i>
                        <span>Video explicativo</span>
                        <a href="https://www.youtube.com/watch?v=xxxxxx" target="_blank">Ver video</a>
                        <small>Enlace externo</small>
                    </li>
                    <li>
                        <i class="fas fa-file-word"></i>
                        <span>Resumen teórico</span>
                        <a href="materiales/resumen.docx" target="_blank">Descargar Word</a>
                        <small>Subido: 28 de julio</small>
                    </li>
                </ul>
            </section>














        </main>
    </div>
    <!-- Modal HTML -->
    <div id="modalTarea" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitulo" data-i18n="titulo">Título de la tarea</h2>
            <p id="modalDescripcion" data-i18n="descripcion">Descripción de la tarea</p>
            <div class="modal-section">
                <label for="archivoSubir" data-i18n="archivos">Subir archivos:</label>
                <input type="file" id="archivoSubir" multiple>
                <ul id="listaArchivos"></ul>
            </div>
            <div class="modal-section">
                <label for="enlaceInput" data-i18n="enlace">Añadir enlace:</label>
                <input type="url" id="enlaceInput" placeholder="https://">
                <button id="agregarEnlace" data-i18n="agregarE">Agregar enlace</button>
                <ul id="listaEnlaces"></ul>
            </div>
        </div>
    </div>
    <script src="../materias/js/scriptCiencias.js"></script>
    <script src="../principal/lang.js"></script>
    <script src="../principal/idioma.js"></script>
</body>
</html>