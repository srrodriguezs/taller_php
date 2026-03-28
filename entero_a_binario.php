<?php
class Conversion {
    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero(int $numero) {
        $this->numero = $numero;
    }

    public function convertirABinario() {
        return decbin($this->numero);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversión de Entero a Binario</title>
    <link rel="stylesheet" href="CSS\entero_a_binario.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Conversión de Entero a Binario</h1>
            <form method="post">
                <div class="grupo">
                    <label for="numero">Ingrese un número entero:</label>
                    <input type="number" id="numero" name="numero" required>
                </div>
                <button type="submit" class="btn">Convertir a Binario</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $numero = (int)$_POST["numero"];
                $conversion = new Conversion($numero);
                echo "<div class='resultado'>El número entero '$numero' en binario es: " . $conversion->convertirABinario() . "</div>";
            }
            ?>
        </div>
    </div>