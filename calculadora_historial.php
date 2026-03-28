<?php
session_start();

// Inicializar historial si no existe
if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

// Procesar operación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'limpiar_historial') {
            $_SESSION['historial'] = [];
        } elseif ($_POST['action'] === 'calcular') {
            $num1 = floatval($_POST['num1'] ?? 0);
            $num2 = floatval($_POST['num2'] ?? 0);
            $operacion = $_POST['operacion'] ?? '';
            
            $resultado = 0;
            $valido = true;
            
            switch ($operacion) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;
                case '-':
                    $resultado = $num1 - $num2;
                    break;
                case '*':
                    $resultado = $num1 * $num2;
                    break;
                case '/':
                    if ($num2 != 0) {
                        $resultado = $num1 / $num2;
                    } else {
                        $valido = false;
                    }
                    break;
                case '%':
                    $resultado = $num1 % $num2;
                    break;
                default:
                    $valido = false;
            }
            
            if ($valido) {
                $operacion_texto = "$num1 $operacion $num2 = $resultado";
                array_unshift($_SESSION['historial'], $operacion_texto);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora con Historial</title>
    <link rel="stylesheet" href="CSS\calculadora_historial.css">
</head>
<body>
    <div class="contenedor">
        <div class="calculadora">
            <h1>Calculadora</h1>
            <form method="POST">
                <div class="grupo">
                    <label>Primer número:</label>
                    <input type="number" name="num1" step="0.01" required>
                </div>
                <div class="grupo">
                    <label>Operación:</label>
                    <select name="operacion" required>
                        <option value="">Selecciona operación</option>
                        <option value="+">Suma (+)</option>
                        <option value="-">Resta (-)</option>
                        <option value="*">Multiplicación (*)</option>
                        <option value="/">División (/)</option>
                        <option value="%">Porcentaje (%)</option>
                    </select>
                </div>
                <div class="grupo">
                    <label>Segundo número:</label>
                    <input type="number" name="num2" step="0.01" required>
                </div>
                <input type="hidden" name="action" value="calcular">
                <button type="submit" class="btn-calcular">Calcular</button>
            </form>
        </div>

        <div class="historial">
            <h2>Historial</h2>
            <?php if (empty($_SESSION['historial'])): ?>
                <p class="no-historial">No hay operaciones aún</p>
            <?php else: ?>
                <?php foreach ($_SESSION['historial'] as $item): ?>
                    <div class="historial-item"><?php echo htmlspecialchars($item); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="contador">
                Total de operaciones: <?php echo count($_SESSION['historial']); ?>
            </div>
            <form method="POST" class="form-limpiar">
                <input type="hidden" name="action" value="limpiar_historial">
                <button type="submit" class="btn-limpiar">Borrar Historial</button>
            </form>
            <a href="index.php" class="btn-regresar">Regresar al Menú</a>
        </div>
    </div>
</body>
</html>