<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Eliminar todo"; 
        require_once 'partials/head.php'; 
    ?>
    
    <body class="d-flex flex-column h-100">

        <?php require_once 'partials/navbar.php'; ?>

        <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
            <h1>Eliminar liga y todos sus datos</h1>
            <br>
            <?php if ($message): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php else: ?>
                <h2 style="color: red" class="text-danger">Esta acción eliminará todos los equipos y el historial de partidos.</h2>
                <h3>Haz clic en el botón para confirmar.</h3>
                <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar toda la liga?');">
                    <button type="submit" class="btn btn-danger">Eliminar todo</button>
                </form>
            <?php endif; ?>
        </main>

        <?php require_once 'partials/footer.php'; ?>

    </body>
</html>

