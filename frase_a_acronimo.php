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
        $palabras = preg_split('/[\s\-_]+/', $frase);
        $acronimo = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $acronimo .= strtoupper($palabra[0]);
            }
        }
        return $acronimo;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frase a Acronimo</title>
    <link rel="stylesheet" href="CSS\frase_a_acronimo.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Frase a Acrónimo</h1>
            <form method="post">
                <div class="grupo">
                    <label for="frase">Ingrese una frase:</label>
                    <input type="text" id="frase" name="frase" required>
                </div>
                <button type="submit" class="btn">Convertir a Acrónimo</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $frase = $_POST["frase"];
                $acronimo = new FraseAcronym($frase);
                echo "<div class='resultado'>El acrónimo de '$frase' es: " . $acronimo->getAcronimo() . "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>