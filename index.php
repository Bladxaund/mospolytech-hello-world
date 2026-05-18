<?php
// Backend: Проверка и вычисление выражения с помощью рекурсивных вызовов

// Рекурсивное вычисление выражений
function evaluateExpression($expr) {
    // Удаляем пробелы
    $expr = str_replace(' ', '', $expr);
    
    // Замена констант
    $expr = str_replace('π', 'M_PI', $expr);
    $expr = str_replace('e', 'M_E', $expr);
    
    // Обработка унарного минуса в начале и после скобок
    $expr = preg_replace('/^-/', '0-', $expr);
    $expr = preg_replace('/\(-/', '(0-', $expr);
    
    // Проверка на допустимые символы
    if (!preg_match('/^[0-9+\-*\/\(\)\.%!^√lnlogπe]+$/', $expr)) {
        return 'Error: Invalid characters';
    }
    
    // Вычисляем выражение
    $result = evalExpressionRecursive($expr);
    
    // Форматируем результат
    if (is_numeric($result) && !is_string($result)) {
        return round($result, 10);
    }
    
    return $result;
}

function evalExpressionRecursive($expr) {
    // Обработка факториала
    if (preg_match_all('/(\d+(?:\.\d+)?|\([^()]+\)|M_PI|M_E)!/', $expr, $matches)) {
        foreach ($matches[1] as $match) {
            $val = evalExpressionRecursive($match);
            if (is_numeric($val) && $val >= 0 && floor($val) == $val) {
                $fact = factorial($val);
                $expr = str_replace($match . '!', $fact, $expr);
            } else {
                return 'Error: Factorial requires non-negative integer';
            }
        }
    }
    
    // Обработка квадратного корня
    if (preg_match_all('/√\(([^()]+)\)/', $expr, $matches)) {
        foreach ($matches[1] as $match) {
            $val = evalExpressionRecursive($match);
            if (is_numeric($val) && $val >= 0) {
                $expr = str_replace('√(' . $match . ')', sqrt($val), $expr);
            } else {
                return 'Error: Square root of negative number';
            }
        }
    }
    
    // Обработка ln
    if (preg_match_all('/ln\(([^()]+)\)/', $expr, $matches)) {
        foreach ($matches[1] as $match) {
            $val = evalExpressionRecursive($match);
            if (is_numeric($val) && $val > 0) {
                $expr = str_replace('ln(' . $match . ')', log($val), $expr);
            } else {
                return 'Error: ln argument must be positive';
            }
        }
    }
    
    // Обработка log (десятичный)
    if (preg_match_all('/log\(([^()]+)\)/', $expr, $matches)) {
        foreach ($matches[1] as $match) {
            $val = evalExpressionRecursive($match);
            if (is_numeric($val) && $val > 0) {
                $expr = str_replace('log(' . $match . ')', log10($val), $expr);
            } else {
                return 'Error: log argument must be positive';
            }
        }
    }
    
    // Обработка возведения в степень
    while (preg_match('/([^+\-*\/\(\)]+)\^([^+\-*\/\(\)]+)/', $expr, $matches)) {
        $base = evalExpressionRecursive($matches[1]);
        $exp = evalExpressionRecursive($matches[2]);
        if (is_numeric($base) && is_numeric($exp)) {
            $result = pow($base, $exp);
            $expr = str_replace($matches[0], $result, $expr);
        } else {
            return 'Error: Invalid power operation';
        }
    }
    
    // Обработка скобок
    while (preg_match('/\(([^()]+)\)/', $expr, $matches)) {
        $inner = evalExpressionRecursive($matches[1]);
        $expr = str_replace('(' . $matches[1] . ')', $inner, $expr);
    }
    
    // Обработка умножения и деления
    while (preg_match('/([^+\-*\/]+)([\/\*])([^+\-*\/]+)/', $expr, $matches)) {
        $left = evalExpressionRecursive($matches[1]);
        $right = evalExpressionRecursive($matches[3]);
        $op = $matches[2];
        
        if (!is_numeric($left) || !is_numeric($right)) {
            return 'Error: Invalid operands';
        }
        
        if ($op == '*') {
            $result = $left * $right;
        } else if ($op == '/') {
            if ($right == 0) return 'Error: Division by zero';
            $result = $left / $right;
        }
        
        $expr = str_replace($matches[0], $result, $expr);
    }
    
    // Обработка сложения и вычитания
    $tokens = preg_split('/([+\-])/', $expr, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($tokens) > 1) {
        $result = evalExpressionRecursive($tokens[0]);
        for ($i = 1; $i < count($tokens); $i += 2) {
            $op = $tokens[$i];
            $val = evalExpressionRecursive($tokens[$i + 1]);
            if (!is_numeric($result) || !is_numeric($val)) {
                return 'Error: Invalid addition/subtraction';
            }
            if ($op == '+') {
                $result += $val;
            } else if ($op == '-') {
                $result -= $val;
            }
        }
        return $result;
    }
    
    // Если это число или константа
    if (is_numeric($expr)) {
        return (float)$expr;
    }
    
    if ($expr == 'M_PI') return M_PI;
    if ($expr == 'M_E') return M_E;
    
    return $expr;
}

function factorial($n) {
    if ($n <= 1) return 1;
    return $n * factorial($n - 1);
}

// Обработка POST запроса
$result = '';
$expression = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expression'])) {
    $expression = $_POST['expression'];
    $result = evaluateExpression($expression);
    
    // Перенаправление с GET параметром
    header('Location: index.php?result=' . urlencode($result) . '&expr=' . urlencode($expression));
    exit;
}

// Получение результата из GET
if (isset($_GET['result'])) {
    $result = htmlspecialchars($_GET['result']);
    $expression = isset($_GET['expr']) ? htmlspecialchars($_GET['expr']) : '';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор с рекурсивными вычислениями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calculator">
        <h2>🧮 Калькулятор</h2>
        
        <form id="calculatorForm" method="POST" action="index.php">
            <input type="text" id="display" name="expression" value="<?php echo $expression; ?>" readonly>
            <div class="result-display">
                <span>📐 Результат: </span>
                <span id="resultValue"><?php echo $result; ?></span>
            </div>
            
            <div class="buttons">
                <!-- Строка 1: Функции и константы -->
                <button type="button" class="btn func" data-value="π">π</button>
                <button type="button" class="btn func" data-value="e">e</button>
                <button type="button" class="btn func" data-value="√(">√</button>
                <button type="button" class="btn func" data-value="ln(">ln</button>
                <button type="button" class="btn func" data-value="log(">log</button>
                
                <!-- Строка 2: Степень и факториал -->
                <button type="button" class="btn func" data-value="^">xʸ</button>
                <button type="button" class="btn func" data-value="!">!</button>
                <button type="button" class="btn bracket" data-value="(">(</button>
                <button type="button" class="btn bracket" data-value=")">)</button>
                <button type="button" class="btn operator" data-value="/">÷</button>
                
                <!-- Строка 3: Цифры -->
                <button type="button" class="btn number" data-value="7">7</button>
                <button type="button" class="btn number" data-value="8">8</button>
                <button type="button" class="btn number" data-value="9">9</button>
                <button type="button" class="btn operator" data-value="*">×</button>
                <button type="button" class="btn operator" data-value="-">-</button>
                
                <!-- Строка 4 -->
                <button type="button" class="btn number" data-value="4">4</button>
                <button type="button" class="btn number" data-value="5">5</button>
                <button type="button" class="btn number" data-value="6">6</button>
                <button type="button" class="btn operator" data-value="+">+</button>
                <button type="button" class="btn clear" id="clearBtn">C</button>
                
                <!-- Строка 5 -->
                <button type="button" class="btn number" data-value="1">1</button>
                <button type="button" class="btn number" data-value="2">2</button>
                <button type="button" class="btn number" data-value="3">3</button>
                <button type="button" class="btn equals" id="equalsBtn">=</button>
                <button type="button" class="btn number" data-value="0">0</button>
                
                <!-- Строка 6 -->
                <button type="button" class="btn number" data-value=".">.</button>
                <button type="button" class="btn negative" id="negativeBtn">(-)</button>
            </div>
            
            <input type="hidden" name="submitted" value="1">
        </form>
        
        <div class="info">
            <p>💡 Примеры: π, e, √(9), ln(10), log(100), 2^3, 5!, (-2+3)*4</p>
            <p>⌨️ Ввод с клавиатуры: цифры, + - * / ( ) . ^ ! Enter - вычислить, Escape - очистить</p>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>