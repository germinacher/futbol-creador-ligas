<!DOCTYPE html>
<html class="h-100">
<?php 
        $titulo = "Iniciar sesión"; 
        require_once __DIR__ . '/../partials/head.php'; 
?>
<body class="d-flex flex-column h-100">

    <?php if (!isset($_SESSION["user_id"])): ?>
        <nav class="bg-light border navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">
                    <span class="blue">L</span><span class="red">I</span><span class="yellow">G</span><span class="green">A</span> <span class="red">Futbol</span>
                </a>
            </div>
        </nav>
    <?php endif; ?>

    <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
        <h1>Iniciar sesión</h1>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control mx-auto w-auto" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control mx-auto w-auto" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <br>
        <a href="/futbol_php/controllers/registercontroller.php">
            <button class="btn btn-primary">¿No tienes cuenta? Regístrate</button>
        </a>
    </main>

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
