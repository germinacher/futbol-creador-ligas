<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/usermodel.php";

// Iniciar sesión del usuario
session_start();

// Redirigir si el usuario ya ha iniciado sesión
if (isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

// Inicializar variables
$message = "";
$username = "";

// Inicializar modelo
$userModel = new UserModel($mysqli);

// Manejar envío del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y limpiar datos del formulario
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    
    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $message = "Por favor, completa todos los campos.";
    } elseif (strlen($password) < 6) {
        // Validar longitud mínima de la contraseña
        $message = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        try {
            // Verificar si el nombre de usuario ya existe
            if ($userModel->usernameExists($username)) {
                $message = "El nombre de usuario ya está en uso.";
            } else {
                // Registrar nuevo usuario
                $userModel->registerUser($username, $password);
                $message = "Usuario registrado con éxito. Ahora puedes iniciar sesión.";
                $username = ""; // Limpiar formulario después del registro exitoso
            }
        } catch (Exception $e) {
            // Registrar error y mostrar mensaje 
            error_log("Registration error: " . $e->getMessage());
            $message = "Error al registrar el usuario. Inténtalo de nuevo.";
        }
    }
}

// Incluir vista
require_once '../views/auth/registerview.php';
?>