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
        $sql = "SELECT id, nombre_clase, materia, codigo_clase FROM clases WHERE profesor_id = ?";
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
                                </a><br>
                                <small><strong>Código de clase:</strong> <?php echo htmlspecialchars($clase['codigo_clase']); ?></small>
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
                <h3>Tareas</h3>
                <ul id="tareas-lista">
                    <?php
                    $sqlTareas = "SELECT t.id, t.titulo, t.fecha_entrega, c.materia 
                                  FROM tareas_profesor t
                                  INNER JOIN clases c ON t.id_clase = c.id
                                  WHERE c.profesor_id = ?
                                  ORDER BY t.fecha_entrega DESC";
                    $stmtTareas = $conn->prepare($sqlTareas);
                    $stmtTareas->bind_param("i", $profesor_id);
                    $stmtTareas->execute();
                    $resultadoTareas = $stmtTareas->get_result();

                    if ($resultadoTareas->num_rows > 0):
                        while ($tarea = $resultadoTareas->fetch_assoc()): ?>
                            <li>
                                <b><?php echo htmlspecialchars($tarea['titulo']); ?></b> 
                                – <?php echo ucfirst(htmlspecialchars($tarea['materia'])); ?> 
                                – Fecha entrega: <?php echo htmlspecialchars($tarea['fecha_entrega']); ?>
                                <form action="../frontend_maestros/eliminar_tarea.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_tarea" value="<?php echo $tarea['id']; ?>">
                                    <button type="submit" class="quick-action" style="margin-left:10px;color:red;">Eliminar</button>
                                </form>
                            </li>
                        <?php endwhile;
                    else: ?>
                        <li>No hay tareas registradas aún.</li>
                    <?php endif;
                    $stmtTareas->close();
                    ?>
                </ul>
                <button class="quick-action" onclick="window.location.href='../frontend_maestros/subir_tarea.php'">Crear tarea</button>
            </div>
        </div>

        <?php
// Obtener id_clase desde GET para mostrar materiales de esa clase
$id_clase = isset($_GET['id_clase']) ? intval($_GET['id_clase']) : null;

// Obtener datos de la clase para mostrar nombre y materia
$clase_nombre = $clase_materia = "";

if ($id_clase) {
    $stmt_clase = $conn->prepare("SELECT nombre_clase, materia FROM clases WHERE id = ?");
    $stmt_clase->bind_param("i", $id_clase);
    $stmt_clase->execute();
    $res_clase = $stmt_clase->get_result();
    if ($row_clase = $res_clase->fetch_assoc()) {
        $clase_nombre = $row_clase['nombre_clase'];
        $clase_materia = $row_clase['materia'];
    }
    $stmt_clase->close();
}
?>

<!-- MATERIALES -->
<div id="seccion-materiales" class="seccion-panel">
    <div class="section">
        <h3>Materiales
            <?php if ($clase_nombre && $clase_materia): ?>
                — <?= htmlspecialchars($clase_nombre) ?> – <?= htmlspecialchars(ucfirst($clase_materia)) ?>
            <?php endif; ?>
        </h3>

        <ul id="lista-materiales">
            <?php
            if (!$id_clase) {
                echo "<li>📂 No hay clase seleccionada.</li>";
            } else {
                $sql = "SELECT id, titulo, archivo, ruta_archivo, fecha_subida FROM materiales_estudio WHERE id_clase = ? ORDER BY fecha_subida DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_clase);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    while ($material = $resultado->fetch_assoc()) {
                        $material_id = $material["id"];
                        $titulo = htmlspecialchars($material["titulo"] ?? '');
                        $archivo = htmlspecialchars($material["archivo"] ?? '');
                        $ruta = htmlspecialchars($material["ruta_archivo"] ?? '#');
                        $fecha = date("d/m/Y", strtotime($material["fecha_subida"] ?? ''));

                        echo "<li>";
                        echo "$titulo — <a href='$ruta' target='_blank'>$archivo</a> (Subido el $fecha) ";

                        echo "<form action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline-block; margin-left:10px;'>";
                        echo "<input type='hidden' name='accion' value='eliminar_material'>";
                        echo "<input type='hidden' name='id_material' value='$material_id'>";
                        echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($id_clase) . "'>";
                        echo "<button type='submit' class='btn btn-danger' onclick='return confirm(\"¿Seguro que deseas eliminar este material?\");'>Eliminar</button>";
                        echo "</form>";

                        echo "</li>";
                    }
                } else {
                    echo "<li>📂 No hay archivos registrados para esta clase.</li>";
                }
            }
            ?>
        </ul>

        <form action="../frontend_maestros/subir_material.php" method="get">
            <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
            <button type="submit" class="quick-action">Subir material</button>
        </form>
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