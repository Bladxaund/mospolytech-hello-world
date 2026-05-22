<?php
// Используем HTTP вместо HTTPS (для обхода ошибки)
$url = 'http://httpbin.org/get';  // заменили https на http

$headers = get_headers($url);

if ($headers === false) {
    $headersOutput = 'Не удалось получить заголовки. Проверьте подключение к интернету.';
} else {
    // Форматируем вывод для лучшей читаемости
    $headersOutput = "=== HTTP ЗАГОЛОВКИ ===\n";
    $headersOutput .= "URL: $url\n";
    $headersOutput .= "Время запроса: " . date('Y-m-d H:i:s') . "\n";
    $headersOutput .= str_repeat("=", 50) . "\n\n";
    
    foreach ($headers as $key => $value) {
        $headersOutput .= $value . "\n";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_headers</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img class='logo' src="images/logo.png" alt="Московский Политех">
            <span class="logo-text">МОСКОВСКИЙ ПОЛИТЕХ</span>
        </div>
        <div class="title">Результат работы функции get_headers</div>
        <div class="header-spacer"></div>
    </header>
    <!-- остальной код -->

    <main class="main">
        <section class="card">
            <h1>Заголовки ответа сервера</h1>

            <p class="description">
                URL для проверки: <?= htmlspecialchars($url) ?>
            </p>
            
            <?php if (strpos($url, 'https') === 0 && $headers === false): ?>
                <div class="alert alert-warning">
                    <strong>Внимание!</strong> Ваш PHP не поддерживает HTTPS. 
                    <a href="?use_http=1" class="alert-link">Использовать HTTP версию</a>
                </div>
            <?php endif; ?>

            <textarea class="headers-result" rows="20" readonly><?= htmlspecialchars($headersOutput) ?></textarea>

            <a class="link-button" href="./index.php">
                Вернуться к форме
            </a>
        </section>
    </main>

    <footer class="footer">
        задание для самостоятельно работы
    </footer>
</body>
</html>