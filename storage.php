<?php
// Файл для работы с хранилищем JSON
define('DATA_FILE', 'data.json');

function loadRecords() {
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    
    $json = file_get_contents(DATA_FILE);
    $data = json_decode($json, true);
    
    if (!$data || !isset($data['records'])) {
        return [];
    }
    
    return $data['records'];
}

function saveRecords($records) {
    $data = [
        'records' => $records,
        'last_updated' => date('Y-m-d H:i:s')
    ];
    
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents(DATA_FILE, $json) !== false;
}

function getNextId() {
    $records = loadRecords();
    $maxId = 0;
    
    foreach ($records as $record) {
        if (isset($record['id']) && $record['id'] > $maxId) {
            $maxId = $record['id'];
        }
    }
    
    return $maxId + 1;
}
?>