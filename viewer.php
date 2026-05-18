<?php
function buildViewer($pdo, $sort, $page) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    // Определяем сортировку
    switch($sort) {
        case 'surname':
            $orderBy = "surname ASC, name ASC";
            break;
        case 'birthdate':
            $orderBy = "birthdate ASC";
            break;
        default:
            $orderBy = "created_at ASC";
    }
    
    // Получаем общее количество записей
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $total = $totalStmt->fetchColumn();
    $totalPages = ceil($total / $limit);
    
    // Получаем записи для текущей страницы
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $orderBy LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Формируем таблицу
    $html = '<table border="1" cellpadding="8" cellspacing="0">';
    $html .= '<tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Email</th>
                <th>Комментарий</th>
              </tr>';
    
    foreach ($contacts as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($contact['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['lastname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['birthdate']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['location']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    
    // Пагинация
    if ($totalPages > 1) {
        $html .= '<div class="pagination" style="margin-top: 20px;">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $class = ($i == $page) ? 'current-page' : '';
            $html .= "<a href='index.php?action=view&sort=$sort&page=$i' style='margin:0 5px; padding:5px 10px; border:1px solid #ccc; text-decoration:none; $class'>$i</a>";
        }
        $html .= '</div>';
    }
    
    return $html;
}
?><?php
function buildViewer($pdo, $sort, $page) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    // Определяем сортировку
    switch($sort) {
        case 'surname':
            $orderBy = "surname ASC, name ASC";
            break;
        case 'birthdate':
            $orderBy = "birthdate ASC";
            break;
        default:
            $orderBy = "created_at ASC";
    }
    
    // Получаем общее количество записей
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $total = $totalStmt->fetchColumn();
    $totalPages = ceil($total / $limit);
    
    // Получаем записи для текущей страницы
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $orderBy LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Формируем таблицу
    $html = '<table border="1" cellpadding="8" cellspacing="0">';
    $html .= '<tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Email</th>
                <th>Комментарий</th>
              </tr>';
    
    foreach ($contacts as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($contact['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['lastname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['birthdate']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['location']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    
    // Пагинация
    if ($totalPages > 1) {
        $html .= '<div class="pagination" style="margin-top: 20px;">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $class = ($i == $page) ? 'current-page' : '';
            $html .= "<a href='index.php?action=view&sort=$sort&page=$i' style='margin:0 5px; padding:5px 10px; border:1px solid #ccc; text-decoration:none; $class'>$i</a>";
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>