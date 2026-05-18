<?php
function buildAddForm($pdo) {
    $message = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_contact'])) {
        $surname = $_POST['surname'] ?? '';
        $name = $_POST['name'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $birthdate = $_POST['birthdate'] ?? null;
        $phone = $_POST['phone'] ?? '';
        $location = $_POST['location'] ?? '';
        $email = $_POST['email'] ?? '';
        $comment = $_POST['comment'] ?? '';
        
        if (empty($surname) || empty($name)) {
            $message = '<p class="error">Ошибка: запись не добавлена (Фамилия и Имя обязательны)</p>';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, lastname, gender, birthdate, phone, location, email, comment) 
                                        VALUES (:surname, :name, :lastname, :gender, :birthdate, :phone, :location, :email, :comment)");
                $stmt->execute([
                    ':surname' => $surname,
                    ':name' => $name,
                    ':lastname' => $lastname,
                    ':gender' => $gender,
                    ':birthdate' => $birthdate ?: null,
                    ':phone' => $phone,
                    ':location' => $location,
                    ':email' => $email,
                    ':comment' => $comment
                ]);
                $message = '<p class="success">Запись добавлена</p>';
                // Очищаем POST, чтобы форма отобразилась пустой
                $_POST = [];
            } catch (PDOException $e) {
                $message = '<p class="error">Ошибка: запись не добавлена</p>';
            }
        }
    }
    
    $html = $message;
    $html .= '<form name="form_add" method="post">
                <div class="column">
                    <div class="add">
                        <label>Фамилия</label> 
                        <input type="text" name="surname" placeholder="Фамилия" value="' . htmlspecialchars($_POST['surname'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Имя</label> 
                        <input type="text" name="name" placeholder="Имя" value="' . htmlspecialchars($_POST['name'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Отчество</label> 
                        <input type="text" name="lastname" placeholder="Отчество" value="' . htmlspecialchars($_POST['lastname'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Пол</label> 
                        <select name="gender">
                            <option value="">Выберите</option>
                            <option value="мужской"' . (($_POST['gender'] ?? '') == 'мужской' ? ' selected' : '') . '>мужской</option>
                            <option value="женский"' . (($_POST['gender'] ?? '') == 'женский' ? ' selected' : '') . '>женский</option>
                        </select>
                    </div>
                    <div class="add">
                        <label>Дата рождения</label> 
                        <input type="date" name="birthdate" value="' . htmlspecialchars($_POST['birthdate'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Телефон</label> 
                        <input type="text" name="phone" placeholder="Телефон" value="' . htmlspecialchars($_POST['phone'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Адрес</label> 
                        <input type="text" name="location" placeholder="Адрес" value="' . htmlspecialchars($_POST['location'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Email</label> 
                        <input type="email" name="email" placeholder="Email" value="' . htmlspecialchars($_POST['email'] ?? '') . '">
                    </div>
                    <div class="add">
                        <label>Комментарий</label> 
                        <textarea name="comment" placeholder="Краткий комментарий">' . htmlspecialchars($_POST['comment'] ?? '') . '</textarea>
                    </div>
                    <button type="submit" name="add_contact" class="form-btn">Добавить</button>
                </div>
              </form>';
    
    return $html;
}
?>