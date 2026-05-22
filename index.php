<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img class='logo' src="images/logo.png" alt="Московский Политех">
            <span class="logo-text">МОСКОВСКИЙ ПОЛИТЕХ</span>
        </div>
        <div class="title">Домашняя работа: Feedback Form</div>
        <div class="header-spacer"></div>
    </header>
    <!-- остальной код -->

    <main class="main">
        <section class="card">
            <h1>Форма обратной связи</h1>

            <form class="form" action="https://httpbin.org/post" method="POST">
                <label class="form-field">
                    <span>Имя пользователя</span>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Введите имя" 
                        required
                    >
                </label>

                <label class="form-field">
                    <span>E-mail пользователя</span>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="example@mail.com" 
                        required
                    >
                </label>

                <label class="form-field">
                    <span>Тип обращения</span>
                    <select name="request_type" required>
                        <option value="">Выберите тип обращения</option>
                        <option value="complaint">Жалоба</option>
                        <option value="suggestion">Предложение</option>
                        <option value="thanks">Благодарность</option>
                    </select>
                </label>

                <label class="form-field">
                    <span>Текст обращения</span>
                    <textarea 
                        name="message" 
                        rows="6" 
                        placeholder="Введите текст обращения" 
                        required
                    ></textarea>
                </label>

                <fieldset class="checkbox-group">
                    <legend>Вариант ответа</legend>

                    <label>
                        <input type="checkbox" name="response_type[]" value="sms">
                        СМС
                    </label>

                    <label>
                        <input type="checkbox" name="response_type[]" value="email">
                        E-mail
                    </label>
                </fieldset>

                <button class="button" type="submit">
                    Отправить
                </button>
            </form>

            <a class="link-button" href="./headers.php">
                Перейти на 2 страницу
            </a>
        </section>
    </main>

    <footer class="footer">
        задание для самостоятельно работы
    </footer>
</body>
</html>