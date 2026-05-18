<?php
function buildEditForm($pdo, $selectedId = null) {
    $message = '';
    
    // Получаем список всех контактов (сортировка по фамилии, затем по имени)
    $stmt = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Если нет ни одной записи
    if (empty($contacts)) {
        return '<p>Нет записей для редактирования.</p>';
    }
    
    // Определяем текущую запись
    if ($selectedId === null) {
        $currentContact = $contacts[0];
    } else {
        $found = false;
        foreach ($contacts as $c) {
            if ($c['id'] == $selectedId) {
                $currentContact = $c;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $currentContact = $contacts[0];
        }
    }
    
    // Обработка обновления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_contact'])) {
        $id = $_POST['contact_id'] ?? 0;
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
            $message = '<p class="error">Ошибка: запись не обновлена (Фамилия и Имя обязательны)</p>';
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE contacts SET 
                                        surname = :surname, 
                                        name = :name, 
                                        lastname = :lastname,
                                        gender = :gender,
                                        birthdate = :birthdate,
                                        phone = :phone,
                                        location = :location,
                                        email = :email,
                                        comment = :comment
                                        WHERE id = :id");
                $stmt->execute([
                    ':surname' => $surname,
                    ':name' => $name,
                    ':lastname' => $lastname,
                    ':gender' => $gender,
                    ':birthdate' => $birthdate ?: null,
                    ':phone' => $phone,
                    ':location' => $location,
                    ':email' => $email,
                    ':comment' => $comment,
                    ':id' => $id
                ]);
                $message = '<p class="success">Запись обновлена</p>';
                // Обновляем текущий контакт
                $currentContact = ['id' => $id, 'surname' => $surname, 'name' => $name, 'lastname' => $lastname];
            } catch (PDOException $e) {
                $message = '<p class="error">Ошибка: запись не обновлена</p>';
            }
        }
    }
    
    // Получаем полные данные текущего контакта для формы
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$currentContact['id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Список ссылок
    $html = '<div class="edit-list" style="margin-bottom: 20px;">';
    foreach ($contacts as $contact) {
        $initials = $contact['surname'] . ' ' . mb_substr($contact['name'], 0, 1) . '.';
        if (!empty($contact['lastname'])) {
            $initials .= mb_substr($contact['lastname'], 0, 1) . '.';
        }
        $class = ($contact['id'] == $currentContact['id']) ? 'currentRow' : '';
        $html .= "<a href='index.php?action=edit&edit_id={$contact['id']}' class='$class' style='display:inline-block; margin:5px; padding:5px 10px; text-decoration:none; border:1px solid #ccc;'>$initials</a>";
    }
    $html .= '</div>';
    
    $html .= $message;
    
    // Форма редактирования
    $html .= '<form name="form_edit" method="post">
                <input type="hidden" name="contact_id" value="' . $row['id'] . '">
                <div class="column">
                    <div class="add">
                        <label>Фамилия</label> 
                        <input type="text" name="surname" placeholder="Фамилия" value="' . htmlspecialchars($row['surname']) . '">
                    </div>
                    <div class="add">
                        <label>Имя</label> 
                        <input type="text" name="name" placeholder="Имя" value="' . htmlspecialchars($row['name']) . '">
                    </div>
                    <div class="add">
                        <label>Отчество</label> 
                        <input type="text" name="lastname" placeholder="Отчество" value="' . htmlspecialchars($row['lastname']) . '">
                    </div>
                    <div class="add">
                        <label>Пол</label> 
                        <select name="gender">
                            <option value="">Выберите</option>
                            <option value="мужской"' . ($row['gender'] == 'мужской' ? ' selected' : '') . '>мужской</option>
                            <option value="женский"' . ($row['gender'] == 'женский' ? ' selected' : '') . '>женский</option>
                        </select>
                    </div>
                    <div class="add">
                        <label>Дата рождения</label> 
                        <input type="date" name="birthdate" value="' . htmlspecialchars($row['birthdate']) . '">
                    </div>
                    <div class="add">
                        <label>Телефон</label> 
                        <input type="text" name="phone" placeholder="Телефон" value="' . htmlspecialchars($row['phone']) . '">
                    </div>
                    <div class="add">
                        <label>Адрес</label> 
                        <input type="text" name="location" placeholder="Адрес" value="' . htmlspecialchars($row['location']) . '">
                    </div>
                    <div class="add">
                        <label>Email</label> 
                        <input type="email" name="email" placeholder="Email" value="' . htmlspecialchars($row['email']) . '">
                    </div>
                    <div class="add">
                        <label>Комментарий</label> 
                        <textarea name="comment" placeholder="Краткий комментарий">' . htmlspecialchars($row['comment']) . '</textarea>
                    </div>
                    <button type="submit" name="update_contact" class="form-btn">Сохранить изменения</button>
                </div>
              </form>';
    
    return $html;
}
?>