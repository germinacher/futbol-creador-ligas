<?php
class DeleteTeamModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Obtener todos los equipos de un usuario específico
    public function getTeamsByUser($userId) {
        $teams = [];
        
        // Preparar consulta para obtener equipos del usuario
        $stmt = $this->db->prepare("SELECT team FROM register WHERE user_id = ? GROUP BY team ORDER BY team");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetro y ejecutar consulta
        $stmt->bind_param("i", $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        // Obtener resultados y cerrar consulta
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $teams[] = $row["team"];
        }
        
        $stmt->close();
        return $teams;
    }

    // Verificar si un equipo existe para un usuario específico
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

    // Eliminar un equipo para un usuario específico
    public function deleteTeam($teamName, $userId) {
        // Preparar consulta para eliminar equipo
        $stmt = $this->db->prepare("DELETE FROM register WHERE team = ? AND user_id = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetros y ejecutar consulta
        $stmt->bind_param("si", $teamName, $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        // Verificar filas afectadas y cerrar consulta
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        
        return $affectedRows > 0;
    }
}
?>