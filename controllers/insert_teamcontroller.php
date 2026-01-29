<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/insert_teammodel.php";

// Iniciar sesión del usuario
session_start();

// Redirigir si el usuario no ha iniciado sesión
if (!isset($_SESSION["user_id"])) {
    header("Location: logincontroller.php");
    exit();
}

// Obtener ID del usuario de la sesión
$userId = $_SESSION["user_id"];
$message = "";
$teamName = "";

// Inicializar modelo 
$teamModel = new InsertTeamModel($mysqli);

// Manejar envío del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y procesar nombre del equipo (convertir a mayúsculas)
    $teamName = strtoupper(trim($_POST["team_name"] ?? ""));
    
    // Validar que el nombre del equipo no esté vacío
    if (empty($teamName)) {
        $message = "Por favor, introduce un nombre de equipo.";
    } elseif (strlen($teamName) < 2) {
        // Validar longitud mínima del nombre del equipo
        $message = "El nombre del equipo debe tener al menos 2 caracteres.";
    } else {
        try {
            // Verificar si el equipo ya existe para este usuario
            if ($teamModel->teamExists($teamName, $userId)) {
                $message = "Ese equipo ya existe.";
            } else {
                // Insertar nuevo equipo
                if ($teamModel->insertTeam($teamName, $userId)) {
                    $message = "Equipo '$teamName' creado correctamente.";
                    $teamName = ""; // Limpiar formulario después de la inserción exitosa
                } else {
                    $message = "Error al crear el equipo. Inténtalo de nuevo.";
                }
            }
        } catch (Exception $e) {
            // Registrar error y mostrar mensaje 
            error_log("Team insertion error: " . $e->getMessage());
            $message = "Error al crear el equipo. Inténtalo de nuevo.";
        }
    }
}

// Incluir vista
require_once "../views/insert_teamview.php";
?>