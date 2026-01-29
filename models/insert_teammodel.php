<?php
class InsertTeamModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Verificar si un equipo ya existe para el usuario
    public function teamExists($teamName, $userId) {
        // Preparar consulta para verificar existencia del equipo
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM register WHERE team = ? AND user_id = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetros y ejecutar consulta
        $stmt->bind_param("si", $teamName, $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        // Obtener resultado y cerrar consulta
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }

    // Insertar un nuevo equipo para el usuario
    public function insertTeam($teamName, $userId) {
        // Preparar consulta para insertar nuevo equipo
        $stmt = $this->db->prepare("INSERT INTO register (team, user_id) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetros y ejecutar consulta
        $stmt->bind_param("si", $teamName, $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        $stmt->close();
        return true;
    }
}
?>