<?php
class Fibonacci {
    private int $n;

    public function __construct(int $n) {
        $this->n = $n;
    }

    public function getFibonacci() {
        return self::generarFibonacci($this->n);
    }

    public function setN(int $n) {
        $this->n = $n;
    }

    public static function generarFibonacci($n) {
        $serie = [];
        if ($n >= 1) $serie[] = 0;
        if ($n >= 2) $serie[] = 1;
        for ($i = 2; $i < $n; $i++) {
            $serie[] = $serie[$i-1] + $serie[$i-2];
        }
        return $serie;
    }

    public static function calcularFactorial($n) {
        $resultado = 1;
        for ($i = 2; $i <= $n; $i++) {
            $resultado *= $i;
        }
        return $resultado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucesión de Fibonacci</title>
    <link rel="stylesheet" href="CSS\fibonacci_y_factorial.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Sucesión de Fibonacci y Factorial</h1>
            <form method="post">
                <div class="grupo">
                    <label>Número:</label>
                    <input type="number" name="numero" min="0" required>
                </div>
                <div class="grupo">
                    <label>Operación:</label>
                    <select name="operacion">
                        <option value="fibonacci">Sucesión de Fibonacci</option>
                        <option value="factorial">Factorial</option>
                    </select>
                </div>
                <button type="submit" class="btn">Calcular</button>
            </form>
            <?php
            $resultado = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $numero = isset($_POST["numero"]) ? (int)$_POST["numero"] : 0;
                $operacion = $_POST["operacion"] ?? "";

                if ($numero < 0) {
                    $resultado = "El número debe ser mayor o igual a 0.";
                } else {
                    if ($operacion == "fibonacci") {
                        $serie = Fibonacci::generarFibonacci($numero);
                        $resultado = "Serie de Fibonacci (primeros $numero términos): " . implode(", ", $serie);
                    } elseif ($operacion == "factorial") {
                        $fact = Fibonacci::calcularFactorial($numero);
                        $resultado = "Factorial de $numero: $fact";
                    } else {
                        $resultado = "Operación no válida.";
                    }
                }
            }
            if ($resultado) {
                echo "<div class='resultado'>$resultado</div>";
            }
            ?>
            <a href="index.php" class="btn-regresar">Regresar al Menú</a>
        </div>
    </div>