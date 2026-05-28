<?php
require_once 'storage.php';

function renderViewer($sort = 'created_at', $page = 1) {
    $records = loadRecords();
    
    // Сортировка
    usort($records, function($a, $b) use ($sort) {
        if ($sort == 'created_at') {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        } elseif ($sort == 'surname') {
            $cmp = strcmp($a['surname'], $b['surname']);
            if ($cmp == 0) return strcmp($a['name'], $b['name']);
            return $cmp;
        } elseif ($sort == 'date') {
            return strcmp($a['date'], $b['date']);
        }
        return 0;
    });
    
    // Пагинация
    $perPage = 10;
    $total = count($records);
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    $pageRecords = array_slice($records, $offset, $perPage);
    
    // Вывод таблицы
    $html = '<div class="viewer">';
    
    if (empty($pageRecords)) {
        $html .= '<p>Нет записей в книжке</p>';
    } else {
        $html .= '<table border="1" cellpadding="5" cellspacing="0">';
        $html .= '<tr>';
        $html .= '<th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th>';
        $html .= '<th>Дата рождения</th><th>Телефон</th><th>Адрес</th>';
        $html .= '<th>Email</th><th>Комментарий</th>';
        $html .= '</tr>';
        
        foreach ($pageRecords as $record) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($record['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['lastname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['gender']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['date']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['phone']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['location']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($record['comment']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        // Пагинация
        if ($totalPages > 1) {
            $html .= '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $active = ($i == $page) ? ' class="current"' : '';
                $html .= "<a href=\"index.php?action=view&sort={$sort}&page={$i}\"{$active}>{$i}</a>";
            }
            $html .= '</div>';
        }
    }
    
    $html .= '</div>';
    return $html;
}
?>