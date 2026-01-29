<?php
class TableModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }
    
    // Obtener la tabla de posiciones de equipos para un usuario específico
    public function getStandings($userId) {
        // Preparar consulta para obtener la tabla de posiciones de equipos
        $stmt = $this->db->prepare("
            SELECT 
                team, 
                SUM(played) AS played, 
                SUM(win) AS win, 
                SUM(draw) AS draw, 
                SUM(defeat) AS defeat, 
                SUM(gf) AS gf, 
                SUM(gc) AS gc, 
                SUM(points) AS points 
            FROM register 
            WHERE user_id = ?
            GROUP BY team 
            ORDER BY points DESC, gf DESC
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
        $standings = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $standings;
    }
}
?>
