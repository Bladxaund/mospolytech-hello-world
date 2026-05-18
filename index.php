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
        
        <div class="examples">
            <h3>📋 Примеры для проверки:</h3>
            <div class="example-buttons">
                <a href="solve.php?eq=X+3=7" class="example-btn">X + 3 = 7</a>
                <a href="solve.php?eq=X-5=10" class="example-btn">X - 5 = 10</a>
                <a href="solve.php?eq=2X=8" class="example-btn">2X = 8</a>
                <a href="solve.php?eq=3X+4=19" class="example-btn">3X + 4 = 19</a>
                <a href="solve.php?eq=5X-7=23" class="example-btn">5X - 7 = 23</a>
                <a href="solve.php?eq=X/2=6" class="example-btn">X / 2 = 6</a>
                <a href="solve.php?eq=4X=20" class="example-btn">4X = 20</a>
                <a href="solve.php?eq=X+12=25" class="example-btn">X + 12 = 25</a>
            </div>
        </div>
    </div>
</body>
</html>