<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Eliminar equipo"; 
        require_once 'partials/head.php'; 
    ?>
    
    <body class="d-flex flex-column h-100">

        <?php require_once 'partials/navbar.php'; ?>

        <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
            <h1>Eliminar equipo</h1>
            <br>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <select name="team_name" class="form-select mx-auto w-auto">
                        <option value="">Seleccione equipo</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars($team) ?>" <?= (($selectedTeam ?? '') === $team) ? 'selected' : '' ?>><?= htmlspecialchars($team) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </main>

        <?php require_once 'partials/footer.php'; ?>

    </body>
</html>