<?php
class DiarioPedagogico {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Listar estudiantes
    public function listarEstudiantes() {
        $estudiantes = [];
        $sql = "SELECT ID, nombre FROM estudiantes";
        if ($result = $this->conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = $row;
            }
            $result->free();
        }
        return $estudiantes;
    }

    // Listar códigos de conducta
    public function listarCodigos() {
        $codigos = [];
        $sql = "SELECT id, codigo, descripcion FROM codigos_conducta";
        if ($result = $this->conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $codigos[] = $row;
            }
            $result->free();
        }
        return $codigos;
    }

    // Insertar entrada en el diario pedagógico
    public function insertar($id_estudiante, $id_profesor, $id_codigo, $observacion, $tipo_entrada, $nivel_falta) {
        // Validaciones mínimas
        if (empty($id_estudiante) || empty($id_profesor)) {
            return false;
        }
        // Si id_codigo es vacío, usar NULL
        $id_codigo = !empty($id_codigo) ? $id_codigo : null;
        // Si nivel_falta es vacío, usar NULL
        $nivel_falta = !empty($nivel_falta) ? $nivel_falta : null;

        $stmt = $this->conn->prepare(
            "INSERT INTO diario_pedagogico 
                (id_estudiante, id_profesor, id_codigo, observacion, tipo_entrada, nivel_falta, fecha) 
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param("iiisss",
            $id_estudiante,
            $id_profesor,
            $id_codigo,
            $observacion,
            $tipo_entrada,
            $nivel_falta
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Historial por profesor
    public function obtenerPorProfesor($id_profesor) {
        $resultados = [];
        $sql = "SELECT fecha, id_estudiante, id_codigo, observacion, tipo_entrada, nivel_falta
                FROM diario_pedagogico
                WHERE id_profesor = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_profesor);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        $stmt->close();
        return $resultados;
    }

    // Historial por alumno
    public function obtenerPorAlumno($id_estudiante) {
        $resultados = [];
        $sql = "SELECT fecha, id_profesor, id_codigo, observacion, tipo_entrada, nivel_falta
                FROM diario_pedagogico
                WHERE id_estudiante = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_estudiante);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        $stmt->close();
        return $resultados;
    }
}
?>