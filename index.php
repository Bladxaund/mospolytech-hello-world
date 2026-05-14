<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Решение уравнения X + 3 = 7</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Решение линейного уравнения</h1>
        <div class="equation-box">
            <h2>Уравнение: <span class="equation">X + 3 = 7</span></h2>
        </div>

        <?php
        /**
         * Программа для решения уравнения X + 3 = 7
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
            
            public function __construct(string $equation) {
                $this->equation = str_replace(' ', '', $equation);
            }
            
            /**
             * Основной метод для решения уравнения
             */
            public function solve(): array {
                try {
                    $this->addStep("1. Анализ уравнения: " . $this->equation);
                    
                    // Разбиваем уравнение на левую и правую части
                    $parts = explode('=', $this->equation);
                    if (count($parts) != 2) {
                        throw new Exception("Неверный формат уравнения");
                    }
                    
                    $leftSide = $parts[0];
                    $this->rightValue = (float)$parts[1];
                    $this->addStep("2. Левая часть: $leftSide");
                    $this->addStep("3. Правая часть: " . $this->rightValue);
                    
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
                        'message' => "Решение: {$this->variable} = " . round($this->result, 2)
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
                    $this->addStep("4. Переменная находится " . $this->variablePosition);
                } elseif (strpos($leftSide, $this->variable) > 0) {
                    $this->variablePosition = "после оператора";
                    $this->addStep("4. Переменная находится " . $this->variablePosition);
                }
                
                // Разбираем уравнение X+3
                if ($leftSide === 'X+3') {
                    $this->operator = '+';
                    $this->coefficient = 1;
                    $this->constant = 3;
                    $this->addStep("5. Определен оператор: +");
                    $this->addStep("6. Коэффициент при X: " . $this->coefficient);
                    $this->addStep("7. Свободный член: " . $this->constant);
                }
                // Альтернативный парсинг для других форматов
                else {
                    // Регулярное выражение для разбора уравнения вида aX + b
                    if (preg_match('/([+-]?\d*)[Xx]\s*([+-]\d+)/', $leftSide, $matches)) {
                        if (!empty($matches[1]) && $matches[1] !== '') {
                            $coeff = $matches[1];
                            if ($coeff === '+') $this->coefficient = 1;
                            else if ($coeff === '-') $this->coefficient = -1;
                            else $this->coefficient = (float)$coeff;
                        } else {
                            $this->coefficient = 1;
                        }
                        
                        if (!empty($matches[2])) {
                            $this->constant = (float)$matches[2];
                        }
                        
                        $this->operator = ($this->constant >= 0) ? '+' : '-';
                    }
                    // Если только X без свободного члена
                    elseif (preg_match('/([+-]?\d*)[Xx]/', $leftSide, $matches)) {
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
                }
            }
            
            /**
             * Вычисляет значение X
             */
            private function computeX(): void {
                $operatorSign = ($this->constant >= 0) ? '+' : '-';
                $this->addStep("8. Уравнение: {$this->coefficient}X {$operatorSign} " . abs($this->constant) . " = {$this->rightValue}");
                
                // Переносим свободный член в правую часть
                $rightAfterMove = $this->rightValue - $this->constant;
                $operation = $this->constant >= 0 ? "- {$this->constant}" : "+ " . abs($this->constant);
                $this->addStep("9. Переносим свободный член: {$this->coefficient}X = {$this->rightValue} {$operation}");
                $this->addStep("10. {$this->coefficient}X = " . $rightAfterMove);
                
                // Находим X
                if ($this->coefficient != 0) {
                    $this->result = $rightAfterMove / $this->coefficient;
                    $this->addStep("11. Делим обе части на {$this->coefficient}: X = " . $rightAfterMove . " / {$this->coefficient}");
                    $this->addStep("12. Результат: X = " . round($this->result, 2));
                } else {
                    throw new Exception("Коэффициент при X не может быть равен 0");
                }
            }
            
            private function addStep(string $step): void {
                $this->steps[] = $step;
            }
        }
        
        // Решаем уравнение X + 3 = 7
        $solver = new EquationSolver("X+3=7");
        $result = $solver->solve();
        ?>

        <?php if ($result['success']): ?>
            <div class="result success">
                <h3>Результат решения:</h3>
                <div class="result-details">
                    <p><strong>📐 Исходное уравнение:</strong> <?php echo htmlspecialchars($result['equation']); ?> = <?php echo $result['right_value']; ?></p>
                    <p><strong>🔍 Определенный оператор:</strong> <?php echo $result['operator']; ?></p>
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
                        $check = $result['solution'] + 3;
                        echo $result['solution'] . " + 3 = " . $check . " = " . $result['right_value'];
                        ?>
                        <?php if (abs($check - $result['right_value']) < 0.0001): ?>
                            <span style="color: green; margin-left: 10px;">✓ Верно!</span>
                        <?php else: ?>
                            <span style="color: red; margin-left: 10px;">✗ Ошибка!</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <div class="result error">
                <h3>Ошибка:</h3>
                <p><?php echo htmlspecialchars($result['error']); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>