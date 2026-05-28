<?php
function renderMenu($currentAction, $currentSort = 'created_at') {
    $menuItems = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $html = '<div class="menu">';
    
    // Основное меню
    foreach ($menuItems as $action => $title) {
        $active = ($currentAction == $action) ? ' class="active"' : '';
        $html .= "<a href=\"index.php?action={$action}\"{$active}>{$title}</a>";
    }
    
    $html .= '</div>';
    
    // Дополнительное меню (только для просмотра)
    if ($currentAction == 'view') {
        $html .= '<div class="submenu">';
        
        $sortItems = [
            'created_at' => 'По порядку добавления',
            'surname' => 'По фамилии',
            'date' => 'По дате рождения'
        ];
        
        foreach ($sortItems as $sortKey => $sortTitle) {
            $active = ($currentSort == $sortKey) ? ' class="active"' : '';
            $html .= "<a href=\"index.php?action=view&sort={$sortKey}&page=1\"{$active}>{$sortTitle}</a>";
        }
        
        $html .= '</div>';
    }
    
    return $html;
}
?>