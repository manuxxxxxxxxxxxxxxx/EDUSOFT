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

// Consulta para traer las clases del profesor para los select
$sql = "SELECT id, nombre_clase, materia, codigo_clase FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$resultado = $stmt->get_result();
$clases = $resultado->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener id_clase para filtro de tareas/materiales y sus datos
$id_clase = isset($_GET['id_clase']) ? intval($_GET['id_clase']) : null;
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

// -------------------- RESPUESTAS MÚLTIPLES EN COMENTARIOS --------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_comentario_resp'], $_POST['texto_respuesta'])) {
    $id_comentario_resp = intval($_POST['id_comentario_resp']);
    $texto_respuesta = trim($_POST['texto_respuesta']);
    $tipo_usuario = 'profesor';
    $id_usuario = $profesor_id;
    if ($texto_respuesta && $id_comentario_resp && $id_usuario) {
        $stmt_insert = $conn->prepare("INSERT INTO respuestas_comentario (id_comentario, id_usuario, tipo_usuario, respuesta) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $id_comentario_resp, $id_usuario, $tipo_usuario, $texto_respuesta);
        $stmt_insert->execute();
        $stmt_insert->close();
        header("Location: ".$_SERVER['REQUEST_URI']."#comentario-".$id_comentario_resp);
        exit;
    }
}
// Procesar respuesta de comentario del profesor
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['respuesta_comentario'])) {
    $respuesta = trim($_POST['respuesta_comentario']);
    $comentario_id = intval($_POST['comentario_id']);
    if ($respuesta && $comentario_id) {
        $stmt_resp = $conn->prepare("UPDATE comentarios_clase SET respuesta = ?, id_profesor = ?, fecha_respuesta = NOW(), estado = 'respondido' WHERE id = ?");
        $stmt_resp->bind_param("sii", $respuesta, $profesor_id, $comentario_id);
        $stmt_resp->execute();
        $stmt_resp->close();
        header("Location: index.php?id_clase=$id_clase#seccion-comentarios");
        exit;
    }
}

// Cargar comentarios de alumnos
$comentarios = [];
if ($id_clase) {
    $sql_comentarios = "SELECT c.*, e.nombre AS nombre_alumno FROM comentarios_clase c
        LEFT JOIN estudiantes e ON c.id_estudiante = e.ID
        WHERE c.id_clase = ?
        ORDER BY c.estado DESC, c.fecha DESC";
    $stmt_coment = $conn->prepare($sql_comentarios);
    $stmt_coment->bind_param("i", $id_clase);
    $stmt_coment->execute();
    $res_coment = $stmt_coment->get_result();
    while ($row = $res_coment->fetch_assoc()) {
        $comentarios[] = $row;
    }
    $stmt_coment->close();
} else {
    $sql_comentarios = "SELECT c.*, e.nombre AS nombre_alumno, cl.nombre_clase, cl.materia
        FROM comentarios_clase c
        LEFT JOIN estudiantes e ON c.id_estudiante = e.ID
        INNER JOIN clases cl ON c.id_clase = cl.id
        WHERE cl.profesor_id = ?
        ORDER BY c.estado DESC, c.fecha DESC";
    $stmt_coment = $conn->prepare($sql_comentarios);
    $stmt_coment->bind_param("i", $profesor_id);
    $stmt_coment->execute();
    $res_coment = $stmt_coment->get_result();
    while ($row = $res_coment->fetch_assoc()) {
        $comentarios[] = $row;
    }
    $stmt_coment->close();
}
// Contador de comentarios pendientes
$pendientes = 0;
foreach ($comentarios as $c) {
    if ($c['estado'] === 'pendiente') $pendientes++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title data-i18n="maestro_panel_title">Panel del Maestro | Edusoft</title>
    <link rel="stylesheet" href="/frontend_maestros/stylemaestro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="/frontend_maestros/script.js"></script>
    <script>
    function confirmEliminar(tipo) {
        if (tipo === 'tarea') {
            return confirm('¿Estás seguro de que deseas eliminar esta tarea?');
        } else if (tipo === 'material') {
            return confirm('¿Estás seguro de que deseas eliminar este material?');
        } else if (tipo === 'aviso') {
            return confirm('¿Estás seguro de que deseas eliminar este aviso?');
        }
        return true;
    }
    </script>
    <script>
    document.getElementById('search-student').addEventListener('input', function() {
    var filtro = this.value.toLowerCase();
    document.querySelectorAll('#student-list li[data-nombre]').forEach(function(li){
        li.style.display = li.getAttribute('data-nombre').includes(filtro) ? '' : 'none';
    });
});
</script>
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Abrir menú">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar">
        <img id="profile-img" src="https://ui-avatars.com/api/?name=Maestro+Ejemplo" alt="Foto de perfil del Maestro Ejemplo">
        <h2 id="profile-name" data-i18n="maestro_panel_nombre">Docente <?php echo htmlspecialchars($nombre); ?></h2>
        <nav>
            <a href="#" class="active"><i class="fas fa-home"></i><span data-i18n="maestro_panel_inicio">Inicio</span></a>
            <a href="#"><i class="fas fa-book"></i><span data-i18n="maestro_panel_cursos">Cursos</span> <span class="badge" data-i18n="maestro_panel_cursos_num">3</span></a>
            <a href="#"><i class="fas fa-users"></i><span data-i18n="maestro_panel_alumnos">Alumnos</span></a>
            <a href="#"><i class="fas fa-tasks"></i><span data-i18n="maestro_panel_tareas">Tareas</span> <span class="badge" data-i18n="maestro_panel_tareas_num">3</span></a>
            <a href="#"><i class="fas fa-folder-open"></i><span data-i18n="maestro_panel_materiales">Materiales</span></a>
            <a href="#"><i class="fas fa-bullhorn"></i><span data-i18n="maestro_panel_avisos">Avisos</span></a>
            <a href="#"><i class="fas fa-envelope"></i><span data-i18n="maestro_panel_mensajes">Mensajes</span> <span class="badge">2</span></a>
            <a href="#"><i class="fas fa-user"></i><span data-i18n="maestro_panel_perfil">Perfil</span></a>
            <a href="#"><i class="fas fa-sign-out-alt"></i><span data-i18n="maestro_panel_salir">Salir</span></a>
        </nav>
    </div>
    <div class="main-content">
        <!-- INICIO -->
        <div id="seccion-inicio" class="seccion-panel">
            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-book fa-2x icon-green"></i>
                    <h3 data-i18n="maestro_panel_cursos_num">3</h3>
                    <p data-i18n="maestro_panel_cursos_asignados">Cursos asignados</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-cursos', 1)" data-i18n="maestro_panel_ver_cursos">Ver cursos</button>
                </div>
                <div class="card">
                    <i class="fas fa-users fa-2x icon-blue"></i>
                    <h3 data-i18n="maestro_panel_alumnos_num">9</h3>
                    <p data-i18n="maestro_panel_total_alumnos">Alumnos</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-alumnos', 2)" data-i18n="maestro_panel_ver_alumnos">Ver alumnos</button>
                </div>
                <div class="card">
                    <i class="fas fa-tasks fa-2x icon-orange"></i>
                    <h3 data-i18n="maestro_panel_tareas_num">3</h3>
                    <p data-i18n="maestro_panel_tareas_pendientes">Tareas pendientes</p>
                    <button class="quick-action" onclick="mostrarSeccion('seccion-tareas', 3)" data-i18n="maestro_panel_ver_tareas">Ver tareas</button>
                </div>
            </div>
            <div class="section">
                <h2 data-i18n="maestro_panel_bienvenido">Bienvenido, <span id="welcome-name" data-i18n="maestro_panel_nombre2">Docente <?php echo htmlspecialchars($nombre); ?></span></h2>
                <p data-i18n="maestro_panel_intro">Desde este panel puedes gestionar tus cursos, tareas, materiales, avisos y comunicarte con tus alumnos.</p>
            </div>
            <div class="section">
                <h3 data-i18n="maestro_panel_notificaciones_titulo">Notificaciones recientes</h3>
                <ul class="notificaciones">
                    <li data-i18n="maestro_panel_notif_1"><i class="fas fa-check-circle icon-green"></i> Juan Pérez entregó la tarea <b>"Ensayo de Historia"</b>.</li>
                    <li data-i18n="maestro_panel_notif_2"><i class="fas fa-envelope icon-blue"></i> Nuevo mensaje de <b>Ana López</b>.</li>
                    <li data-i18n="maestro_panel_notif_3"><i class="fas fa-bullhorn icon-orange"></i> Se publicó un aviso en el curso <b>"Matemáticas 2"</b>.</li>
                </ul>
            </div>
        </div>
        <!-- CURSOS -->
                <div id="seccion-cursos" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3>Mis cursos</h3>
                <input type="button" value="Crear curso" class="quick-action" onclick="window.location.href='../frontend_maestros/crear_curso.php'">
                <ul class="cursos-lista">
                    <?php if (count($clases) > 0): ?>
                        <?php foreach ($clases as $clase): ?>
                            <li>
                                <a class="curso-link" href="../materias/<?php echo $clase['materia']; ?>.php?id_clase=<?php echo $clase['id']; ?>">
                                    <?= htmlspecialchars($clase['nombre_clase']); ?>
                                </a>
                                <span class="curso-materia"> – <?= ucfirst($clase['materia']); ?></span><br>
                                <span class="curso-codigo"><strong>Código de clase:</strong> <?= htmlspecialchars($clase['codigo_clase']); ?></span>
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
                <h3 data-i18n="maestro_panel_titulo_alumnos">Alumnos</h3>
                <input type="text" id="search-student" placeholder="Buscar alumno..." style="width:90%;margin-top:10px;" oninput="searchStudent()" data-i18n="maestro_panel_buscar_alumno">
                <ul id="student-list" style="text-align:left;margin-top:10px;max-height:180px;overflow:auto;">
                    <li data-i18n="maestro_panel_alumno1">Juan Pérez</li>
                    <li data-i18n="maestro_panel_alumno2">Ana López</li>
                    <li data-i18n="maestro_panel_alumno3">Carlos Ruiz</li>
                    <li data-i18n="maestro_panel_alumno4">María Torres</li>
                    <li data-i18n="maestro_panel_alumno5">Lucía Díaz</li>
                    <li data-i18n="maestro_panel_alumno6">Sofía Romero</li>
                    <li data-i18n="maestro_panel_alumno7">Miguel Ángel</li>
                    <li data-i18n="maestro_panel_alumno8">Luis Gómez</li>
                    <li data-i18n="maestro_panel_alumno9">Pedro Sánchez</li>
                </ul>
            </div>
        </div>

<div id="seccion-alumnos" class="seccion-panel" style="display:none;">
    <div class="section alumnos-section">
        <h3>Alumnos</h3>
        <form method="get" action="index.php#seccion-alumnos">
            <select id="select-clase" name="id_clase" class="select-clase" onchange="this.form.submit()">
                <option value="">Selecciona una clase</option>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <input type="text" id="search-student" placeholder="Buscar alumno..." class="alumnos-buscar" <?= empty($id_clase) ? 'disabled' : '' ?>>
        <ul id="student-list" class="lista-alumnos">
        <?php
        if ($id_clase) {
            $sql = "SELECT ce.id AS numero_estudiante, e.nombre, e.email
                    FROM clases_estudiantes ce
                    JOIN estudiantes e ON ce.id_estudiante = e.ID
                    WHERE ce.id_clase = ?
                    ORDER BY ce.id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_clase);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while($alumno = $result->fetch_assoc()) {
                    echo "<li data-nombre='".strtolower($alumno['nombre'])." ".strtolower($alumno['email'])."'>
                            <span class='alumno-nombre'>".htmlspecialchars($alumno['nombre'])."</span>
                            <span class='alumno-num'>".htmlspecialchars($alumno['numero_estudiante'])."</span>
                            <span class='alumno-email'>".htmlspecialchars($alumno['email'])."</span>
                        </li>";
                }
            } else {
                echo "<li class='alumnos-vacio'>No hay alumnos inscritos en esta clase.</li>";
            }
            $stmt->close();
        } else {
            echo "<li class='alumnos-vacio'>Selecciona una clase para ver los alumnos.</li>";
        }
        ?>
        </ul>
    </div>
</div>

        <!-- TAREAS -->
        <div id="seccion-tareas" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3 data-i18n="maestro_panel_titulo_tareas">Tareas</h3>
                <label for="select-tarea-clase"><b data-i18n="maestro_panel_filtrar_clase">Filtrar por clase:</b></label>
                <select id="select-tarea-clase" name="select-tarea-clase" style="margin-bottom: 10px;" data-i18n="maestro_panel_select_filtrar_clase">
                    <option value="" data-i18n="maestro_panel_todas_clases">Todas las clases</option>
                    <?php foreach ($clases as $clase): ?>
                        <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?> data-i18n="maestro_panel_opcion_clase">
                            <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <ul id="tareas-lista">
                    <?php
                    if ($id_clase) {
                        $sqlTareas = "SELECT t.id, t.titulo, t.fecha_entrega, t.descripcion, c.materia 
                                    FROM tareas_profesor t
                                    INNER JOIN clases c ON t.id_clase = c.id
                                    WHERE t.id_clase = ?
                                    ORDER BY t.fecha_entrega DESC";
                        $stmtTareas = $conn->prepare($sqlTareas);
                        $stmtTareas->bind_param("i", $id_clase);
                        $stmtTareas->execute();
                        $resultadoTareas = $stmtTareas->get_result();

                        if ($resultadoTareas->num_rows > 0):
                            while ($tarea = $resultadoTareas->fetch_assoc()): ?>
                                <li>
                                    <b data-i18n="maestro_panel_tarea_titulo"><?= htmlspecialchars($tarea['titulo']); ?></b> 
                                    – <span data-i18n="maestro_panel_tarea_materia"><?= ucfirst(htmlspecialchars($tarea['materia'])); ?></span> 
                                    – <span data-i18n="maestro_panel_tarea_fecha_entrega">Fecha entrega:</span> <?= htmlspecialchars($tarea['fecha_entrega']); ?>
                                    <br><small data-i18n="maestro_panel_tarea_descripcion"><?= htmlspecialchars($tarea['descripcion']); ?></small>
                                    <form action="../frontend_maestros/eliminar_tarea.php" method="POST" style="display:inline;" onsubmit="return confirmEliminar('tarea');">
                                        <input type="hidden" name="accion" value="eliminar_tarea">
                                        <input type="hidden" name="id_tarea" value="<?= $tarea['id']; ?>">
                                        <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
                                        <button type="submit" class="btn-eliminar" data-i18n="maestro_panel_eliminar_tarea">Eliminar</button>
                                    </form>
                                </li>
                            <?php endwhile;
                        else: ?>
                            <li data-i18n="maestro_panel_no_tareas">No hay tareas registradas para esta clase.</li>
                        <?php endif;
                        $stmtTareas->close();
                    } else {
                        $sqlTareas = "SELECT t.id, t.titulo, t.fecha_entrega, t.descripcion, c.materia, c.nombre_clase, t.id_clase
                                    FROM tareas_profesor t
                                    INNER JOIN clases c ON t.id_clase = c.id
                                    WHERE c.profesor_id = ?
                                    ORDER BY c.nombre_clase, t.fecha_entrega DESC";
                        $stmtTareas = $conn->prepare($sqlTareas);
                        $stmtTareas->bind_param("i", $profesor_id);
                        $stmtTareas->execute();
                        $resultadoTareas = $stmtTareas->get_result();

                        $tareasPorClase = [];
                        while ($tarea = $resultadoTareas->fetch_assoc()) {
                            $tareasPorClase[$tarea['id_clase']]['nombre_clase'] = $tarea['nombre_clase'];
                            $tareasPorClase[$tarea['id_clase']]['materia'] = $tarea['materia'];
                            $tareasPorClase[$tarea['id_clase']]['tareas'][] = $tarea;
                        }

                        if (count($tareasPorClase) > 0) {
                            foreach ($tareasPorClase as $idClase => $datosClase) {
                                echo "<li style='margin-top:10px;'><strong data-i18n='maestro_panel_nombre_clase'>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</strong><ul>";
                                foreach ($datosClase['tareas'] as $tarea) {
                                    echo "<li>";
                                    echo "<b data-i18n='maestro_panel_tarea_titulo'>" . htmlspecialchars($tarea['titulo']) . "</b> – <span data-i18n='maestro_panel_tarea_fecha_entrega'>Fecha entrega:</span> " . htmlspecialchars($tarea['fecha_entrega']);
                                    echo "<br><small data-i18n='maestro_panel_tarea_descripcion'>" . htmlspecialchars($tarea['descripcion']) . "</small>";
                                    echo "<form action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline;' onsubmit=\"return confirmEliminar('tarea');\">";
                                    echo "<input type='hidden' name='accion' value='eliminar_tarea'>";
                                    echo "<input type='hidden' name='id_tarea' value='" . $tarea['id'] . "'>";
                                    echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                                    echo "<button type='submit' class='btn-eliminar' data-i18n='maestro_panel_eliminar_tarea'>Eliminar</button>";
                                    echo "</form>";
                                    echo "</li>";
                                }
                                echo "</ul></li>";
                            }
                        } else {
                            echo "<li data-i18n='maestro_panel_no_tareas'>No hay tareas registradas aún.</li>";
                        }
                        $stmtTareas->close();
                    }
                    ?>
                </ul>
                <form action="../frontend_maestros/subir_tarea.php" method="get">
                    <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
                    <button type="submit" class="quick-action" data-i18n="maestro_panel_crear_tarea">Crear tarea</button>
                </form>
            </div>
        </div>
        <!-- MATERIALES -->
        <div id="seccion-materiales" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3 data-i18n="maestro_panel_titulo_materiales">Materiales</h3>
                <label for="select-material-clase"><b data-i18n="maestro_panel_filtrar_clase">Filtrar por clase:</b></label>
                <select id="select-material-clase" name="select-material-clase" style="margin-bottom: 10px;" data-i18n="maestro_panel_select_filtrar_clase">
                    <option value="" data-i18n="maestro_panel_todas_clases">Todas las clases</option>
                    <?php foreach ($clases as $clase): ?>
                        <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?> data-i18n="maestro_panel_opcion_clase">
                            <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <ul id="lista-materiales">
                    <?php
                    if ($id_clase) {
                        $sql = "SELECT id, titulo, descripcion, archivo, ruta_archivo, fecha_subida FROM materiales_estudio WHERE id_clase = ? ORDER BY fecha_subida DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_clase);
                        $stmt->execute();
                        $resultado = $stmt->get_result();

                        if ($resultado->num_rows > 0) {
                            while ($material = $resultado->fetch_assoc()) {
                                $material_id = $material["id"];
                                $titulo = htmlspecialchars($material["titulo"] ?? '');
                                $descripcion = htmlspecialchars($material["descripcion"] ?? '');
                                $archivo = htmlspecialchars($material["archivo"] ?? '');
                                $ruta = htmlspecialchars($material["ruta_archivo"] ?? '#');
                                $fecha = date("d/m/Y", strtotime($material["fecha_subida"] ?? ''));

                                echo "<li>";
                                echo "<strong data-i18n='maestro_panel_material_titulo'>$titulo</strong>";
                                if ($descripcion) {
                                    echo "<br><small data-i18n='maestro_panel_material_desc'>$descripcion</small>";
                                }
                                echo " — <a href='$ruta' target='_blank' data-i18n='maestro_panel_material_archivo'>$archivo</a> (<span data-i18n='maestro_panel_material_fecha'>Subido el $fecha</span>) ";
                                echo "<form action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline-block; margin-left:10px;' onsubmit=\"return confirmEliminar('material');\">";
                                echo "<input type='hidden' name='accion' value='eliminar_material'>";
                                echo "<input type='hidden' name='id_material' value='$material_id'>";
                                echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($id_clase) . "'>";
                                echo "<button type='submit' class='btn-eliminar' data-i18n='maestro_panel_eliminar_material'>Eliminar</button>";
                                echo "</form>";
                                echo "</li>";
                            }
                        } else {
                            echo "<li data-i18n='maestro_panel_no_materiales'>No hay archivos registrados para esta clase.</li>";
                        }
                        $stmt->close();
                    } else {
                        $sql = "SELECT m.id, m.titulo, m.descripcion, m.archivo, m.ruta_archivo, m.fecha_subida, c.nombre_clase, c.materia, m.id_clase AS id_clase
                                FROM materiales_estudio m
                                INNER JOIN clases c ON m.id_clase = c.id
                                WHERE c.profesor_id = ?
                                ORDER BY c.nombre_clase, m.fecha_subida DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $profesor_id);
                        $stmt->execute();
                        $resultado = $stmt->get_result();

                        $materialesPorClase = [];
                        while ($material = $resultado->fetch_assoc()) {
                            $materialesPorClase[$material['id_clase']]['nombre_clase'] = $material['nombre_clase'];
                            $materialesPorClase[$material['id_clase']]['materia'] = $material['materia'];
                            $materialesPorClase[$material['id_clase']]['materiales'][] = $material;
                        }

                        if (count($materialesPorClase) > 0) {
                            foreach ($materialesPorClase as $idClase => $datosClase) {
                                echo "<li style='margin-top:10px;'><strong data-i18n='maestro_panel_nombre_clase'>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</strong><ul>";
                                foreach ($datosClase['materiales'] as $material) {
                                    $material_id = $material["id"];
                                    $titulo = htmlspecialchars($material["titulo"] ?? '');
                                    $descripcion = htmlspecialchars($material["descripcion"] ?? '');
                                    $archivo = htmlspecialchars($material["archivo"] ?? '');
                                    $ruta = htmlspecialchars($material["ruta_archivo"] ?? '#');
                                    $fecha = date("d/m/Y", strtotime($material["fecha_subida"] ?? ''));
                                    echo "<li>";
                                    echo "<strong data-i18n='maestro_panel_material_titulo'>$titulo</strong>";
                                    if ($descripcion) {
                                        echo "<br><small data-i18n='maestro_panel_material_desc'>$descripcion</small>";
                                    }
                                    echo " — <a href='$ruta' target='_blank' data-i18n='maestro_panel_material_archivo'>$archivo</a> (<span data-i18n='maestro_panel_material_fecha'>Subido el $fecha</span>) ";
                                    echo "<form action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline-block; margin-left:10px;' onsubmit=\"return confirmEliminar('material');\">";
                                    echo "<input type='hidden' name='accion' value='eliminar_material'>";
                                    echo "<input type='hidden' name='id_material' value='$material_id'>";
                                    echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                                    echo "<button type='submit' class='btn-eliminar' data-i18n='maestro_panel_eliminar_material'>Eliminar</button>";
                                    echo "</form>";
                                    echo "</li>";
                                }
                                echo "</ul></li>";
                            }
                        } else {
                            echo "<li data-i18n='maestro_panel_no_materiales'>No hay archivos registrados en tus clases.</li>";
                        }
                        $stmt->close();
                    }
                    ?>
                </ul>
                <form action="../frontend_maestros/subir_material.php" method="get">
                    <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
                    <button type="submit" class="quick-action" data-i18n="maestro_panel_subir_material">Subir material</button>
                </form>
            </div>
        </div>
<!-- AVISOS DINÁMICOS -->
        <div id="seccion-avisos" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3 data-i18n="maestro_panel_titulo_avisos">Avisos</h3>
                <label for="select-aviso-clase"><b data-i18n="maestro_panel_filtrar_clase">Filtrar por clase:</b></label>
                <select id="select-aviso-clase" name="select-aviso-clase" style="margin-bottom: 10px;" data-i18n="maestro_panel_select_filtrar_clase">
                    <option value="" data-i18n="maestro_panel_todas_clases">Todas las clases</option>
                    <?php foreach ($clases as $clase): ?>
                        <option value="<?= $clase['id'] ?>" <?= ($id_clase == $clase['id']) ? 'selected' : '' ?> data-i18n="maestro_panel_opcion_clase">
                            <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <ul id="avisos-lista">
                <?php
                // Mostrar avisos según filtro
                if ($id_clase) {
                    $sqlAvisos = "SELECT a.id, a.titulo, a.descripcion, a.fecha_subida, c.materia 
                                FROM avisos a
                                INNER JOIN clases c ON a.id_clase = c.id
                                WHERE a.id_clase = ?
                                ORDER BY a.fecha_subida DESC";
                    $stmtAvisos = $conn->prepare($sqlAvisos);
                    $stmtAvisos->bind_param("i", $id_clase);
                    $stmtAvisos->execute();
                    $resultadoAvisos = $stmtAvisos->get_result();

                    if ($resultadoAvisos->num_rows > 0):
                        while ($aviso = $resultadoAvisos->fetch_assoc()): ?>
                            <li>
                                <b data-i18n="maestro_panel_aviso_titulo"><?= htmlspecialchars($aviso['titulo']); ?></b>
                                  <span data-i18n="maestro_panel_aviso_materia"><?= ucfirst(htmlspecialchars($aviso['materia'])); ?></span> 
                                 <span data-i18n="maestro_panel_aviso_fecha">Fecha:</span> <?= htmlspecialchars($aviso['fecha_subida']); ?><br>
                                <small data-i18n="maestro_panel_aviso_descripcion"><?= htmlspecialchars($aviso['descripcion']); ?></small>

                                <b><?= htmlspecialchars($aviso['titulo']); ?></b>
                                 <?= ucfirst(htmlspecialchars($aviso['materia'])); ?> 
                                 <span>Fecha: <?= htmlspecialchars($aviso['fecha_subida']); ?></span><br>
                                <small><?= htmlspecialchars($aviso['descripcion']); ?></small>
                                <form action="../frontend_maestros/eliminar_tarea.php" method="POST" style="display:inline;" onsubmit="return confirmEliminar('aviso');">
                                    <input type="hidden" name="accion" value="eliminar_aviso">
                                    <input type="hidden" name="id_aviso" value="<?= $aviso['id']; ?>">
                                    <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase); ?>">
                                    <button type="submit" class="btn-eliminar" data-i18n="maestro_panel_eliminar_aviso">Eliminar</button>
                                </form>
                            </li>
                        <?php endwhile;
                    else: ?>
                        <li data-i18n="maestro_panel_no_avisos">No hay avisos registrados para esta clase.</li>
                    <?php endif;
                    $stmtAvisos->close();
                } else {
                    $sqlAvisos = "SELECT a.id, a.titulo, a.descripcion, a.fecha_subida, c.materia, c.nombre_clase, a.id_clase
                                FROM avisos a
                                INNER JOIN clases c ON a.id_clase = c.id
                                WHERE c.profesor_id = ?
                                ORDER BY c.nombre_clase, a.fecha_subida DESC";
                    $stmtAvisos = $conn->prepare($sqlAvisos);
                    $stmtAvisos->bind_param("i", $profesor_id);
                    $stmtAvisos->execute();
                    $resultadoAvisos = $stmtAvisos->get_result();

                    $avisosPorClase = [];
                    while ($aviso = $resultadoAvisos->fetch_assoc()) {
                        $avisosPorClase[$aviso['id_clase']]['nombre_clase'] = $aviso['nombre_clase'];
                        $avisosPorClase[$aviso['id_clase']]['materia'] = $aviso['materia'];
                        $avisosPorClase[$aviso['id_clase']]['avisos'][] = $aviso;
                    }

                    if (count($avisosPorClase) > 0) {
                        foreach ($avisosPorClase as $idClase => $datosClase) {
                            echo "<li style='margin-top:10px;'><strong data-i18n='maestro_panel_nombre_clase'>" . htmlspecialchars($datosClase['nombre_clase']) . " – " . htmlspecialchars($datosClase['materia']) . "</strong><ul>";
                            foreach ($datosClase['avisos'] as $aviso) {
                                echo "<li>";
                                echo "<b data-i18n='maestro_panel_aviso_titulo'>" . htmlspecialchars($aviso['titulo']) . "</b> – <span data-i18n='maestro_panel_aviso_fecha'>Fecha:</span> " . htmlspecialchars($aviso['fecha_subida']);
                                echo "<br><small data-i18n='maestro_panel_aviso_descripcion'>" . htmlspecialchars($aviso['descripcion']) . "</small>";
                                echo "<form action='../frontend_maestros/eliminar_tarea.php' method='POST' style='display:inline;' onsubmit=\"return confirmEliminar('aviso');\">";
                                echo "<input type='hidden' name='accion' value='eliminar_aviso'>";
                                echo "<input type='hidden' name='id_aviso' value='" . $aviso['id'] . "'>";
                                echo "<input type='hidden' name='id_clase' value='" . htmlspecialchars($idClase) . "'>";
                                echo "<button type='submit' class='btn-eliminar' data-i18n='maestro_panel_eliminar_aviso'>Eliminar</button>";
                                echo "</form>";
                                echo "</li>";
                            }
                            echo "</ul></li>";
                        }
                    } else {
                        echo "<li data-i18n='maestro_panel_no_avisos'>No hay avisos registrados aún.</li>";
                    }
                    $stmtAvisos->close();
                }
                ?>
                </ul>
                <form action="../frontend_maestros/crear_aviso.php" method="get">
                    <input type="hidden" name="id_clase" value="<?= htmlspecialchars($id_clase ?? '') ?>">
                    <button type="submit" class="quick-action" data-i18n="maestro_panel_crear_aviso">Crear aviso</button>
                </form>
            </div>
        </div>
    <!-- COMENTARIOS MULTIHILO -->
        <div id="seccion-mensajes" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3 data-i18n="maestro_panel_titulo_mensajes">Mensajes recientes</h3>
                <div class="avisos-timeline">
                    <div class="aviso-card">
                        <i class="fas fa-envelope icon-blue"></i>
                        <span data-i18n="maestro_panel_mensaje1">Mensaje de Ana López: "¿Cuándo es la entrega?"</span>
                    </div>
                    <div class="aviso-card">
                        <i class="fas fa-envelope icon-blue"></i>
                        <span data-i18n="maestro_panel_mensaje2">Mensaje de Juan Pérez: "No entiendo la tarea".</span>
                    </div>
                </div>

                <h3>Comentarios/dudas de alumnos 
                    <?php if ($pendientes > 0): ?>
                        <span class="badge" style="background:#e65100;color:white;padding:2px 9px;border-radius:11px;">
                            <?= $pendientes ?> pendientes
                        </span>
                    <?php endif; ?>
                </h3>
                <ul style="list-style:none;padding-left:0;">
                    <?php foreach ($comentarios as $c): ?>
                        <li id="comentario-<?= $c['id'] ?>" style="margin-bottom:15px;border-bottom:1px solid #93a3ddff;padding-bottom:8px;">
                            <b>
                                <?= htmlspecialchars($c['nombre_alumno'] ?? 'Alumno') ?>
                                <?php if (!$id_clase): ?>
                                    <span style="color:#888;">(<?= htmlspecialchars($c['nombre_clase'] ?? '') ?> - <?= htmlspecialchars($c['materia'] ?? '') ?>)</span>
                                <?php endif; ?>
                            </b>
                            <br>
                            <?= htmlspecialchars($c['comentario']) ?>
                            <small style="color:#888;">(<?= date("d/m/Y H:i", strtotime($c['fecha'])) ?>)</small>
                            <!-- RESPUESTAS MULTIHILO -->
                            <?php
                            $respuestas = [];
                            $stmt_resp = $conn->prepare("SELECT * FROM respuestas_comentario WHERE id_comentario = ? ORDER BY fecha ASC");
                            $stmt_resp->bind_param("i", $c['id']);
                            $stmt_resp->execute();
                            $result_resp = $stmt_resp->get_result();
                            while ($row_resp = $result_resp->fetch_assoc()) {
                                $respuestas[] = $row_resp;
                            }
                            $stmt_resp->close();
                            ?>
                            <?php foreach ($respuestas as $r): ?>
                                <div class="respuesta-hilo <?= $r['tipo_usuario'] == 'profesor' ? 'resp-prof' : 'resp-alum' ?>">
                                    <b><?= $r['tipo_usuario'] == 'profesor' ? 'Profesor' : 'Alumno' ?>:</b>
                                    <?= htmlspecialchars($r['respuesta']) ?>
                                    <small style="color:#888;"><?= date("d/m/Y H:i", strtotime($r['fecha'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                            <!-- FORMULARIO DE RESPUESTA MULTIHILO -->
                            <form method="POST" class="form-resp-comentario">
                                <input type="hidden" name="id_comentario_resp" value="<?= $c['id'] ?>">
                                <textarea name="texto_respuesta" rows="2" class="textarea-respuesta" placeholder="Responder al comentario..." required></textarea>
                                <button type="submit" class="btn-respuesta">Responder</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($comentarios)): ?>
                        <li>No hay comentarios/dudas aún.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- PERFIL -->
        <div id="seccion-perfil" class="seccion-panel" style="display:none;">
            <div class="section">
                <h3 data-i18n="maestro_panel_titulo_perfil">Perfil</h3>
                <input type="text" id="edit-name" placeholder="Nombre" value="Maestro Ejemplo" disabled data-i18n="maestro_panel_input_nombre">
                <input type="text" id="edit-img" placeholder="URL de foto" value="https://ui-avatars.com/api/?name=Maestro+Ejemplo" disabled data-i18n="maestro_panel_input_img">
                <button disabled data-i18n="maestro_panel_guardar_cambios">Guardar cambios</button>
            </div>
        </div>
    </div>
    
</body>
  <script src="../nosotros/cursos.js"></script>
  <script src="../principal/lang.js"></script>
  <script src="../principal/idioma.js"></script>
</body>
</html>