<?php
require_once 'storage.php';

function handleEdit() {
    $records = loadRecords();
    $message = '';
    $messageClass = '';
    
    // Сортируем записи для списка
    $sortedRecords = $records;
    usort($sortedRecords, function($a, $b) {
        $cmp = strcmp($a['surname'], $b['surname']);
        if ($cmp == 0) return strcmp($a['name'], $b['name']);
        return $cmp;
    });
    
    // Определяем выбранную запись
    $selectedId = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 
                  (isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 
                  ($sortedRecords[0]['id'] ?? null));
    
    $currentRecord = null;
    foreach ($records as $record) {
        if ($record['id'] == $selectedId) {
            $currentRecord = $record;
            break;
        }
    }
    
    // Обработка отправки формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $updated = false;
        foreach ($records as &$record) {
            if ($record['id'] == $_POST['edit_id']) {
                $record['surname'] = $_POST['surname'];
                $record['name'] = $_POST['name'];
                $record['lastname'] = $_POST['lastname'];
                $record['gender'] = $_POST['gender'];
                $record['date'] = $_POST['date'];
                $record['phone'] = $_POST['phone'];
                $record['location'] = $_POST['location'];
                $record['email'] = $_POST['email'];
                $record['comment'] = $_POST['comment'];
                $updated = true;
                break;
            }
        }
        
        if ($updated && saveRecords($records)) {
            $message = 'Запись успешно обновлена';
            $messageClass = 'success';
            // Обновляем текущую запись
            $currentRecord = $_POST;
            $currentRecord['id'] = $_POST['edit_id'];
        } else {
            $message = 'Ошибка: запись не обновлена';
            $messageClass = 'error';
        }
    }
    
    // Выводим интерфейс
    $html = '<div class="edit-container">';
    
    // Список записей
    $html .= '<div class="records-list">';
    $html .= '<h3>Выберите запись для редактирования:</h3>';
    foreach ($sortedRecords as $record) {
        $active = ($record['id'] == $selectedId) ? ' class="current"' : '';
        $fullName = htmlspecialchars($record['surname'] . ' ' . $record['name'] . ' ' . $record['lastname']);
        $html .= "<div{$active}><a href=\"index.php?action=edit&edit_id={$record['id']}\">{$fullName}</a></div>";
    }
    $html .= '</div>';
    
    // Форма редактирования
    if ($currentRecord) {
        if ($message) {
            $html .= "<div class=\"{$messageClass}\">{$message}</div>";
        }
        
        $html .= '<form method="post" class="form-container">';
        $html .= '<input type="hidden" name="edit_id" value="' . $currentRecord['id'] . '">';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Фамилия:</label>';
        $html .= '<input type="text" name="surname" value="' . htmlspecialchars($currentRecord['surname'] ?? '') . '" required>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Имя:</label>';
        $html .= '<input type="text" name="name" value="' . htmlspecialchars($currentRecord['name'] ?? '') . '" required>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Отчество:</label>';
        $html .= '<input type="text" name="lastname" value="' . htmlspecialchars($currentRecord['lastname'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Пол:</label>';
        $selected = $currentRecord['gender'] ?? '';
        $html .= '<select name="gender">';
        $html .= '<option value="мужской"' . ($selected == 'мужской' ? ' selected' : '') . '>мужской</option>';
        $html .= '<option value="женский"' . ($selected == 'женский' ? ' selected' : '') . '>женский</option>';
        $html .= '</select>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Дата рождения:</label>';
        $html .= '<input type="date" name="date" value="' . htmlspecialchars($currentRecord['date'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Телефон:</label>';
        $html .= '<input type="text" name="phone" value="' . htmlspecialchars($currentRecord['phone'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Адрес:</label>';
        $html .= '<input type="text" name="location" value="' . htmlspecialchars($currentRecord['location'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Email:</label>';
        $html .= '<input type="email" name="email" value="' . htmlspecialchars($currentRecord['email'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Комментарий:</label>';
        $html .= '<textarea name="comment">' . htmlspecialchars($currentRecord['comment'] ?? '') . '</textarea>';
        $html .= '</div>';
        
        $html .= '<button type="submit" name="update" class="form-btn">Обновить запись</button>';
        $html .= '</form>';
    } else {
        $html .= '<p>Нет записей для редактирования</p>';
    }
    
    $html .= '</div>';
    return $html;
}
?>