<?php
class Medidas_Tendencia_Central {
    private array $numeros;
    private int $n;

    public function __construct(int $n, array $numeros) {
        $this->n = $n;
        $this->numeros = $numeros;
    }

    public function getN() {
        return $this->n;
    }

    public function setN(float $n) {
        $this->n = $n;
    }

    public function getNumeros() {
        return $this->numeros;
    }

    public function setNumeros(array $numeros) {
        $this->numeros = $numeros;
    }

    public function calcularMedia() {
        $suma = array_sum($this->numeros);
        return $suma / $this->n;
    }

    public function calcularMediana() {
        sort($this->numeros);
        $mid = floor($this->n / 2);
        if ($this->n % 2 == 0) {
            return ($this->numeros[$mid - 1] + $this->numeros[$mid]) / 2;
        } else {
            return $this->numeros[$mid];
        }
    }

    public function calcularModa() {
        $frecuencia = [];
        foreach ($this->numeros as $num) {
            $key = (string) $num;
            if (!isset($frecuencia[$key])) {
                $frecuencia[$key] = 0;
            }
            $frecuencia[$key]++;
        }
        $maxFreq = max($frecuencia);
        if ($maxFreq == 1) {
            return [];
        }
        $moda = array_keys($frecuencia, $maxFreq);
        return $moda;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medidas de Tendencia Central</title>
    <link rel="stylesheet" href="CSS\mtc_num_reales.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Medidas de Tendencia Central</h1>
            <form method="post">
                <div class="grupo">
                    <label for="n">Cantidad de números:</label>
                    <input type="number" id="n" name="n" min="1" required>
                </div>
                <div class="grupo">
                    <label for="numeros">Ingrese los números separados por comas:</label>
                    <input type="text" id="numeros" name="numeros" required>
                </div>
                <button type="submit" class="btn">Calcular</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $n = isset($_POST["n"]) ? (int)$_POST["n"] : 0;
                $numeros = isset($_POST["numeros"]) ? array_map('floatval', explode(',', $_POST["numeros"])) : [];

                if (count($numeros) !== $n) {
                    echo "<div class='error'>El número de valores ingresados no coincide con la cantidad especificada.</div>";
                } else {
                    $medidas = new Medidas_Tendencia_Central($n, $numeros);
                    echo "<div class='resultado'>";
                    echo "<p><strong>Media:</strong> " . $medidas->calcularMedia() . "</p>";
                    echo "<p><strong>Mediana:</strong> " . $medidas->calcularMediana() . "</p>";
                    $moda = $medidas->calcularModa();
                    if (empty($moda)) {
                        echo "<p><strong>Moda:</strong> No hay moda</p>";
                    } else {
                        echo "<p><strong>Moda:</strong> " . implode(', ', $moda) . "</p>";
                    }
                    echo "</div>";
                }
            }
            ?>
            <a href="index.php" class="btn-regresar">Regresar al Menú</a>
        </div>
    </div>