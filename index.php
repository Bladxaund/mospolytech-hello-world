<?php
date_default_timezone_set('Europe/Moscow');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, World! — МосПолитех</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo-area">
        <a href="https://mospolytech.ru" target="_blank" class="logo" rel="noopener noreferrer">
            <!-- Ваш логотип Московский Политех -->
            <img src="images/logoPolytech.png" alt="Московский политех" class="logo-image">
        </a>
    </div>
    <div class="title-area">
        <h1 class="work-title">Hello, World! — Динамический контент</h1>
        <div class="subtitle">Серверная веб-разработка</div>
    </div>
    <div style="flex:1"></div>
</header>

<main class="main">
    <div class="dynamic-card">
        <div class="greeting">
            🌍 Hello, World!
        </div>
        
        <div class="dynamic-message">
            <?php
                $currentHour = date('H');
                
                if ($currentHour >= 6 && $currentHour < 12) {
                    $greetingPhrase = "Доброе утро";
                } elseif ($currentHour >= 12 && $currentHour < 18) {
                    $greetingPhrase = "Добрый день";
                } elseif ($currentHour >= 18 && $currentHour < 23) {
                    $greetingPhrase = "Добрый вечер";
                } else {
                    $greetingPhrase = "Доброй ночи";
                }
                
                echo "<strong>📢 {$greetingPhrase}, уважаемый гость!</strong><br>";
                echo "🕐 Московское время: " . date('H:i:s d.m.Y') . "<br>";
                echo "🐘 PHP версия: " . phpversion();
            ?>
        </div>
        
       
    </div>
</main>

<footer class="footer">
    <div class="footer-text">
         задание для самостоятельной работы
    </div>
    <div style="margin-top: 8px; font-size: 0.75rem;">
        Московский политехнический университет • Серверная веб-разработка
    </div>
</footer>

</body>
</html>