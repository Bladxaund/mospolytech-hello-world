<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// /hello/{name}
if (preg_match('#^/hello/(.+)$#', $uri, $matches)) {
    $name = urldecode($matches[1]);
    $title = "Страница приветствия";  // ← по заданию
    $content = "<h1>Привет, $name!</h1>";
    include 'template.php';
    exit;
}

// /about-me
if ($uri == '/about-me') {
    $title = "Обо мне";
    $content = "<h1>Обо мне</h1><p>Информация обо мне</p>";
    include 'template.php';
    exit;
}

// Главная /
if ($uri == '/') {
    // title НЕ задаём → будет "Мой блог" по умолчанию
    $content = file_get_contents('home.php');
    include 'template.php';
    exit;
}

// /bye/{name} - не в задании, но пусть работает
if (preg_match('#^/bye/(.+)$#', $uri, $matches)) {
    $name = urldecode($matches[1]);
    echo "Пока, $name";
    exit;
}

// 404
http_response_code(404);
$title = "Страница не найдена";
$content = "<h1>404</h1>";
include 'template.php';
?>