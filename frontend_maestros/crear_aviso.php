<?php
require_once "../conexiones/conexion.php";
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    die("Acceso denegado.");
}
$profesor_id = $_SESSION["id"];

// Traer clases del profesor para el select
$sql = "SELECT id, nombre_clase, materia FROM clases WHERE profesor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$res = $stmt->get_result();
$clases = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Procesar el formulario
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_clase = intval($_POST["id_clase"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha_subida = trim($_POST["fecha_subida"] ?? date("Y-m-d"));

    if (!$id_clase || !$titulo || !$descripcion || !$fecha_subida) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO avisos (id_clase, titulo, descripcion, fecha_subida) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_clase, $titulo, $descripcion, $fecha_subida);
        if ($stmt->execute()) {
            // Redirigir al mismo archivo con exito=1 e id_clase para mostrar el modal
            header("Location: crear_aviso.php?id_clase=$id_clase&exito=1");
            exit;
        } else {
            $error = "Hubo un error al guardar el aviso.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear aviso | Edusoft</title>
    <link rel="stylesheet" href="../frontend_maestros/crear_aviso.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <style>
           #btn-back {
        position: fixed;
        left: 32px;
        top: 32px;
        z-index: 99;
        background: linear-gradient(90deg, #0a0a0aff, #0f0f0fff);
        color: #fff;
        border: none;
        outline: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        box-shadow: 0 6px 24px #8d72e144;
        cursor: pointer;
        font-size: 1.8rem;
        transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #btn-back:hover {
        background: linear-gradient(90deg, #8d72e1, #67b6fa);
        box-shadow: 0 10px 30px #67b6fa55;
        transform: translateY(-2px) scale(1.06);
    }
    @media (max-width:600px){
        #btn-back {
            left: 12px;
            top: 12px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
    </style>

</head>
<body>
     <button id="btn-back" title="Volver" onclick="window.location.href='../frontend_maestros/index.php';">
        <i class="fas fa-arrow-left"></i>
    </button>
    <h2 data-i18n="maestro_panel_crear_aviso_title">Crear aviso</h2>
    <?php if ($error): ?>
        <p style="color:red;" data-i18n="maestro_panel_aviso_error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="id_clase" data-i18n="maestro_panel_aviso_label_clase"><b>Clase/Materia:</b></label>
        <select name="id_clase" id="id_clase" required data-i18n="maestro_panel_aviso_select_clase">
            <option value="" data-i18n="maestro_panel_aviso_option_default">Seleccione una clase</option>
            <?php foreach ($clases as $clase): ?>
                <option value="<?= $clase['id'] ?>" data-i18n="maestro_panel_aviso_option_clase">
                    <?= htmlspecialchars($clase['nombre_clase']) ?> – <?= htmlspecialchars($clase['materia']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="titulo" data-i18n="maestro_panel_aviso_label_titulo"><b>Nombre del aviso:</b></label>
        <input type="text" name="titulo" id="titulo" required data-i18n="maestro_panel_aviso_input_titulo"><br><br>

        <label for="descripcion" data-i18n="maestro_panel_aviso_label_descripcion"><b>Descripción:</b></label>
        <textarea name="descripcion" id="descripcion" cols="40" rows="4" required data-i18n="maestro_panel_aviso_textarea_descripcion"></textarea><br><br>

        <label for="fecha_subida" data-i18n="maestro_panel_aviso_label_fecha"><b>Fecha de subida:</b></label>
        <input type="date" name="fecha_subida" id="fecha_subida" value="<?= date('Y-m-d') ?>" required data-i18n="maestro_panel_aviso_input_fecha"><br><br>

        <button type="submit" data-i18n="maestro_panel_aviso_btn_submit">Crear aviso</button>
    </form>

    <!-- Modal bonito de éxito para AVISO con letras naranjas -->
    <div id="modalExitoAviso" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="background-color:white; padding:30px; max-width:400px; margin:100px auto; border-radius:8px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <h2 data-i18n="crear_aviso_modal_exito" style="color:orange;">✅ Aviso creado con éxito</h2>
            <p data-i18n="crear_aviso_modal_exito_desc" style="color:orange;">Tu aviso ha sido registrado correctamente.</p>
            <button onclick="cerrarModalAviso()" style="padding:8px 16px; margin-top:10px; background-color:#FF9800; color:white; border:none; border-radius:4px;" data-i18n="crear_aviso_modal_aceptar">Aceptar</button>
        </div>
    </div>

    <script>
    function cerrarModalAviso() {
        // Extrae id_clase de los parámetros GET, no de PHP
        var params = new URLSearchParams(window.location.search);
        var id_clase = params.get("id_clase") || "";
        window.location.href = "../frontend_maestros/index.php?id_clase=" + encodeURIComponent(id_clase) + "#seccion-avisos";
    }
    window.onload = function () {
        var params = new URLSearchParams(window.location.search);
        if (params.get("exito") === "1") {
            document.getElementById("modalExitoAviso").style.display = "block";
        }
    }
    </script>
    <script src="../principal/lang.js"></script>
    <script src="../principal/idioma.js"></script>
</body>
</html>