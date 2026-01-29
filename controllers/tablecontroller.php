<?php
// Incluir archivo de conexión a la base de datos
require_once "../includes/db.php";
// Incluir el modelo
require_once "../models/tablemodel.php";

// Iniciar sesión del usuario
session_start();

// Redirigir si el usuario no ha iniciado sesión
if (!isset($_SESSION["user_id"])) {
    header("Location: logincontroller.php");
    exit();
}

// Obtener ID del usuario de la sesión
$userId = $_SESSION["user_id"];
$standings = [];

try {
    // Crear instancia del modelo y obtener la tabla de posiciones
    $tableModel = new TableModel($mysqli);
    $standings = $tableModel->getStandings($userId);
    
} catch (Exception $e) {
    // Registrar error en el log y mostrar mensaje al usuario
    error_log("Database error in table controller: " . $e->getMessage());
    $errorMessage = "Error al cargar la tabla de posiciones. Inténtalo de nuevo.";
}

// Incluir la vista
require "../views/tableview.php";
?>