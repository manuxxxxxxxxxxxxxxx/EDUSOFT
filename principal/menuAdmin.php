<?php
// Conexion a la base de datos
$conn = new mysqli("localhost", "root", "", "edusoft");
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

// Generar contraseña aleatoria
function generarContrasena() {
  return bin2hex(random_bytes(4));
}

// Agregar profesor
if (isset($_POST['add_profesor'])) {
  $nombre = $_POST['nombre_prof'];
  $apellido = $_POST['apellido_prof'];
  $materia = $_POST['materia'];
  $pass = generarContrasena();
  $stmt = $conn->prepare("INSERT INTO profesores (nombre, apellido, materia, pass) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nombre, $apellido, $materia, $pass);
  $stmt->execute();
}

// Editar profesor
if (isset($_POST['edit_profesor'])) {
  $id = $_POST['id_prof'];
  $nombre = $_POST['nombre_prof'];
  $apellido = $_POST['apellido_prof'];
  $materia = $_POST['materia'];
  $stmt = $conn->prepare("UPDATE profesores SET nombre=?, apellido=?, materia=? WHERE id=?");
  $stmt->bind_param("sssi", $nombre, $apellido, $materia, $id);
  $stmt->execute();
}

// Eliminar profesor
if (isset($_GET['del_prof'])) {
  $id = $_GET['del_prof'];
  $conn->query("DELETE FROM profesores WHERE id=$id");
}

// Agregar estudiante
if (isset($_POST['add_estudiante'])) {
  $nombre = isset($_POST['nombre_est']) ? $_POST['nombre_est'] : '';
  $apellido = isset($_POST['apellido_est']) ? $_POST['apellido_est'] : '';
  $grado = isset($_POST['grado']) ? $_POST['grado'] : '';
  $seccion = isset($_POST['seccion']) ? $_POST['seccion'] : '';
  $pass = generarContrasena();
  $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, apellido, grado, seccion, pass) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nombre, $apellido, $grado, $seccion, $pass);
  $stmt->execute();
}

// Editar estudiante
if (isset($_POST['edit_estudiante'])) {
  $id = $_POST['id_est'];
  $nombre = isset($_POST['nombre_est']) ? $_POST['nombre_est'] : '';
  $apellido = isset($_POST['apellido_est']) ? $_POST['apellido_est'] : '';
  $grado = $_POST['grado'];
  $seccion = $_POST['seccion'];
  $stmt = $conn->prepare("UPDATE estudiantes SET nombre=?, apellido=?, grado=?, seccion=? WHERE ID=?");
  $stmt->bind_param("ssssi", $nombre, $apellido, $grado, $seccion, $id);
  $stmt->execute();
}

// Eliminar estudiante
if (isset($_GET['del_est'])) {
  $id = $_GET['del_est'];
  $conn->query("DELETE FROM estudiantes WHERE ID=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Administrador - EduSoft</title>
  <link rel="stylesheet" href="StyleAdmin.css">
  
</head>
<body>
  <div class="menu">
    <h1>Panel de Administración</h1>
    <ul>
      <li><a href="#profesores">Profesores</a></li>
      <li><a href="#estudiantes">Estudiantes</a></li>
    </ul>
  </div>

  <div class="contenido" id="profesores">
    <h2>Agregar Profesor</h2>
    <form method="post">
      <input type="text" name="nombre_prof" placeholder="Nombres" required>
      <input type="text" name="apellido_prof" placeholder="Apellidos" required>
      <input type="text" name="materia" placeholder="Materia" required>
      <input type="submit" name="add_profesor" value="Agregar Profesor">
    </form>

    <h3>Listado de Profesores</h3>
    <table>
      <tr><th>Nombre</th><th>Apellido</th><th>Materia</th><th>Contraseña</th><th>Acciones</th></tr>
      <?php
        $res = $conn->query("SELECT * FROM profesores");
        while($row = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td><input type='text' name='nombre_prof' value='{$row['nombre']}'></td>
                    <td><input type='text' name='apellido_prof' value='{$row['apellido']}'></td>
                    <td><input type='text' name='materia' value='{$row['materia']}'></td>
                    <td>{$row['pass']}</td>
                    <td>
                      <input type='hidden' name='id_prof' value='{$row['id']}'>
                      <input type='submit' name='edit_profesor' value='Editar' >
                      <a href='?del_prof={$row['id']}' onclick=\"return confirm('¿Eliminar profesor?')\" >Eliminar</a>
                    </td>
                  </form>
                </tr>";
        }
      ?>
    </table>
  </div>

  <div class="contenido" id="estudiantes">
    <h2>Agregar Estudiante</h2>
    <form method="post">
      <input type="text" name="nombre_est" placeholder="Nombres" required>
      <input type="text" name="apellido_est" placeholder="Apellidos" required>
      <input type="text" name="grado" placeholder="Grado" required>
      <input type="text" name="seccion" placeholder="Sección" required>
      <input type="submit" name="add_estudiante" value="Agregar Estudiante">
    </form>

    <h3>Listado de Estudiantes</h3>
    <table>
      <tr><th>Nombre</th><th>Apellido</th><th>Grado</th><th>Sección</th><th>Contraseña</th><th>Acciones</th></tr>
      <?php
        $res = $conn->query("SELECT * FROM estudiantes");
        while($row = $res->fetch_assoc()) {
          echo "<tr>
                  <form method='post'>
                    <td><input type='text' name='nombre_est' value='{$row['nombre']}'></td>
                    <td><input type='text' name='apellido_est' value='{$row['apellido']}'></td>
                    <td><input type='text' name='grado' value='{$row['grado']}'></td>
                    <td><input type='text' name='seccion' value='{$row['seccion']}'></td>
                    <td>{$row['pass']}</td>
                    <td>
                      <input type='hidden' name='id_est' value='{$row['ID']}'>
                      <input type='submit' name='edit_estudiante' value='Editar' class='btn btn-edit'>
                      <a href='?del_est={$row['ID']}' onclick=\"return confirm('¿Eliminar estudiante?')\" class='btn btn-delete'>Eliminar</a>
                    </td>
                  </form>
                </tr>";
        }
      ?>
    </table>
  </div>
</body>
</html>
