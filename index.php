<?php
// Определяем текущий action
$action = $_GET['action'] ?? 'view';

// Параметры для viewer
$sort = $_GET['sort'] ?? 'created_at';
$page = (int)($_GET['page'] ?? 1);

// Подключаем модули
require_once 'menu.php';
require_once 'viewer.php';
require_once 'add.php';
require_once 'edit.php';
require_once 'delete.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?= renderMenu($action, $sort) ?>
    </header>
    
    <main>
        <?php
        // Выводим соответствующий контент
        switch($action) {
            case 'add':
                echo handleAdd();
                break;
            case 'edit':
                echo handleEdit();
                break;
            case 'delete':
                echo handleDelete();
                break;
            default: // view
                echo renderViewer($sort, $page);
        }
        ?>
    </main>
    
    <footer>
        <p>© Записная книжка</p>
    </footer>
</body>
</html>