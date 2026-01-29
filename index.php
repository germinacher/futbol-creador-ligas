<?php
// Iniciar sesión del usuario
    session_start();

    if (isset($_SESSION["user_id"])) {
        // Obtener ID del usuario de la sesión
        $userId = $_SESSION["user_id"];
        $standings = [];
    } 

    require_once 'views/indexview.php';
?>


