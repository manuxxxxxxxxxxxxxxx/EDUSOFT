<?php
session_start();
require_once "conexion.php";
require_once "DiarioPedagogico.php";

$diario = new DiarioPedagogico($conn);

// Guardar entrada al diario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'guardar_diario') {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'profesor' || !isset($_SESSION['id'])) {
        echo "Acceso denegado.";
        exit;
    }

    $id_profesor = $_SESSION['id'];
    $id_estudiante = $_POST['id_estudiante'];
    $id_codigo = empty($_POST['id_codigo']) ? null : $_POST['id_codigo'];
    $observacion = isset($_POST['observacion']) ? $_POST['observacion'] : '';
    $tipo_entrada = isset($_POST['tipo_entrada']) ? $_POST['tipo_entrada'] : '';
    $nivel_falta = empty($_POST['nivel_falta']) ? null : $_POST['nivel_falta'];

    // Validación básica
    if (empty($id_estudiante) || empty($id_profesor)) {
        echo "Faltan datos obligatorios.";
        exit;
    }

    $exito = $diario->insertar($id_estudiante, $id_profesor, $id_codigo, $observacion, $tipo_entrada, $nivel_falta);

    if ($exito) {
    // Redirección para evitar reenvío del formulario
    header("Location: formulario_profesor.php?toast=Registro+guardado");
    exit;
} else {
    echo "Error al guardar.";
}
}

// Consultar historial por alumno
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vista']) && $_GET['vista'] == 'alumno' && isset($_GET['id_estudiante'])) {
    $resultados = $diario->obtenerPorAlumno($_GET['id_estudiante']);
    // Muestra los resultados en HTML
    echo '<h2>Historial del alumno</h2>';
    echo '<table border="1"><tr>
            <th>Fecha</th>
            <th>ID Profesor</th>
            <th>ID Código</th>
            <th>Observación</th>
            <th>Tipo</th>
            <th>Nivel Falta</th>
        </tr>';
    foreach ($resultados as $row) {
        echo '<tr>
                <td>'.htmlspecialchars($row['fecha']).'</td>
                <td>'.htmlspecialchars($row['id_profesor']).'</td>
                <td>'.htmlspecialchars($row['id_codigo']).'</td>
                <td>'.htmlspecialchars($row['observacion']).'</td>
                <td>'.htmlspecialchars($row['tipo_entrada']).'</td>
                <td>'.htmlspecialchars($row['nivel_falta']).'</td>
            </tr>';
    }
    echo '</table>';
}

// Consultar historial por profesor
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vista']) && $_GET['vista'] == 'profesor' && isset($_GET['id_profesor'])) {
    $resultados = $diario->obtenerPorProfesor($_GET['id_profesor']);
    // Muestra los resultados en HTML
    echo '<h2>Historial del profesor</h2>';
    echo '<table border="1"><tr>
            <th>Fecha</th>
            <th>ID Estudiante</th>
            <th>ID Código</th>
            <th>Observación</th>
            <th>Tipo</th>
            <th>Nivel Falta</th>
        </tr>';
    foreach ($resultados as $row) {
        echo '<tr>
                <td>'.htmlspecialchars($row['fecha']).'</td>
                <td>'.htmlspecialchars($row['id_estudiante']).'</td>
                <td>'.htmlspecialchars($row['id_codigo']).'</td>
                <td>'.htmlspecialchars($row['observacion']).'</td>
                <td>'.htmlspecialchars($row['tipo_entrada']).'</td>
                <td>'.htmlspecialchars($row['nivel_falta']).'</td>
            </tr>';
    }
    echo '</table>';
}
?>