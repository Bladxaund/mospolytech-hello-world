<?php
/**
 * Программа для решения линейных уравнений вида aX ± b = c
 * Определяет оператор, расположение переменной и находит значение X
 */

class EquationSolver {
    private string $equation;
    private string $variable = 'X';
    private float $result = 0;
    private string $operator = '';
    private string $variablePosition = '';
    private float $coefficient = 1;
    private float $constant = 0;
    private float $rightValue = 0;
    private array $steps = [];
    private string $operationType = 'unknown';
    
    public function __construct(string $equation) {
        // Удаляем все пробелы
        $this->equation = str_replace(' ', '', $equation);
        // Приводим переменную к верхнему регистру
        $this->equation = preg_replace('/[a-z]/', 'X', $this->equation);
    }
    
    /**
     * Основной метод для решения уравнения
     */
    public function solve(): array {
        try {
            $this->addStep("📐 Анализ уравнения: " . $this->equation);
            
            // Разбиваем уравнение на левую и правую части
            $parts = explode('=', $this->equation);
            if (count($parts) != 2) {
                throw new Exception("Неверный формат уравнения. Используйте формат: X+3=7");
            }
            
            $leftSide = $parts[0];
            $this->rightValue = (float)$parts[1];
            $this->addStep("📌 Левая часть: $leftSide");
            $this->addStep("📌 Правая часть: " . $this->rightValue);
            
            // Анализируем левую часть
            $this->analyzeLeftSide($leftSide);
            
            // Находим значение X
            $this->computeX();
            
            return [
                'success' => true,
                'equation' => $this->equation,
                'variable' => $this->variable,
                'operator' => $this->operator,
                'variable_position' => $this->variablePosition,
                'coefficient' => $this->coefficient,
                'constant' => $this->constant,
                'right_value' => $this->rightValue,
                'solution' => $this->result,
                'steps' => $this->steps,
                'operation_type' => $this->operationType,
                'message' => "✅ Решение: {$this->variable} = " . round($this->result, 2)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Анализирует левую часть уравнения
     */
    private function analyzeLeftSide(string $leftSide): void {
        // Определяем положение переменной
        if (strpos($leftSide, $this->variable) === 0) {
            $this->variablePosition = "в начале уравнения";
        } elseif (strpos($leftSide, $this->variable) > 0) {
            $this->variablePosition = "после оператора";
        }
        $this->addStep("📍 Переменная находится: " . $this->variablePosition);
        
        // Обработка различных форматов уравнений
        if (preg_match('/^([+-]?\d*)?X([+-]\d+)?$/', $leftSide, $matches)) {
            // Формат: aX ± b
            $this->operationType = "сложение/вычитание";
            
            // Коэффициент при X
            if (!empty($matches[1]) && $matches[1] !== '') {
                $coeff = $matches[1];
                if ($coeff === '+') $this->coefficient = 1;
                else if ($coeff === '-') $this->coefficient = -1;
                else $this->coefficient = (float)$coeff;
            } else {
                $this->coefficient = 1;
            }
            
            // Свободный член
            if (!empty($matches[2])) {
                $this->constant = (float)$matches[2];
                $this->operator = ($this->constant >= 0) ? '+' : '-';
            } else {
                $this->constant = 0;
                $this->operator = '+';
            }
        } 
        elseif (preg_match('/^([+-]?\d*)?X$/', $leftSide, $matches)) {
            // Формат: aX (без свободного члена)
            $this->operationType = "умножение";
            if (!empty($matches[1]) && $matches[1] !== '') {
                $coeff = $matches[1];
                if ($coeff === '+') $this->coefficient = 1;
                else if ($coeff === '-') $this->coefficient = -1;
                else $this->coefficient = (float)$coeff;
            } else {
                $this->coefficient = 1;
            }
            $this->constant = 0;
            $this->operator = '+';
        }
        elseif (preg_match('/^X\/(\d+)$/', $leftSide, $matches)) {
            // Формат: X / a
            $this->operationType = "деление";
            $this->coefficient = 1 / (float)$matches[1];
            $this->constant = 0;
            $this->operator = '+';
            $this->addStep("🔍 Обнаружено деление: X ÷ " . $matches[1]);
        }
        else {
            throw new Exception("Не удалось распознать формат уравнения. Поддерживаются: X±b=c, aX=c, X/a=c");
        }
        
        $this->addStep("📊 Коэффициент при X: " . $this->coefficient);
        $this->addStep("🔢 Свободный член: " . $this->constant);
        $this->addStep("🔧 Оператор: " . $this->operator);
    }
    
    /**
     * Вычисляет значение X
     */
    private function computeX(): void {
        $operatorSign = ($this->constant >= 0) ? '+' : '-';
        $this->addStep("\n📝 Уравнение: {$this->coefficient}X {$operatorSign} " . abs($this->constant) . " = {$this->rightValue}");
        
        // Переносим свободный член в правую часть
        $rightAfterMove = $this->rightValue - $this->constant;
        $operation = $this->constant >= 0 ? "- {$this->constant}" : "+ " . abs($this->constant);
        $this->addStep("➡️ Переносим свободный член: {$this->coefficient}X = {$this->rightValue} {$operation}");
        $this->addStep("📐 {$this->coefficient}X = " . $rightAfterMove);
        
        // Находим X
        if ($this->coefficient != 0) {
            $this->result = $rightAfterMove / $this->coefficient;
            $this->addStep("➗ Делим обе части на {$this->coefficient}: X = " . $rightAfterMove . " ÷ {$this->coefficient}");
            $this->addStep("🎯 Результат: X = " . round($this->result, 2));
        } else {
            throw new Exception("Коэффициент при X не может быть равен 0");
        }
    }
    
    private function addStep(string $step): void {
        $this->steps[] = $step;
    }
}

// Получаем уравнение из POST или GET
$equation = $_POST['equation'] ?? $_GET['eq'] ?? 'X+3=7';

// Создаем экземпляр решателя
$solver = new EquationSolver($equation);
$result = $solver->solve();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат решения уравнения</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>📐 Решение линейного уравнения</h1>
        
        <?php if ($result['success']): ?>
            <div class="result success">
                <h3>🎉 Результат решения:</h3>
                <div class="result-details">
                    <p><strong>📐 Исходное уравнение:</strong> <?php echo htmlspecialchars($equation); ?></p>
                    <p><strong>🔍 Определенный оператор:</strong> 
                        <?php 
                        if ($result['operation_type'] == 'деление') echo '÷ (деление)';
                        else if ($result['coefficient'] != 1 || $result['constant'] != 0) echo '+ (сложение)';
                        else echo 'не требуется';
                        ?>
                    </p>
                    <p><strong>📍 Расположение переменной:</strong> <?php echo $result['variable_position']; ?></p>
                    <p><strong>📊 Коэффициент при X:</strong> <?php echo $result['coefficient']; ?></p>
                    <p><strong>🔢 Свободный член:</strong> <?php echo $result['constant']; ?></p>
                    <p><strong>✨ Значение переменной:</strong> <span class="solution">X = <?php echo round($result['solution'], 2); ?></span></p>
                </div>
                
                <div class="steps">
                    <h4>📝 Пошаговое решение:</h4>
                    <ol>
                        <?php foreach ($result['steps'] as $step): ?>
                            <li><?php echo htmlspecialchars($step); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                
                <div class="verification">
                    <h4>✅ Проверка:</h4>
                    <p>
                        <?php 
                        // Проверка для разных типов уравнений
                        if (strpos($equation, '/') !== false) {
                            // Для деления
                            preg_match('/X\/(\d+)=(\d+)/', str_replace(' ', '', $equation), $matches);
                            if ($matches) {
                                $divisor = $matches[1];
                                $check = $result['solution'] / $divisor;
                                echo "{$result['solution']} ÷ {$divisor} = " . round($check, 2) . " = " . $result['right_value'];
                            }
                        } elseif ($result['coefficient'] == 1 && $result['constant'] != 0) {
                            // Для X + b = c
                            $check = $result['solution'] + $result['constant'];
                            echo $result['solution'] . " + " . $result['constant'] . " = " . $check . " = " . $result['right_value'];
                        } elseif ($result['coefficient'] != 1 && $result['constant'] == 0) {
                            // Для aX = c
                            $check = $result['coefficient'] * $result['solution'];
                            echo $result['coefficient'] . " × " . $result['solution'] . " = " . $check . " = " . $result['right_value'];
                        } elseif ($result['coefficient'] != 1 && $result['constant'] != 0) {
                            // Для aX + b = c
                            $check = $result['coefficient'] * $result['solution'] + $result['constant'];
                            echo $result['coefficient'] . " × " . $result['solution'] . " + " . $result['constant'] . " = " . $check . " = " . $result['right_value'];
                        }
                        ?>
                        <?php if (abs(($result['coefficient'] * $result['solution'] + $result['constant']) - $result['right_value']) < 0.0001): ?>
                            <span style="color: green; margin-left: 10px;">✓ Верно!</span>
                        <?php else: ?>
                            <span style="color: red; margin-left: 10px;">✗ Ошибка!</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <div class="result error">
                <h3>⚠️ Ошибка:</h3>
                <p><?php echo htmlspecialchars($result['error']); ?></p>
                <p style="margin-top: 10px;">Попробуйте один из форматов:</p>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    <li>X + 3 = 7</li>
                    <li>2X = 8</li>
                    <li>3X + 4 = 19</li>
                    <li>X / 2 = 6</li>
                </ul>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="index.html" class="back-link">← Решить другое уравнение</a>
        </div>
    </div>
</body>
</html>