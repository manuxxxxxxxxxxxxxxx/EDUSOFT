<?php
class CodigoConducta {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar códigos de conducta para el formulario
    public function listarCodigos() {
        $res = $this->conn->query("SELECT id, codigo, descripcion FROM codigos_conducta");
        if ($res === false) {
            // Manejo de error en la consulta
            return [];
        }
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>