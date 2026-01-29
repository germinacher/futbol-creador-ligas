<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Registrar partido"; 
        require_once 'partials/head.php'; 
    ?>

    <body class="d-flex flex-column h-100">

        <?php require_once 'partials/navbar.php'; ?>

        <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
            <h1>Registrar partido</h1>
            <br>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <select name="home_team" class="form-select mx-auto w-auto">
                        <option value="" disabled <?= empty($homeTeam ?? '') ? 'selected' : '' ?>>Equipo local</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars($team) ?>" <?= (($homeTeam ?? '') === $team) ? 'selected' : '' ?>><?= htmlspecialchars($team) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label><h6>Goles</h6></label>
                    <input type="number" min="0" max="99" name="home_score" class="form-control mx-auto w-auto" value="<?= htmlspecialchars($homeScore ?? '') ?>">
                </div>
                <h2>VS</h2>
                <div class="mb-3">
                    <select name="away_team" class="form-select mx-auto w-auto">
                        <option value="" disabled <?= empty($awayTeam ?? '') ? 'selected' : '' ?>>Equipo visitante</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= htmlspecialchars($team) ?>" <?= (($awayTeam ?? '') === $team) ? 'selected' : '' ?>><?= htmlspecialchars($team) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label><h6>Goles</h6></label>
                    <input type="number" min="0" max="99" name="away_score" class="form-control mx-auto w-auto" value="<?= htmlspecialchars($awayScore ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Registrar partido</button>
            </form>
        </main>

        <?php require_once 'partials/footer.php'; ?>
                        
    </body>
</html>