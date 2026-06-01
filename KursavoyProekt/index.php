<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/Db.php';
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/ActiveRecordEntity.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Post.php';
require_once __DIR__ . '/Comment.php';
require_once __DIR__ . '/MainController.php';
require_once __DIR__ . '/PostsController.php';
require_once __DIR__ . '/AuthController.php';

$routes = require __DIR__ . '/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $requestUri, $matches)) {
        array_shift($matches);
        $controllerName = $handler[0];
        $methodName = $handler[1];
        
        $controller = new $controllerName();
        $controller->$methodName(...$matches);
        exit;
    }
}

http_response_code(404);
echo '404 - Страница не найдена';