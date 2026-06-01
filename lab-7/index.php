<?php
// index.php - фронт-контроллер

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Роут /bye/{name}
if (preg_match('#^/bye/(.+)$#', $uri, $matches)) {
    $name = urldecode($matches[1]);  // ← ДОБАВИТЬ ЭТУ СТРОКУ
    echo "Пока, $name";
    exit;
}

// Роут /about-me
if ($uri == '/about-me') {
    echo "Страница обо мне";
    exit;
}

// Роут / (главная)
if ($uri == '/') {
    include 'home.php';
    exit;
}

// 404
http_response_code(404);
echo "404 - Страница не найдена";
?>