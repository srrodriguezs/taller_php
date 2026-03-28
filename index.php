<?php
$codigos = [
    'Frase a Acronimo' => 'frase_a_acronimo.php',
    'Sucesión Fibonacci o Factorial' => 'fibonacci_y_factorial.php',
    'Tendencias Centrales con Números Reales' => 'mtc_num_reales.php',
    'Conjuntos A y B' => 'conjuntos_A-B.php',
    'Entero a Binario' => 'entero_a_binario.php',
    'Árbol Binario' => 'arbol_binario.php',
    'Calculadora con Historial' => 'calculadora_historial.php',
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Taller PHP</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>📚 Menú - Taller PHP</h1>
            <div class="menu">
                <?php foreach ($codigos as $nombre => $archivo): ?>
                    <a href="<?php echo $archivo; ?>" class="menu-item"><?php echo $nombre; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>