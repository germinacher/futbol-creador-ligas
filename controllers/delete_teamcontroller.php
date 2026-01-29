<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/delete_teammodel.php";

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
$teams = [];

// Inicializar el modelo 
$teamModel = new DeleteTeamModel($mysqli);

// Obtener equipos del usuario para el menú desplegable
try {
    $teams = $teamModel->getTeamsByUser($userId);
} catch (Exception $e) {
    $message = "Error al cargar los equipos: " . $e->getMessage();
}

// Manejar envío del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener equipo seleccionado para eliminar
    $selectedTeam = trim($_POST["team_name"] ?? "");
    
    // Validar que se haya seleccionado un equipo
    if (empty($selectedTeam)) {
        $message = "Por favor, selecciona un equipo para eliminar.";
    } else {
        try {
            // Verificar si el equipo existe para este usuario
            if (!$teamModel->teamExists($selectedTeam, $userId)) {
                $message = "El equipo seleccionado no existe o no tienes permisos para eliminarlo.";
            } else {
                // Eliminar el equipo
                if ($teamModel->deleteTeam($selectedTeam, $userId)) {
                    $message = "Equipo '$selectedTeam' eliminado correctamente.";
                    // Actualizar la lista de equipos después de la eliminación
                    $teams = $teamModel->getTeamsByUser($userId);
                } else {
                    $message = "Error al eliminar el equipo. Inténtalo de nuevo.";
                }
            }
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Incluir la vista
require_once "../views/delete_teamview.php";
?>