<?php
date_default_timezone_set('Europe/Moscow');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, World! — МосПолитех</title>
    <!-- Подключаем отдельный CSS файл -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo-area">
        <a href="https://mospolytech.ru" target="_blank" class="logo" rel="noopener noreferrer">
            <!-- Логотип МосПолитеха (стилизованный SVG) -->
            <svg class="logo-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" rx="20" fill="#0033A0"/>
                <path d="M30 70 L50 30 L70 70 L58 70 L50 52 L42 70 L30 70Z" fill="white"/>
                <circle cx="50" cy="45" r="8" fill="white"/>
                <text x="50" y="88" text-anchor="middle" fill="white" font-size="12" font-weight="bold">МОСПОЛИТЕХ</text>
            </svg>
            <span>Московский политех</span>
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
                // Динамический контент на PHP
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
                
                echo "<strong style='font-size:1.1rem;'>📢 {$greetingPhrase}, уважаемый гость!</strong><br>";
                echo "Серверное время: " . date('H:i:s d.m.Y') . "<br>";
                echo "PHP работает на версии: " . phpversion();
            ?>
        </div>
        
        <div class="server-info">
            ⚡ Динамический контент сгенерирован на стороне сервера<br>
            <small>Hello, World! — классический пример веб-программирования</small>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="footer-text">
        📝 задание для самостоятельной работы
    </div>
    <div style="margin-top: 8px; font-size: 0.75rem;">
        Московский политехнический университет • Серверная веб-разработка
    </div>
</footer>

</body>
</html>