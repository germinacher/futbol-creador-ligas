<?php
class InsertMatchModel {
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

    // Registrar un nuevo partido
    public function registerMatch($homeTeam, $awayTeam, $homeScore, $awayScore, $userId) {
        // Verificar si el partido ya existe
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM matches WHERE home_team = ? AND away_team = ? AND user_id = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        $stmt->bind_param("ssi", $homeTeam, $awayTeam, $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        if ($row['count'] > 0) {
            return "Ese partido ya fue jugado.";
        }

        // Obtener fecha y hora actual
        $now = date("Y-m-d H:i:s");
        
        // Iniciar transacción
        $this->db->begin_transaction();
        
        try {
            // Actualizar estadísticas de equipos según el resultado del partido
            if ($homeScore > $awayScore) {
                // El equipo local gana
                $this->updateTeamStats($homeTeam, $userId, 1, 1, 0, 0, 3, $homeScore, $awayScore);
                $this->updateTeamStats($awayTeam, $userId, 1, 0, 0, 1, 0, $awayScore, $homeScore);
                $homeResult = 'W';
                $awayResult = 'L';
            } elseif ($homeScore < $awayScore) {
                // El equipo visitante gana
                $this->updateTeamStats($awayTeam, $userId, 1, 1, 0, 0, 3, $awayScore, $homeScore);
                $this->updateTeamStats($homeTeam, $userId, 1, 0, 0, 1, 0, $homeScore, $awayScore);
                $homeResult = 'L';
                $awayResult = 'W';
            } else {
                // Empate
                $this->updateTeamStats($homeTeam, $userId, 1, 0, 1, 0, 1, $homeScore, $awayScore);
                $this->updateTeamStats($awayTeam, $userId, 1, 0, 1, 0, 1, $awayScore, $homeScore);
                $homeResult = 'D';
                $awayResult = 'D';
            }

            // Insertar registro del partido
            $stmt = $this->db->prepare("INSERT INTO matches (home_team, away_team, home_score, away_score, home_result, away_result, date, user_id) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Error preparing match insert: " . $this->db->error);
            }
            
            $stmt->bind_param("ssiiissi", $homeTeam, $awayTeam, $homeScore, $awayScore, $homeResult, $awayResult, $now, $userId);
            
            if (!$stmt->execute()) {
                throw new Exception("Error executing match insert: " . $stmt->error);
            }
            
            $stmt->close();
            
            // Confirmar transacción
            $this->db->commit();
            
            return "Partido registrado correctamente.";
            
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->rollback();
            throw $e;
        }
    }
    
    // Actualizar estadísticas de un equipo
    private function updateTeamStats($teamName, $userId, $played, $wins, $draws, $defeats, $points, $goalsFavor, $goalsAgainst) {
        // Preparar consulta para actualizar estadísticas del equipo
        $stmt = $this->db->prepare("INSERT INTO register (team, played, win, draw, defeat, points, gf, gc, user_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparing stats update: " . $this->db->error);
        }
        
        $stmt->bind_param("siiiiiiis", $teamName, $played, $wins, $draws, $defeats, $points, $goalsFavor, $goalsAgainst, $userId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing stats update: " . $stmt->error);
        }
        
        $stmt->close();
    }
}
?>