<?php
require_once 'storage.php';

function handleDelete() {
    $records = loadRecords();
    $message = '';
    $messageClass = '';
    
    // Сортируем записи
    usort($records, function($a, $b) {
        return strcmp($a['surname'], $b['surname']);
    });
    
    // Обработка удаления
    if (isset($_GET['delete_id'])) {
        $deleteId = (int)$_GET['delete_id'];
        $deletedRecord = null;
        $newRecords = [];
        
        foreach ($records as $record) {
            if ($record['id'] == $deleteId) {
                $deletedRecord = $record;
            } else {
                $newRecords[] = $record;
            }
        }
        
        if ($deletedRecord && saveRecords($newRecords)) {
            $message = "Запись с фамилией {$deletedRecord['surname']} удалена";
            $messageClass = 'success';
            $records = $newRecords;
            // Пересортируем обновлённый список
            usort($records, function($a, $b) {
                return strcmp($a['surname'], $b['surname']);
            });
        } else {
            $message = "Ошибка: запись не удалена";
            $messageClass = 'error';
        }
    }
    
    // Выводим интерфейс
    $html = '<div class="delete-container">';
    
    if ($message) {
        $html .= "<div class=\"{$messageClass}\">{$message}</div>";
    }
    
    if (empty($records)) {
        $html .= '<p>Нет записей для удаления</p>';
    } else {
        $html .= '<h3>Выберите запись для удаления:</h3>';
        $html .= '<div class="records-list">';
        foreach ($records as $record) {
            $fullName = htmlspecialchars($record['surname'] . ' ' . $record['name'] . ' ' . $record['lastname']);
            $html .= "<div><a href=\"index.php?action=delete&delete_id={$record['id']}\" 
                           onclick=\"return confirm('Удалить запись: {$fullName}?')\">{$fullName}</a></div>";
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
?>