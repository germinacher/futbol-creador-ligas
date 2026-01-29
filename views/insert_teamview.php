<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Agregar equipo"; 
        require_once 'partials/head.php'; 
    ?>
    
    <body class="d-flex flex-column h-100">

        <?php require_once 'partials/navbar.php'; ?>

        <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
            <h1>Agregar equipo</h1>
            <br>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="team_name" class="form-control mx-auto w-auto" placeholder="Nombre del equipo" autofocus autocomplete="off" value="<?= htmlspecialchars($teamName ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </main>

        <?php require_once 'partials/footer.php'; ?>

    </body>
</html>