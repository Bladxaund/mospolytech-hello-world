<?php
// URL для получения заголовков (можно изменить на любой другой)
$targetUrl = 'https://httpbin.org/headers';

// Получаем заголовки с помощью get_headers
$headers = get_headers($targetUrl, 1);

// Форматируем для вывода
$headersFormatted = '';
if ($headers !== false) {
    foreach ($headers as $key => $value) {
        if (is_array($value)) {
            $headersFormatted .= "$key:\n";
            foreach ($value as $val) {
                $headersFormatted .= "    $val\n";
            }
        } else {
            $headersFormatted .= "$key: $value\n";
        }
    }
} else {
    $headersFormatted = "Не удалось получить заголовки для URL: $targetUrl";
}

// Также можно показать информацию о текущем сервере
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$currentHeaders = get_headers($currentUrl, 1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат get_headers — МосПолитех</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo-area">
        <a href="https://mospolytech.ru" target="_blank" class="logo" rel="noopener noreferrer">
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
        <h1 class="work-title">get_headers — Заголовки HTTP</h1>
        <div class="subtitle">Серверная веб-разработка</div>
    </div>
    <div style="flex:1"></div>
</header>

<main class="main">
    <div class="headers-card">
        <h2>📋 Результат работы функции get_headers()</h2>
        
        <div class="form-group">
            <label>🌐 URL для запроса:</label>
            <input type="text" value="<?php echo htmlspecialchars($targetUrl); ?>" readonly style="background:#f0f0f0;">
        </div>
        
        <div class="form-group">
            <label>📄 Заголовки ответа:</label>
            <textarea class="headers-textarea" readonly><?php echo htmlspecialchars($headersFormatted); ?></textarea>
        </div>
        
        <div class="back-link">
            <a href="index.php" class="btn btn-primary">← Вернуться к форме</a>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="footer-text">
        📝 задание для самостоятельной работы
    </div>
</footer>

</body>
</html>