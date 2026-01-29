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
    } else {
        try {
            // Buscar usuario en la base de datos
            $user = $userModel->getUserByUsername($username);
            
            // Verificar credenciales del usuario
            if ($user && password_verify($password, $user["password"])) {
                // Establecer variables de sesión
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                
                // Redirigir a la página principal
                header("Location: ../index.php");
                exit();
            } else {
                $message = "Usuario o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            // Registrar error y mostrar mensaje 
            error_log("Login error: " . $e->getMessage());
            $message = "Error al procesar el inicio de sesión. Inténtalo de nuevo.";
        }
    }
}

// Incluir vista
require_once '../views/auth/loginview.php';
?>