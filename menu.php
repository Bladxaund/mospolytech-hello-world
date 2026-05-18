<?php
function buildMenu($active, $sort) {
    $menuItems = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $html = '<header>';
    foreach ($menuItems as $key => $label) {
        $class = ($active == $key) ? 'select' : '';
        $html .= "<a href='index.php?action=$key&sort=$sort' class='$class'>$label</a>";
    }
    $html .= '</header>';
    
    // Дополнительные пункты сортировки для просмотра
    if ($active == 'view') {
        $sortItems = [
            'created' => 'По дате добавления',
            'surname' => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        $html .= '<div class="submenu">';
        foreach ($sortItems as $key => $label) {
            $class = ($sort == $key) ? 'select' : '';
            $html .= "<a href='index.php?action=view&sort=$key' class='$class'>$label</a>";
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>