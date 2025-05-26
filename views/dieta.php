<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dieta Generada</title>
    <style>
        body { font-family: Arial; margin: 2rem; }
        .comida { margin-bottom: 2rem; }
        h2, h3, h4 { margin-bottom: 0.5rem; }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_SESSION['dieta_generada'])): ?>
        <h2>Tu Dieta Generada</h2>
        <p><?= htmlspecialchars($_SESSION['dieta_generada']['descripcion']) ?></p>

        <?php foreach ($_SESSION['dieta_generada']['comidas'] as $nombreComida => $datos): ?>
            <div class="comida">
                <h3><?= htmlspecialchars($nombreComida) ?> (<?= $datos['total_calorias'] ?> kcal)</h3>
                <?php foreach ($datos['platos'] as $plato): ?>
                    <h4><?= htmlspecialchars($plato['nombre']) ?></h4>
                    <ul>
                        <?php foreach ($plato['ingredientes'] as $ingrediente): ?>
                            <li>
                                <?= htmlspecialchars($ingrediente['nombre']) ?> -
                                <?= htmlspecialchars($ingrediente['nutriente']) ?> -
                                <?= htmlspecialchars($ingrediente['valorCalorico']) ?> kcal -
                                <?= htmlspecialchars($ingrediente['peso']) ?> (<?= htmlspecialchars($ingrediente['medida']) ?>) -
                                Alérgenos: <?= htmlspecialchars($ingrediente['alergenos']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <form action="../controllers/generarPDF.php" method="post">
        <button type="submit" class="btn">Descargar en PDF</button>
    </form>

    <?php else: ?>
        <p>No se ha generado ninguna dieta. Vuelve al formulario y completa los datos.</p>
    <?php endif; ?>
</div>

</body>
</html>
