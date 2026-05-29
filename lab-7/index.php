<?php
// ========== РОУТЕР  ==========
class Router
{
    private $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Заменяем {name} на регулярное выражение
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Убираем полное совпадение
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        // Роут не найден
        http_response_code(404);
        echo "404 - Страница не найдена";
    }
}

// ========== КОНТРОЛЛЕР ==========
class MainController
{
    // Существующий метод (пример)
    public function sayHello(string $name): void
    {
        echo "Привет, $name!";
    }

    // НОВЫЙ ЭКШН - то, что нужно сделать
    public function sayBye(string $name): void
    {
        echo "Пока, $name!";
    }
}

// ========== РЕГИСТРАЦИЯ РОУТОВ ==========
$router = new Router();

// Главная страница
$router->add('GET', '/', function() {
    echo "Добро пожаловать в записную книжку!";
});

// Приветствие
$router->add('GET', '/hello/{name}', function(string $name) {
    $controller = new MainController();
    $controller->sayHello($name);
});

// ========== НОВЫЙ РОУТ (ТО, ЧТО ВЫ ПРОСИЛИ) ==========
$router->add('GET', '/bye/{name}', function(string $name) {
    $controller = new MainController();
    $controller->sayBye($name);
});

// ========== ЗАПУСК ==========
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $uri);
?>