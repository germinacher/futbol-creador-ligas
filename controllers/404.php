<?php
    // Establecer código de respuesta HTTP a 404 Not Found
    http_response_code(404);

    // Incluir la vista de error 404
    require_once '../views/404view.php';
?>