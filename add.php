<?php
require_once 'storage.php';

function handleAdd() {
    $message = '';
    $messageClass = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
        $records = loadRecords();
        
        // Проверка обязательных полей
        if (empty($_POST['surname']) || empty($_POST['name'])) {
            $message = 'Ошибка: Фамилия и Имя обязательны для заполнения';
            $messageClass = 'error';
        } else {
            // Создаём новую запись
            $newRecord = [
                'id' => getNextId(),
                'surname' => $_POST['surname'],
                'name' => $_POST['name'],
                'lastname' => $_POST['lastname'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'date' => $_POST['date'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'location' => $_POST['location'] ?? '',
                'email' => $_POST['email'] ?? '',
                'comment' => $_POST['comment'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $records[] = $newRecord;
            
            if (saveRecords($records)) {
                $message = 'Запись добавлена';
                $messageClass = 'success';
                // Очищаем POST для сброса формы
                $_POST = [];
            } else {
                $message = 'Ошибка: запись не добавлена';
                $messageClass = 'error';
            }
        }
    }
    
    // Выводим форму
    $html = '<div class="add-form">';
    
    if ($message) {
        $html .= "<div class=\"{$messageClass}\">{$message}</div>";
    }
    
    $html .= '<form method="post" class="form-container">';
    $html .= '<div class="form-group">';
    $html .= '<label>Фамилия *:</label>';
    $html .= '<input type="text" name="surname" value="' . htmlspecialchars($_POST['surname'] ?? '') . '" required>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Имя *:</label>';
    $html .= '<input type="text" name="name" value="' . htmlspecialchars($_POST['name'] ?? '') . '" required>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Отчество:</label>';
    $html .= '<input type="text" name="lastname" value="' . htmlspecialchars($_POST['lastname'] ?? '') . '">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Пол:</label>';
    $selected = $_POST['gender'] ?? '';
    $html .= '<select name="gender">';
    $html .= '<option value="мужской"' . ($selected == 'мужской' ? ' selected' : '') . '>мужской</option>';
    $html .= '<option value="женский"' . ($selected == 'женский' ? ' selected' : '') . '>женский</option>';
    $html .= '</select>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Дата рождения:</label>';
    $html .= '<input type="date" name="date" value="' . htmlspecialchars($_POST['date'] ?? '') . '">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Телефон:</label>';
    $html .= '<input type="text" name="phone" value="' . htmlspecialchars($_POST['phone'] ?? '') . '">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Адрес:</label>';
    $html .= '<input type="text" name="location" value="' . htmlspecialchars($_POST['location'] ?? '') . '">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Email:</label>';
    $html .= '<input type="email" name="email" value="' . htmlspecialchars($_POST['email'] ?? '') . '">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Комментарий:</label>';
    $html .= '<textarea name="comment">' . htmlspecialchars($_POST['comment'] ?? '') . '</textarea>';
    $html .= '</div>';
    
    $html .= '<button type="submit" name="add" class="form-btn">Добавить запись</button>';
    $html .= '</form>';
    $html .= '</div>';
    
    return $html;
}
?>  