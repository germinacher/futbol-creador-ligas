<?php
// Incluir archivos necesarios
require_once "../includes/db.php";
require_once "../models/delete_allmodel.php";

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

// Inicializar modelo
$leagueModel = new DeleteAllModel($mysqli);

// Manejar envío del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Reiniciar toda la información de la liga para el usuario
        $leagueModel->resetLeagueForUser($userId);
        $message = "Información de liga eliminada correctamente.";
    } catch (Exception $e) {
        // Registrar error y mostrar mensaje
        error_log("League reset error: " . $e->getMessage());
        $message = "Error al eliminar la información de la liga. Inténtalo de nuevo.";
    }
}

// Incluir vista 
require_once "../views/delete_allview.php";
?>