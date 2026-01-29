<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/matchesmodel.php";

// Iniciar sesión del usuario
session_start();

// Redirigir si el usuario no ha iniciado sesión
if (!isset($_SESSION["user_id"])) {
    header("Location: logincontroller.php");
    exit();
}

// Obtener ID del usuario de la sesión
$userId = $_SESSION["user_id"];
$matches = [];
$errorMessage = "";

// Inicializar modelo
$matchModel = new MatchesModel($mysqli);

// Obtener partidos del usuario
try {
    $matches = $matchModel->getMatchesByUser($userId);
} catch (Exception $e) {
    // Registrar error y mostrar mensaje 
    error_log("Error loading matches: " . $e->getMessage());
    $errorMessage = "Error al cargar los partidos. Inténtalo de nuevo.";
}

// Incluir vista
require_once "../views/matchesview.php";
?>