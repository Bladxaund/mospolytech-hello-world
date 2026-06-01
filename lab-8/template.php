<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "Мой блог" ?></title>
    <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">Мой блог</td>
    </tr>
    <tr>
        <td><?= $content ?>?</td>
        <td class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/about-me">Обо мне</a></li>
                <li><a href="/hello/Иван">Привет</a></li>
                <li><a href="/bye/Иван">Пока</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="footer">Все права защищены (c) Мой блог</td>
    </tr>
</table>

</body>
</html>