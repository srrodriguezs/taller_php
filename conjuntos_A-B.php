<?php
class Conjuntos_AB {
    private array $conjuntoA;
    private array $conjuntoB;

    public function __construct(array $conjuntoA, array $conjuntoB) {
        $this->conjuntoA = $conjuntoA;
        $this->conjuntoB = $conjuntoB;
    }

    public function getConjuntoA() {
        return $this->conjuntoA;
    }

    public function setConjuntoA(array $conjuntoA) {
        $this->conjuntoA = $conjuntoA;
    }

    public function getConjuntoB() {
        return $this->conjuntoB;
    }

    public function setConjuntoB(array $conjuntoB) {
        $this->conjuntoB = $conjuntoB;
    }

    public function union() {
        return array_values(array_unique(array_merge($this->conjuntoA, $this->conjuntoB)));
    }

    public function interseccion() {
        if (array_values(array_intersect($this->conjuntoA, $this->conjuntoB)) !== []) {
            return array_values(array_intersect($this->conjuntoA, $this->conjuntoB));
        } else {
            return ["No hay elementos comunes"];
        }
    }

    public function diferencia() {
        return array_values(array_diff($this->conjuntoA, $this->conjuntoB));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conjuntos A y B</title>
    <link rel="stylesheet" href="CSS\conjuntos_A-B.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Conjuntos A y B</h1>
            <form method="post">
                <div class="grupo">
                    <label for="conjuntoA">Conjunto A (separado por comas):</label>
                    <input type="text" id="conjuntoA" name="conjuntoA" required>
                </div>
                <div class="grupo">
                    <label for="conjuntoB">Conjunto B (separado por comas):</label>
                    <input type="text" id="conjuntoB" name="conjuntoB" required>
                </div>
                <button type="submit" class="btn">Calcular</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $conjuntoA = array_map('trim', explode(',', $_POST["conjuntoA"]));
                $conjuntoB = array_map('trim', explode(',', $_POST["conjuntoB"]));
                $conjuntos = new Conjuntos_AB($conjuntoA, $conjuntoB);
                echo "<div class='resultado'>";
                echo "<p><strong>Unión:</strong> " . implode(', ', $conjuntos->union()) . "</p>";
                echo "<p><strong>Intersección:</strong> " . implode(', ', $conjuntos->interseccion()) . "</p>";
                echo "<p><strong>Diferencia (A - B):</strong> " . implode(', ', $conjuntos->diferencia()) . "</p>";
                echo "</div>";
            }
            ?>
            <a href="index.php" class="btn-regresar">Regresar al Menú</a>
        </div>
    </div>