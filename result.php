<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заголовки сервера - МосПолитех</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
    <div class="logo">
        <a href="index.php">
            <?php if (file_exists('images/logoPolytech.png')): ?>
                <img src="images/logoPolytech.png" alt="Московский политех" class="logo-image">
            <?php else: ?>
                <div class="logo-text">
                    МОСКОВСКИЙ<br>ПОЛИТЕХ
                </div>
            <?php endif; ?>
        </a>
    </div>
    <div class="title">Лабораторная работа: Результат get_headers()</div>
</header>

    <main class="main">
        <div class="result-container">
            <h2>Информация о заголовках</h2>
            
            <div class="result-info">
                <p><strong>📅 Дата и время:</strong> <?php echo date('d.m.Y H:i:s'); ?></p>
                <p><strong>🌐 IP адрес сервера:</strong> <?php echo $_SERVER['SERVER_ADDR'] ?? 'Не определен'; ?></p>
                <p><strong>💻 Имя сервера:</strong> <?php echo $_SERVER['SERVER_NAME'] ?? 'Не определен'; ?></p>
                <p><strong>🔧 Программное обеспечение:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Не определен'; ?></p>
                <p><strong>📄 Протокол:</strong> <?php echo $_SERVER['SERVER_PROTOCOL'] ?? 'Не определен'; ?></p>
            </div>
            
            <label for="headers"><strong>📋 Результат работы функции get_headers() для текущего сайта:</strong></label>
            <textarea id="headers" class="headers-textarea" rows="20" readonly><?php
            // Получаем текущий URL
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $current_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            
            // Выполняем get_headers для текущего сайта
            $headers = @get_headers($current_url, 1);
            
            if ($headers === false) {
                // Если не удалось, пробуем получить для главной страницы
                $base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
                $headers = @get_headers($base_url, 1);
            }
            
            if ($headers !== false) {
                echo "=== ЗАГОЛОВКИ HTTP ===\n\n";
                foreach ($headers as $key => $value) {
                    if (is_array($value)) {
                        echo $key . ":\n";
                        foreach ($value as $subvalue) {
                            echo "  - " . $subvalue . "\n";
                        }
                    } else {
                        echo $key . ": " . $value . "\n";
                    }
                }
                
                echo "\n\n=== ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ===\n\n";
                echo "Всего заголовков: " . count($headers) . "\n";
                echo "Тип сервера: " . ($headers['Server'] ?? 'Не указан') . "\n";
                echo "Content-Type: " . ($headers['Content-Type'] ?? 'Не указан') . "\n";
                echo "Дата: " . ($headers['Date'] ?? 'Не указана') . "\n";
            } else {
                echo "Ошибка: Не удалось получить заголовки.\n";
                echo "Проверьте подключение к интернету и настройки сервера.\n\n";
                echo "Возможные причины:\n";
                echo "- allow_url_fopen = Off в настройках PHP\n";
                echo "- Отсутствует доступ к сети\n";
                echo "- Сервер блокирует запросы к самому себе";
            }
            ?></textarea>
            
            <div class="back-link">
                <a href="index.php" class="btn btn-back">← Вернуться к форме обратной связи</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        Задание для самостоятельной работы «Feedback form» — МосПолитех
    </footer>
</body>
</html>