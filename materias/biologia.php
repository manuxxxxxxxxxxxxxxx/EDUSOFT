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

    $profesor_id = $_SESSION['id'];
    
    $nombre = $_SESSION['nombre'];

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
    <title>EduSoft - Biología</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../materias/css/styleBiologia.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../js/subir_tarea.js"></script>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-dna"></i>
            <span>EduSoft</span>
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
        <span class="header-title">Segundo año B <span class="header-materia">Biología</span></span>
    </a>
    <div class="icons">
        <span class="settings"><i class="fas fa-cog"></i></span>
        <span class="profile"><i class="fas fa-user-circle"></i></span>
    </div>
        </header>
        <main>
            <section id="tablon" class="seccion">
                <div class="banner" id="banner6">
                    <canvas id="particles-bg"></canvas>
                    <div class="abstract-shape"></div>
                        <h1>BIOLOGÍA</h1>
                </div>
                <div class="content">
                    <div class="profesor">
                        <div class="avatar-modern"></div>
                        <p>Profesor<br><strong> <?php echo htmlspecialchars($nombre); ?></strong></p>
                    </div>
                    <div class="tareas-container">
                        <?php if (isset($resultado_tareas_profesor) && $resultado_tareas_profesor->num_rows > 0): ?>
                        <?php while ($tarea = $resultado_tareas_profesor->fetch_assoc()): ?>
                        <div class="tarea">
                            <h4><?php echo htmlspecialchars($tarea['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                            <small>Fecha límite: <?php echo $tarea['fecha_entrega']; ?> | Puntos: <?php echo $tarea['puntos']; ?></small>
                
                            <?php if (!empty($tarea['ruta_archivo'])): ?>
                            <br><a href="<?php echo htmlspecialchars($tarea['ruta_archivo']); ?>" target="_blank">📎 Ver archivo adjunto</a>
                            <?php endif; ?>
                        </div>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <p>No se han asignado tareas aún.</p>
                            <?php endif; ?>
                    </div>
            </section>
            <section id="tareas" class="seccion" style="display: none;">
                <h2>Tareas</h2>
                <ul class="lista-tareas">
                    <li>
                        <i class="fas fa-atom"></i>
                        <span>Tarea de Biología Celular</span>
                        <p>Resolver los problemas de biología celular del capítulo 3.</p>
                        <small>Fecha límite: 10 de abril</small>
                       
<h2>Sube tu tarea de Biología</h2>
<form id="formSubirTarea" action="subir_tarea_ajax.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="materia" value="biologia">
    <input type="hidden" name="id_estudiante" value="<?php echo $_SESSION['id_estudiante']; ?>">
    
    <label for="archivo">Archivo (PDF, DOCX, JPG...):</label>
    <input type="file" name="archivo" id="archivo" required><br><br>

    <button type="submit">Subir tarea</button>
</form>

<div id="mensajeSubida"></div>

<!-- ✅ Lista de tareas subidas -->
<h3>Tareas subidas</h3>
<<ul id="listaTareas" style="list-style-type: none; padding-left: 0;">
<?php if (isset($resultado_tareas)) {
    while ($fila = $resultado_tareas->fetch_assoc()) {
        $id = $fila['id'] ?? null;
        $nombre = htmlspecialchars($fila['nombre_archivo']);
        $ruta = htmlspecialchars($fila['ruta_archivo']);
        $fecha = htmlspecialchars($fila['fecha_subida']);

        echo "<li id='tarea_$id'>
                <a href='$ruta' target='_blank'>$nombre</a> <small>($fecha)</small>
                <button onclick='eliminarTarea($id)'>❌ Eliminar</button>
              </li>";
    }
} ?>
</ul>


                    
                    <li>
                        <i class="fas fa-dna"></i>
                        <span>Proyecto de Biología Molecular</span>
                        <p>Crear un proyecto sobre la biología molecular.</p>
                        <small>Fecha límite: 12 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-tree"></i>
                        <span>Examen de Biología Evolutiva</span>
                        <p>Estudiar para el examen de biología evolutiva que se realizará el próximo viernes.</p>
                        <small>Fecha límite: 15 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                    <li>
                        <i class="fas fa-pen"></i>
                        <span>Tarea de Biología Ambiental</span>
                        <p>Escribir un ensayo sobre la importancia de la biología ambiental en la conservación del medio ambiente.</p>
                        <small>Fecha límite: 17 de abril</small>
                        <button class="boton-estilo">Añadir tarea</button>
                    </li>
                </ul>
            </section>
            <section id="alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
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
                <h2>Avisos</h2>
                <ul class="lista-avisos">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Examen de Biología Celular</span>
                        <p>El próximo viernes se realizará el examen de biología celular. Asegúrate de estudiar y prepararte adecuadamente.</p>
                        <small>Fecha: 15 de abril</small>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Entrega de Tareas</span>
                        <p>Recuerda que la tarea de biología molecular debe ser entregada el próximo lunes. Asegúrate de tenerla lista y entregada a tiempo.</p>
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
        </main>
    </div>

    <!-- Modal de tareas -->
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

    <script src="../materias/js/scriptBiologia.js"></script>
</body>
</html>