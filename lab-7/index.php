<?php
// index.php - фронт-контроллер

// Простейший роутер
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Проверяем роут /bye/{name}
if (preg_match('#^/bye/(.+)$#', $uri, $matches)) {
    $name = $matches[1];
    echo "Пока, $name";
    exit;
}

// Остальные роуты
if ($uri == '/') {
    include 'views/home.php';
} elseif ($uri == '/about-me') {
    echo "Страница обо мне";
} else {
    http_response_code(404);
    echo "404 - Страница не найдена";
}
?>