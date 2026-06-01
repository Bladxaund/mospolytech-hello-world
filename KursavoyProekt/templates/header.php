<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✈️ Блог о путешествиях</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .logo h1 {
            color: #667eea;
            font-size: 24px;
        }
        
        .logo p {
            font-size: 12px;
            color: #666;
        }
        
        nav {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        nav a {
            color: #555;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        nav a:hover {
            background: #667eea;
            color: white;
        }
        
        .user-menu {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .user-menu span {
            color: #333;
            padding: 5px 10px;
            background: #f0f0f0;
            border-radius: 20px;
        }
        
        .user-menu a {
            color: #667eea;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 25px;
            transition: all 0.3s;
            border: 1px solid #667eea;
        }
        
        .user-menu a:hover {
            background: #667eea;
            color: white;
        }
        
        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            min-height: 500px;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            transition: transform 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: scale(1.05);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .post-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .post-card:hover {
            transform: translateY(-5px);
        }
        
        .post-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }
        
        .post-info {
            padding: 20px;
        }
        
        .post-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .post-date {
            color: #999;
            font-size: 12px;
            margin-bottom: 10px;
        }
        
        .post-excerpt {
            color: #666;
            line-height: 1.5;
        }
        
        .comments-section {
            background: #f9f9f9;
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .comment {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 3px solid #667eea;
        }
        
        .comment-author {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .comment-date {
            font-size: 11px;
            color: #999;
            margin-left: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        footer {
            text-align: center;
            padding: 30px;
            background: #333;
            color: #999;
            margin-top: 60px;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            .posts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="header-content">
        <div class="logo">
            <h1>✈️ Блог о путешествиях</h1>
            <p>Истории и впечатления</p>
        </div>
        <nav>
            <a href="/">Главная</a>
            <a href="/posts">Все статьи</a>
        </nav>
        <div class="user-menu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php 
                    $currentUser = User::getById($_SESSION['user_id']);
                    $isAdmin = $currentUser && $currentUser->isAdmin();
                ?>
                <?php if ($currentUser): ?>
                    <span>👤 <?= htmlspecialchars($currentUser->getNickname()) ?></span>
                <?php else: ?>
                    <span>👤 Пользователь</span>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <a href="/posts/add">➕ Добавить</a>
                <?php endif; ?>
                <a href="/auth/logout">🚪 Выйти</a>
            <?php else: ?>
                <a href="/auth/login">🔑 Вход</a>
                <a href="/auth/register">📝 Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main>