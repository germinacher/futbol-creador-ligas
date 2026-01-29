<?php
class DeleteAllModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Eliminar todos los datos de un usuario específico
    public function resetLeagueForUser($userId) {
        // Iniciar transacción
        $this->db->begin_transaction();
        
        try {
            // Eliminar de la tabla register
            $stmt = $this->db->prepare("DELETE FROM register WHERE user_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing register delete: " . $this->db->error);
            }
            
            $stmt->bind_param("i", $userId);
            
            if (!$stmt->execute()) {
                throw new Exception("Error executing register delete: " . $stmt->error);
            }
            
            $stmt->close();

            // Eliminar de la tabla matches
            $stmt = $this->db->prepare("DELETE FROM matches WHERE user_id = ?");
            if (!$stmt) {
                throw new Exception("Error preparing matches delete: " . $this->db->error);
            }
            
            $stmt->bind_param("i", $userId);
            
            if (!$stmt->execute()) {
                throw new Exception("Error executing matches delete: " . $stmt->error);
            }
            
            $stmt->close();
            
            // Confirmar transacción
            $this->db->commit();
            
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->rollback();
            throw $e;
        }
    }
}
?>