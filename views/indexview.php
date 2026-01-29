<!DOCTYPE html>
<html class="h-100">
    <?php 

        $titulo = "Inicio"; 
        require_once 'partials/head.php';      
        
    ?>
    <body class="d-flex flex-column h-100">

        <?php if (isset($_SESSION["user_id"])): ?>
            <?php require_once 'partials/navbar.php'; ?>
        <?php else: ?>
            <nav class="bg-light border navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <span class="blue">L</span><span class="red">I</span><span class="yellow">G</span><span class="green">A</span> <span class="red">Futbol</span>
                    </a>
                </div>
            </nav>
        <?php endif; ?>

        <main class="container-fluid py-5 text-center" style="background-image: url('assets/images/field.jpg'); background-size: cover; background-position: top; height: 700px;">
            <br>
            <h1 style="color: white">Bienvenido al lugar donde tus torneos pueden cobrar vida</h1>
            <br>

            <?php if (!isset($_SESSION["user_id"])): ?>
                <div class="container-fluid" style="margin-top: 50px;">
                    <a href="/futbol_php/controllers/logincontroller.php" style="text-decoration: none;">
                        <button class="btn btn-primary">Iniciar sesión</button>
                    </a>
                    <a href="/futbol_php/controllers/registercontroller.php" style="text-decoration: none;">
                        <button class="btn btn-primary">Crear cuenta</button>
                    </a>                  
                </div>
            <?php else: ?>
                <div class="container-fluid">
                    <br>
                    <a href="/futbol_php/controllers/tablecontroller.php">
                        <button class="btn btn-primary">Toca aquí para iniciar tu liga</button>
                    </a>
                </div>
            <?php endif; ?>
            
        </main>

        <?php require_once 'partials/footer.php'; ?>

    </body>
</html>