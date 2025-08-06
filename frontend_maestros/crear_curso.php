<?php
session_start();
require_once "../conexiones/conexion.php";

// Validar sesión de profesor
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'profesor') {
    header("Location: ../conexiones/loginProfes.php");
    exit;
}

$profesor_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$mensaje = "";

// Si se envió el formulario (POST), procesar:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_clase = $_POST['codigo_clase'] ?? null; // <- AHORA SÍ AQUÍ

    // Verificar que vengan los campos
    if (!isset($_POST['nombre_clase'], $_POST['materia']) || empty($_POST['nombre_clase']) || empty($_POST['materia'])) {
        $mensaje = "Faltan campos obligatorios.";
    } 
    elseif  (empty($codigo_clase)) {
        $mensaje = "Debes generar un código para la clase.";
    }
    else {
        $nombre_clase = $_POST['nombre_clase'];
        $materia = $_POST['materia'];
        $descripcion = $_POST['descripcion'] ?? '';
        $id_profesor = $_SESSION['id']; // Solo por seguridad

        // Insertar en base de datos
        $stmt = $conn->prepare("INSERT INTO clases (nombre_clase, materia, descripcion, profesor_id, codigo_clase) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $nombre_clase, $materia, $descripcion, $profesor_id, $codigo_clase);

        if ($stmt->execute()) {
            header("Location: crear_curso.php?exito=1");
            exit;
        } else {
            $mensaje = 'Error al crear clase: ' . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Clase</title>
    <link rel="stylesheet" href="crearCurso.css">
</head>
<body>
    <div class="panel-bg">
        <div class="form-card">

            <h2>Bienvenido, Profesor <?php echo htmlspecialchars($nombre); ?></h2>
            <h3>Crear una nueva clase</h3>
            <?php if ($mensaje): ?>
                <p><strong><?php echo $mensaje; ?></strong></p>
            <?php endif; ?>
            <form method="POST">
                <label>Nombre de la clase:</label>
                <input type="text" name="nombre_clase" required>


                <div class="form-row">
    <label for="materia">
        <i class="fa-solid fa-book-open"></i> Materia:
    </label>
    <div class="select-wrapper">
        <select name="materia" id="materia" required>
            <option value="">-- Selecciona una materia --</option>
            <option value="matematica">Matemática</option>
            <option value="biologia">Biología</option>
            <option value="sociales">Sociales</option>
            <option value="lenguaje">Lenguaje</option>
        </select>
        <span class="select-icon"><i class="fa-solid fa-book-open"></i></span>
    </div>
</div>

                <label>Descripción:</label>
                <textarea name="descripcion" placeholder="Describe brevemente la clase..."></textarea>

                <input type="submit" value="Crear clase">
            </form>
        </div>
    </div>

    <?php if ($mensaje): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>

    <form action="crear_curso.php" method="POST" onsubmit="return validarFormulario()">
        <label for="nombre_clase">Nombre de la clase:</label><br>
        <input type="text" name="nombre_clase" required><br><br>

        <label for="materia">Materia:</label><br>
        <input type="text" name="materia" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <!-- Botón para generar código -->
        <button type="button" onclick="generarCodigo()">🔐 Generar código</button>
        <p><strong>Código generado:</strong> <span id="codigoGenerado">---</span></p>

        <!-- Campo oculto para guardar el código generado -->
        <input type="hidden" name="codigo_clase" id="codigo_clase">

        <button type="submit">✅ Crear clase</button>
    </form>

        <!-- Modal bonito de éxito -->
    <div id="modalExito" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="background-color:white; padding:30px; max-width:400px; margin:100px auto; border-radius:8px; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <h2>✅ Clase creada con éxito</h2>
            <p>Tu clase ha sido registrada correctamente.</p>
            <button onclick="cerrarModal()" style="padding:8px 16px; margin-top:10px; background-color:#4CAF50; color:white; border:none; border-radius:4px;">Aceptar</button>
        </div>
    </div>

    <script>
    function generarCodigo(longitud = 6) {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let codigo = '';
    for (let i = 0; i < longitud; i++) {
        codigo += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }

    // Mostrar el código en pantalla
    document.getElementById('codigoGenerado').innerText = codigo;

    // Guardar el código en el input oculto
    document.getElementById('codigo_clase').value = codigo;
    }
    function validarFormulario() {
    const codigo = document.getElementById('codigo_clase').value;
    if (!codigo) {
        alert("Por favor, genera un código antes de crear la clase.");
        return false; // evita que se envíe el formulario
    }
    return true; // permite el envío si todo está bien
}

    
    // Mostrar el modal de éxito si viene en la URL el parámetro ?exito=1
    window.onload = function () {
        const params = new URLSearchParams(window.location.search);
        if (params.get("exito") === "1") {
            document.getElementById("modalExito").style.display = "block";
        }
    }

    function cerrarModal() {
        document.getElementById("modalExito").style.display = "none";
        // Redirigir al panel del profesor (o recargar sin el ?exito)
        window.location.href = "index.php";
    }

</script>

</body>
</html>