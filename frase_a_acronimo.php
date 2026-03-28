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

class Main {
    public static function main() {
        $frase = "Hola Mundo";
        $acronimo = new FraseAcronym($frase);
        echo "El acrónimo de '$frase' es: " . $acronimo->getAcronimo();
    }
}

Main::main();
?>