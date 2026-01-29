<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/insert_matchmodel.php";

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

// Inicializar modelo 
$matchModel = new InsertMatchModel($mysqli);

// Obtener equipos del usuario para el menú desplegable
try {
    $teams = $matchModel->getTeamsByUser($userId);
} catch (Exception $e) {
    $message = "Error al cargar los equipos: " . $e->getMessage();
}

// Manejar envío del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario
    $homeTeam = trim($_POST["home_team"] ?? "");
    $awayTeam = trim($_POST["away_team"] ?? "");
    $homeScore = $_POST["home_score"] ?? "";
    $awayScore = $_POST["away_score"] ?? "";
    
    // Validar datos de entrada
    if (!$homeTeam || !$awayTeam) {
        $message = "Por favor, completa todos los campos.";
    } elseif ($homeTeam === $awayTeam) {
        // Verificar que los equipos local y visitante sean diferentes
        $message = "Los equipos local y visitante no pueden ser el mismo.";
    } elseif (!is_numeric($homeScore) || !is_numeric($awayScore)) {
        // Verificar que los marcadores sean números válidos
        $message = "Los marcadores deben ser números válidos.";
    } elseif ($homeScore < 0 || $awayScore < 0) {
        // Verificar que los marcadores no sean negativos
        $message = "Los marcadores no pueden ser negativos.";
    } else {
        try {
            // Registrar el partido
            $message = $matchModel->registerMatch($homeTeam, $awayTeam, (int)$homeScore, (int)$awayScore, $userId);
            // Actualizar lista de equipos después del registro del partido
            $teams = $matchModel->getTeamsByUser($userId);
        } catch (Exception $e) {
            // Registrar error y mostrar mensaje 
            error_log("Match registration error: " . $e->getMessage());
            $message = "Error al registrar el partido. Inténtalo de nuevo.";
        }
    }
}

// Incluir vista
require_once "../views/insert_matchview.php";
?>