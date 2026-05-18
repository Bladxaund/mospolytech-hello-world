<?php
function buildDeleteList($pdo) {
    $message = '';
    
    // Проверяем, было ли удаление
    if (isset($_GET['deleted'])) {
        $message = '<p class="success">Запись удалена</p>';
    }
    
    // Получаем список контактов
    $stmt = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($contacts)) {
        return $message . '<p>Нет записей для удаления.</p>';
    }
    
    $html = $message;
    $html .= '<div class="delete-list">';
    foreach ($contacts as $contact) {
        $initials = $contact['surname'] . ' ' . mb_substr($contact['name'], 0, 1) . '.';
        if (!empty($contact['lastname'])) {
            $initials .= mb_substr($contact['lastname'], 0, 1) . '.';
        }
        $html .= "<div style='margin:10px 0;'>
                    <a href='index.php?action=delete&delete_id={$contact['id']}' 
                       onclick='return confirm(\"Удалить запись \\\"$initials\\\"?\");'
                       style='padding:5px 10px; text-decoration:none; border:1px solid #ccc; display:inline-block;'>
                       $initials
                    </a>
                  </div>";
    }
    $html .= '</div>';
    
    return $html;
}

// Функция удаления контакта
function deleteContact($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
?>