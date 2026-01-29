<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "sesionesfutbol";

// Crear conexión a la base de datos
$mysqli = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($mysqli->connect_errno) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    die("Error de conexión a la base de datos. Por favor, inténtalo más tarde.");
}

// Establecer codificación de caracteres a UTF-8
$mysqli->set_charset("utf8mb4");
?>
