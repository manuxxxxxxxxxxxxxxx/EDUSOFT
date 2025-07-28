<?php 
require_once "../conexiones/conexion.php"; 

    session_start();
        if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
              die("Acceso denegado. No eres profesor.");
        header("Location: ../loginProfes.php");
        exit;
        }
$profesor_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Maestro | Edusoft</title>
    <link rel="stylesheet" href="/frontend_maestros/stylemaestro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="/frontend_maestros/script.js"></script>
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar">
        <img id="profile-img" src="https://ui-avatars.com/api/?name=Maestro+Ejemplo" alt="Foto de perfil del Maestro Ejemplo">
        <h2 id="profile-name">Docente <?php echo htmlspecialchars($nombre); ?></h2>
        <nav>
            <a href="#" class="active"><i class="fas fa-home"></i>Inicio</a>
            <a href="#"><i class="fas fa-book"></i>Cursos <span class="badge">3</span></a>
            <a href="#"><i class="fas fa-users"></i>Alumnos</a>
            <a href="#"><i class="fas fa-tasks"></i>Tareas <span class="badge">3</span></a>
            <a href="#"><i class="fas fa-folder-open"></i>Materiales</a>
            <a href="#"><i class="fas fa-bullhorn"></i>Avisos</a>
            <a href="#"><i class="fas fa-envelope"></i>Mensajes <span class="badge">2</span></a>
            <a href="#"><i class="fas fa-user"></i>Perfil</a>
            <a href="#"><i class="fas fa-sign-out-alt"></i>Salir</a>
        </nav>
    </div>
    <div class="main-content">
        <!-- INICIO -->
        <div id="seccion-inicio" class="seccion-panel">
            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-book fa-2x icon-green"></i>
                    <h3>3</h3>
                    <p>Cursos asignados</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-cursos', 1)">Ver cursos</button>
                </div>
                <div class="card">
                    <i class="fas fa-users fa-2x icon-blue"></i>
                    <h3>9</h3>
                    <p>Alumnos</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-alumnos', 2)">Ver alumnos</button>
                </div>
                <div class="card">
                    <i class="fas fa-tasks fa-2x icon-orange"></i>
                    <h3>3</h3>
                    <p>Tareas pendientes</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-tareas', 3)">Ver tareas</button>
                </div>
            </div>
            <div class="section">
                <h2>Bienvenido, <span id="welcome-name">Docente  <?php echo htmlspecialchars($nombre); ?> </span></h2>
                <p>Desde este panel puedes gestionar tus cursos, tareas, materiales, avisos y comunicarte con tus alumnos.</p>
            </div>
            <div class="section">
                <h3>Notificaciones recientes</h3>
                <ul class="notificaciones">
                    <li><i class="fas fa-check-circle icon-green"></i> Juan Pérez entregó la tarea <b>"Ensayo de Historia"</b>.</li>
                    <li><i class="fas fa-envelope icon-blue"></i> Nuevo mensaje de <b>Ana López</b>.</li>
                    <li><i class="fas fa-bullhorn icon-orange"></i> Se publicó un aviso en el curso <b>"Matemáticas 2"</b>.</li>
                </ul>
            </div>
        </div>
        <!-- CURSOS -->
        <?php
        // Consulta para traer las clases de este profesor
        $sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $profesor_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $clases = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        ?>
        <div id="seccion-cursos" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Mis cursos</h3>
                <input type="button" value="Crear curso" class="quick-action" onclick="window.location.href='../frontend_maestros/crear_curso.php'">
                    <ul id="cursos-lista">
                                <?php if (count($clases) > 0): ?>
                                <?php foreach ($clases as $clase): ?>
                            <li>
                                <a href="../materias/<?php echo $clase['materia']; ?>.php?id_clase=<?php echo $clase['id']; ?>">
                                <?php echo htmlspecialchars($clase['nombre_clase']); ?> – <?php echo ucfirst($clase['materia']); ?>
                                </a>
                            </li>
                                <?php endforeach; ?>
                                <?php else: ?>
                            <li>No has creado ninguna clase aún.</li>
                                 <?php endif; ?>
                    </ul>
            </div>
        </div>
        <!-- ALUMNOS -->
        <div id="seccion-alumnos" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Alumnos</h3>
                <input type="text" id="search-student" placeholder="Buscar alumno..." style="width:90%;margin-top:10px;" oninput="searchStudent()">
                <ul id="student-list" style="text-align:left;margin-top:10px;max-height:180px;overflow:auto;">
                    <li>Juan Pérez</li>
                    <li>Ana López</li>
                    <li>Carlos Ruiz</li>
                    <li>María Torres</li>
                    <li>Lucía Díaz</li>
                    <li>Sofía Romero</li>
                    <li>Miguel Ángel</li>
                    <li>Luis Gómez</li>
                    <li>Pedro Sánchez</li>
                </ul>
            </div>
        </div>
        <!-- TAREAS -->
        <div id="seccion-tareas" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Tareas recientes</h3>
                <ul id="tareas-lista">
                    <li>
                        <b>Ensayo de Historia</b> - Entregas: 15/18 - <span style="color:green;">Pendiente de calificar</span>
                    </li>
                    <li>
                        <b>Problemas de Matemáticas</b> - Entregas: 20/23 - <span style="color:orange;">En revisión</span>
                    </li>
                    <li>
                        <b>Lectura de Lengua</b> - Entregas: 18/20 - <span style="color:blue;">Calificado</span>
                    </li>
                </ul>
                <button class="quick-action" onclick="window.location.href='subir_tarea.php'">Crear tarea</button>
            </div>
        </div>
        <!-- MATERIALES -->
        <div id="seccion-materiales" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Materiales</h3>
                <ul>
                    <li>Guía de Matemáticas.pdf</li>
                    <li>Presentación Historia.pptx</li>
                    <li>Lectura Lengua.docx</li>
                </ul>
                <button class="quick-action" disabled>Subir material</button>
            </div>
        </div>
        <!-- AVISOS -->
        <div id="seccion-avisos" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Avisos</h3>
                <div class="avisos-timeline">
                    <div class="aviso-card">
                        <i class="fas fa-bullhorn icon-orange"></i>
                        <span>Nuevo aviso en Matemáticas 2°A: "Examen el viernes".</span>
                    </div>
                    <div class="aviso-card">
                        <i class="fas fa-bullhorn icon-orange"></i>
                        <span>Reunión con padres el 25/06/2025.</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- MENSAJES -->
        <div id="seccion-mensajes" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Mensajes recientes</h3>
                <div class="avisos-timeline">
                    <div class="aviso-card">
                        <i class="fas fa-envelope icon-blue"></i>
                        <span>Mensaje de Ana López: "¿Cuándo es la entrega?"</span>
                    </div>
                    <div class="aviso-card">
                        <i class="fas fa-envelope icon-blue"></i>
                        <span>Mensaje de Juan Pérez: "No entiendo la tarea".</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- PERFIL -->
        <div id="seccion-perfil" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Perfil</h3>
                <input type="text" id="edit-name" placeholder="Nombre" value="Maestro Ejemplo" disabled>
                <input type="text" id="edit-img" placeholder="URL de foto" value="https://ui-avatars.com/api/?name=Maestro+Ejemplo" disabled>
                <button disabled>Guardar cambios</button>
            </div>
        </div>
    </div>
</body>
</html>