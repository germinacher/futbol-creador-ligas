<!DOCTYPE html>
<html class="h-100">
    <?php 
        $titulo = "Tabla de posiciones"; 
        require_once 'partials/head.php'; 
    ?>

    <body class="d-flex flex-column h-100">

        <?php 
            require_once 'partials/navbar.php'; 
        ?>

        <main class="flex-grow-1 container-fluid py-5 text-center" style="background-color: #2e944b;">
            <h1 style="color:white">Crea tu propia LIGA</h1>
            <h2>Tabla de posiciones</h2>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Equipos</th>
                            <th scope="col">Jugados</th>
                            <th scope="col">Ganados</th>
                            <th scope="col">Empates</th>
                            <th scope="col">Perdidos</th>
                            <th scope="col">GF&#45;GC</th>
                            <th scope="col">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($standings) && is_array($standings) && !empty($standings)): ?>
                            <?php $pos = 1; ?>
                            <?php foreach ($standings as $row): ?>
                                <tr>
                                    <td><?= $pos ?></td>
                                    <td><?= htmlspecialchars($row['team']) ?></td>
                                    <td><?= $row['played'] ?></td>
                                    <td><?= $row['win'] ?></td>
                                    <td><?= $row['draw'] ?></td>
                                    <td><?= $row['defeat'] ?></td>
                                    <td><?= $row['gf'] ?>&#45;<?= $row['gc'] ?></td>
                                    <td><?= $row['points'] ?></td>
                                </tr>
                                <?php $pos++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay equipos registrados aún.</td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-center"><a href="/futbol_php/controllers/insert_teamcontroller.php" class="btn btn-primary">Agregar equipo</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </main>

        <?php require_once 'partials/footer.php'; ?>

    </body>
</html>