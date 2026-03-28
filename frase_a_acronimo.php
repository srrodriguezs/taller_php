<?php
class FraseAcronym {
    private String $frase;

    public function __construct(String $frase) {
        $this->frase = $frase;
    }

    public function getAcronimo() {
        return self::frase_a_acronimo($this->frase);
    }

    public function setFrase(String $frase) {
        $this->frase = $frase;
    }


    private static function frase_a_acronimo($frase) {
        $palabras = explode(' ', $frase);
        $acronimo = '';
        foreach ($palabras as $palabra) {
            $acronimo .= strtoupper($palabra[0]);
        }
        return $acronimo;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Frase a Acronimo</title>
</head>
<body>
    <h1>Frase a Acrónimo</h1>
    <form method="post">
        <label for="frase">Ingrese una frase:</label>
        <input type="text" id="frase" name="frase" required>
        <button type="submit">Convertir a Acrónimo</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $frase = $_POST["frase"];
        $acronimo = new FraseAcronym($frase);
        echo "<p>El acrónimo de '$frase' es: " . $acronimo->getAcronimo() . "</p>";
    }
    ?>
</body>
</html>