<?php
class MatchesModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    //Obtener todos los partidos de un usuario específico ordenados por fecha descendente
    public function getMatchesByUser($userId) {
        // Preparar consulta para obtener partidos del usuario
        $stmt = $this->db->prepare("
            SELECT home_team, home_score, away_team, away_score, date, home_result, away_result
            FROM matches 
            WHERE user_id = ?
            ORDER BY date DESC
        ");
        
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
        $matches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $matches;
    }
}
?>