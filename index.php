<?php
session_start();
require_once 'menu.php';
require_once 'viewer.php';
require_once 'add.php';
require_once 'edit.php';
require_once 'delete.php';

// Подключение к БД
$host = 'localhost';
$dbname = 'phonebook';
$username = 'root';
$password = 'Kakein0408';  // Если пароль не установлен, оставьте пустым

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Определяем активный пункт меню
$active = $_GET['action'] ?? 'view';
$sort = $_GET['sort'] ?? 'created';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$edit_id = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : null;
$delete_id = isset($_GET['delete_id']) ? (int)$_GET['delete_id'] : null;

// Обработка удаления
if ($delete_id) {
    deleteContact($pdo, $delete_id);
    header("Location: index.php?action=delete&deleted=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style%20(5).css">
</head>
<body>
    <main>
        <?= buildMenu($active, $sort) ?>
        
        <div class="content">
            <?php
            switch($active) {
                case 'view':
                    echo buildViewer($pdo, $sort, $page);
                    break;
                case 'add':
                    echo buildAddForm($pdo);
                    break;
                case 'edit':
                    echo buildEditForm($pdo, $edit_id);
                    break;
                case 'delete':
                    echo buildDeleteList($pdo);
                    break;
                default:
                    echo buildViewer($pdo, $sort, $page);
            }
            ?>
        </div>
    </main>
    <footer></footer>
</body>
</html>