<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Página no encontrada"; 
        require_once 'partials/head.php'; 
    ?>
    
    <body class="d-flex flex-column h-100">

        <main class="flex-grow-1 container-fluid py-5 text-center">
            <p class="lead">La página que buscas no existe o fue removida.</p>
            <div>
                <img src="/futbol_php/assets/images/pelota_error404.jpg" alt="Error 404" width="300px">
            </div>
            <a href="/futbol_php/index.php" class="btn btn-primary">Volver al inicio</a>
        </main>
        
        <?php require_once 'partials/footer.php'; ?>
    </body>
</html>