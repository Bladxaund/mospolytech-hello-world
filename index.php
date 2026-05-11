<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи - МосПолитех</title>
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
    <div class="title">Лабораторная работа: Форма обратной связи</div>

    </header>

    <main class="main">
        <div class="form-container">
            <h2>Обратная связь</h2>
            
            <?php
            $success_message = '';
            $error_message = '';
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $type = $_POST['type'] ?? '';
                $message = trim($_POST['message'] ?? '');
                $notify = $_POST['notify'] ?? [];
                
                // Валидация
                if (empty($name)) {
                    $error_message = 'Пожалуйста, введите ваше имя';
                } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error_message = 'Пожалуйста, введите корректный email';
                } elseif (empty($type)) {
                    $error_message = 'Пожалуйста, выберите тип обращения';
                } elseif (empty($message)) {
                    $error_message = 'Пожалуйста, введите текст обращения';
                } else {
                    // Подготовка данных для отправки
                    $post_data = [
                        'name' => $name,
                        'email' => $email,
                        'type' => $type,
                        'message' => $message,
                        'notify' => implode(', ', $notify),
                        'timestamp' => date('Y-m-d H:i:s'),
                        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                    ];
                    
                    // Отправка на httpbin.org/post
                    $ch = curl_init('https://httpbin.org/post');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                    
                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    if ($http_code === 200) {
                        $success_message = 'Сообщение успешно отправлено! Спасибо за обращение.';
                        // Очищаем форму
                        $_POST = [];
                    } else {
                        $error_message = 'Ошибка при отправке сообщения. Попробуйте позже.';
                    }
                }
            }
            ?>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name" class="required">Имя пользователя</label>
                    <input type="text" id="name" name="name" 
                           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                           placeholder="Введите ваше имя" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="required">E-mail пользователя</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                           placeholder="example@mail.ru" required>
                </div>
                
                <div class="form-group">
                    <label for="type" class="required">Тип обращения</label>
                    <select id="type" name="type" required>
                        <option value="">-- Выберите тип --</option>
                        <option value="complaint" <?php echo (($_POST['type'] ?? '') === 'complaint') ? 'selected' : ''; ?>>Жалоба</option>
                        <option value="suggestion" <?php echo (($_POST['type'] ?? '') === 'suggestion') ? 'selected' : ''; ?>>Предложение</option>
                        <option value="thanks" <?php echo (($_POST['type'] ?? '') === 'thanks') ? 'selected' : ''; ?>>Благодарность</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message" class="required">Текст обращения</label>
                    <textarea id="message" name="message" placeholder="Опишите ваше обращение..." required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Вариант ответа</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="notify[]" value="sms" 
                                   <?php echo (in_array('sms', $_POST['notify'] ?? [])) ? 'checked' : ''; ?>>
                            SMS
                        </label>
                        <label>
                            <input type="checkbox" name="notify[]" value="email" 
                                   <?php echo (in_array('email', $_POST['notify'] ?? [])) ? 'checked' : ''; ?>>
                            E-mail
                        </label>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" name="submit_form" class="btn btn-submit">✉ Отправить</button>
                    <a href="result.php" class="btn btn-link">📊 Перейти к заголовкам →</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        Задание для самостоятельной работы «Feedback form» — МосПолитех
    </footer>
</body>
</html>