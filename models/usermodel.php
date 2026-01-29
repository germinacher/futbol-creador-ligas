<?php
class UserModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Obtener usuario por nombre de usuario
    public function getUserByUsername($username) {
        // Preparar consulta para buscar usuario por nombre
        $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetro y ejecutar consulta
        $stmt->bind_param("s", $username);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        // Obtener resultado y cerrar consulta
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        return $user;
    }

    // Verificar si un nombre de usuario ya existe
    public function usernameExists($username) {
        // Preparar consulta para contar usuarios con el mismo nombre
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetro y ejecutar consulta
        $stmt->bind_param("s", $username);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        // Obtener resultado y cerrar consulta
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] > 0;
    }

    // Registrar un nuevo usuario
    public function registerUser($username, $password) {
        // Generar hash seguro de la contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Preparar consulta para insertar nuevo usuario
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $this->db->error);
        }
        
        // Vincular parámetros y ejecutar consulta
        $stmt->bind_param("ss", $username, $hash);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        $stmt->close();
        return true;
    }
}
?>