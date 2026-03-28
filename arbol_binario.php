<?php
class Arbol_Binario {
    private $valor;
    private $izquierdo;
    private $derecho;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->izquierdo = null;
        $this->derecho = null;
    }

    public function insertar($valor) {
        if ($valor < $this->valor) {
            if ($this->izquierdo === null) {
                $this->izquierdo = new Arbol_Binario($valor);
            } else {
                $this->izquierdo->insertar($valor);
            }
        } else {
            if ($this->derecho === null) {
                $this->derecho = new Arbol_Binario($valor);
            } else {
                $this->derecho->insertar($valor);
            }
        }
    }

    public function preOrden() {
        echo $this->valor . " ";
        if ($this->izquierdo !== null) {
            $this->izquierdo->preOrden();
        }
        if ($this->derecho !== null) {
            $this->derecho->preOrden();
        }
    }

    public function inOrden() {
        if ($this->izquierdo !== null) {
            $this->izquierdo->inOrden();
        }
        echo $this->valor . " ";
        if ($this->derecho !== null) {
            $this->derecho->inOrden();
        }
    }

    public function postOrden() {
        if ($this->izquierdo !== null) {
            $this->izquierdo->postOrden();
        }
        if ($this->derecho !== null) {
            $this->derecho->postOrden();
        }
        echo $this->valor . " ";
    }

    public function salida() {
        echo "Valor: " . $this->valor . "<br>";
        if ($this->izquierdo !== null) {
            echo "Hijo Izquierdo de " . $this->valor . ":<br>";
            $this->izquierdo->salida();
        }
        if ($this->derecho !== null) {
            echo "Hijo Derecho de " . $this->valor . ":<br>";
            $this->derecho->salida();
        }
    }

    public static function reconstruirDesdePreIn($pre, $in) {
        if (empty($pre) || empty($in)) return null;
        $rootVal = array_shift($pre);
        $rootIndex = array_search($rootVal, $in);
        if ($rootIndex === false) return null;
        $leftIn = array_slice($in, 0, $rootIndex);
        $rightIn = array_slice($in, $rootIndex + 1);
        $leftPre = array_slice($pre, 0, $rootIndex);
        $rightPre = array_slice($pre, $rootIndex);
        $root = new Arbol_Binario($rootVal);
        $root->izquierdo = self::reconstruirDesdePreIn($leftPre, $leftIn);
        $root->derecho = self::reconstruirDesdePreIn($rightPre, $rightIn);
        return $root;
    }

    public static function reconstruirDesdeInPost($in, $post) {
        if (empty($in) || empty($post)) return null;
        $rootVal = array_pop($post);
        $rootIndex = array_search($rootVal, $in);
        if ($rootIndex === false) return null;
        $leftIn = array_slice($in, 0, $rootIndex);
        $rightIn = array_slice($in, $rootIndex + 1);
        $leftPost = array_slice($post, 0, $rootIndex);
        $rightPost = array_slice($post, $rootIndex);
        $root = new Arbol_Binario($rootVal);
        $root->izquierdo = self::reconstruirDesdeInPost($leftIn, $leftPost);
        $root->derecho = self::reconstruirDesdeInPost($rightIn, $rightPost);
        return $root;
    }

    public function toArray() {
        $arr = ['value' => $this->valor];
        $arr['left'] = $this->izquierdo ? $this->izquierdo->toArray() : null;
        $arr['right'] = $this->derecho ? $this->derecho->toArray() : null;
        return $arr;
    }

    public function imprimirArbol($prefix = '', $isLeft = true) {
        $result = $prefix;
        if ($isLeft) {
            $result .= '├── ';
        } else {
            $result .= '└── ';
        }
        $result .= $this->valor . "\n";

        $newPrefix = $prefix;
        if ($isLeft) {
            $newPrefix .= '│   ';
        } else {
            $newPrefix .= '    ';
        }

        if ($this->izquierdo) {
            $result .= $this->izquierdo->imprimirArbol($newPrefix, true);
        }
        if ($this->derecho) {
            $result .= $this->derecho->imprimirArbol($newPrefix, false);
        }

        return $result;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario desde Recorridos</title>
    <link rel="stylesheet" href="CSS\arbol_binario.css">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>Construir Árbol Binario desde Recorridos</h1>
            <form method="post">
                <fieldset>
                    <legend>Recorrido 1</legend>
                    <div class="grupo">
                        <label>Tipo:</label>
                        <select name="tipo1" onchange="updatePlaceholder(this, 'secuencia1')">
                            <option value="pre">Preorden</option>
                            <option value="in">Inorden</option>
                            <option value="post">Postorden</option>
                        </select>
                    </div>
                    <div class="grupo">
                        <label>Secuencia:</label>
                        <input type="text" name="secuencia1" placeholder="Ej: Raíz,Izq,Der (A,B,D,E,C)" size="40" required>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Recorrido 2</legend>
                    <div class="grupo">
                        <label>Tipo:</label>
                        <select name="tipo2" onchange="updatePlaceholder(this, 'secuencia2')">
                            <option value="pre">Preorden</option>
                            <option value="in" selected>Inorden</option>
                            <option value="post">Postorden</option>
                        </select>
                    </div>
                    <div class="grupo">
                        <label>Secuencia:</label>
                        <input type="text" name="secuencia2" placeholder="Ej: Izq,Raíz,Der (D,B,E,A,C)" size="40" required>
                    </div>
                </fieldset>
                <button type="submit">Construir Árbol</button>
            </form>

    <?php
    $error = "";
    $arbol = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipo1 = $_POST['tipo1'] ?? '';
        $tipo2 = $_POST['tipo2'] ?? '';
        $sec1 = trim($_POST['secuencia1'] ?? '');
        $sec2 = trim($_POST['secuencia2'] ?? '');

        if (empty($sec1) || empty($sec2)) {
            $error = "Debe ingresar ambas secuencias.";
        } else {
            $arr1 = preg_split('/[\s,]+/', $sec1);
            $arr2 = preg_split('/[\s,]+/', $sec2);
            $arr1 = array_values(array_filter($arr1));
            $arr2 = array_values(array_filter($arr2));

            if (count($arr1) !== count($arr2)) {
                $error = "Los recorridos deben tener la misma cantidad de elementos.";
            } else {
                $set1 = array_unique($arr1);
                $set2 = array_unique($arr2);
                sort($set1);
                sort($set2);
                if ($set1 != $set2) {
                    $error = "Los elementos de los recorridos no coinciden.";
                } else {
                    $combinacion = $tipo1 . '-' . $tipo2;
                    if ($combinacion == 'pre-in' || $combinacion == 'in-pre') {
                        $pre = ($tipo1 == 'pre') ? $arr1 : $arr2;
                        $in  = ($tipo1 == 'in')  ? $arr1 : $arr2;
                        $arbol = Arbol_Binario::reconstruirDesdePreIn($pre, $in);
                    } elseif ($combinacion == 'in-post' || $combinacion == 'post-in') {
                        $in  = ($tipo1 == 'in')  ? $arr1 : $arr2;
                        $post = ($tipo1 == 'post') ? $arr1 : $arr2;
                        $arbol = Arbol_Binario::reconstruirDesdeInPost($in, $post);
                    } else {
                        $error = "Combinación no soportada. Solo se acepta Preorden+Inorden o Inorden+Postorden.";
                    }

                    if ($arbol === null) {
                        $error = "No se pudo reconstruir el árbol. Verifique que los recorridos sean consistentes.";
                    }
                }
            }
        }
    }

    if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($arbol !== null): ?>
        <div class="recorridos">
            <h3>Recorridos del árbol reconstruido:</h3>
            <p><strong>Preorden:</strong> <?php ob_start(); $arbol->preOrden(); echo rtrim(ob_get_clean()); ?></p>
            <p><strong>Inorden:</strong> <?php ob_start(); $arbol->inOrden(); echo rtrim(ob_get_clean()); ?></p>
            <p><strong>Postorden:</strong> <?php ob_start(); $arbol->postOrden(); echo rtrim(ob_get_clean()); ?></p>
        </div>

        <h3>Representación del árbol:</h3>
        <pre><?php echo $arbol->imprimirArbol(); ?></pre>
    <?php endif; ?>
    <a href="index.php" class="btn-regresar">Regresar al Menú</a>
</body>
<script>
function updatePlaceholder(select, inputName) {
    var input = document.querySelector('input[name="' + inputName + '"]');
    var type = select.value;
    if (type == 'pre') {
        input.placeholder = 'Ej: Raíz,Izq,Der (A,B,D,E,C)';
    } else if (type == 'in') {
        input.placeholder = 'Ej: Izq,Raíz,Der (D,B,E,A,C)';
    } else if (type == 'post') {
        input.placeholder = 'Ej: Izq,Der,Raíz (D,E,B,C,A)';
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updatePlaceholder(document.querySelector('select[name="tipo1"]'), 'secuencia1');
    updatePlaceholder(document.querySelector('select[name="tipo2"]'), 'secuencia2');
});
</script>
</html>
