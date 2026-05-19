<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Решение линейных уравнений</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>📐 Решение линейных уравнений</h1>
        <p class="subtitle">Уравнения вида: <strong>aX + b = c</strong> или <strong>X + b = c</strong></p>
        
        <div class="input-section">
            <form method="POST" action="solve.php">
                <div class="input-group">
                    <label for="equation">Введите уравнение:</label>
                    <input type="text" 
                           id="equation" 
                           name="equation" 
                           placeholder="Пример: X+5=12" 
                           value="<?php echo isset($_GET['eq']) ? htmlspecialchars($_GET['eq']) : 'X+3=7'; ?>"
                           required>
                    <small>Поддерживаемые форматы: X+3=7, 2X-5=10, X=5, 3X=12</small>
                </div>
                
                <button type="submit" class="solve-btn">🔍 Решить уравнение</button>
            </form>
        </div>
        
        
    </div>
</body>
</html>