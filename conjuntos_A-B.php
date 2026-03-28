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
    <title>Conjuntos A y B</title>
</head>
<body>
    <h1>Conjuntos A y B</h1>
    <form method="post">
        <label for="conjuntoA">Conjunto A (separado por comas):</label>
        <input type="text" id="conjuntoA" name="conjuntoA" required>
        <br><br>
        <label for="conjuntoB">Conjunto B (separado por comas):</label>
        <input type="text" id="conjuntoB" name="conjuntoB" required>
        <br><br>
        <button type="submit">Calcular</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conjuntoA = array_map('trim', explode(',', $_POST["conjuntoA"]));
        $conjuntoB = array_map('trim', explode(',', $_POST["conjuntoB"]));
        $conjuntos = new Conjuntos_AB($conjuntoA, $conjuntoB);
        echo "<p>Unión: " . implode(', ', $conjuntos->union()) . "</p>";
        echo "<p>Intersección: " . implode(', ', $conjuntos->interseccion()) . "</p>";
        echo "<p>Diferencia (A - B): " . implode(', ', $conjuntos->diferencia()) . "</p>";
    }
    ?>
</body>
</html>