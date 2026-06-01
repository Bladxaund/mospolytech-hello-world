<?php

class Db
{
    private $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__ . '/data.json';
        $this->initData();
    }

    private function initData()
    {
        if (!file_exists($this->dataFile)) {
            $initialData = [
                'users' => [
                    ['id' => 1, 'nickname' => 'admin', 'email' => 'admin@gmail.com', 'role' => 'admin'],
                    ['id' => 2, 'nickname' => 'user', 'email' => 'user@gmail.com', 'role' => 'user']
                ],
                'articles' => [
                    ['id' => 1, 'author_id' => 1, 'name' => 'Статья №1', 'text' => 'Lorem ipsum dolor sit amet', 'created_at' => date('Y-m-d H:i:s')],
                    ['id' => 2, 'author_id' => 1, 'name' => 'Статья №2', 'text' => 'Consectetur adipiscing elit', 'created_at' => date('Y-m-d H:i:s')]
                ],
                'next_id' => [
                    'users' => 3,
                    'articles' => 3
                ]
            ];
            file_put_contents($this->dataFile, json_encode($initialData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    private function loadData()
    {
        $json = file_get_contents($this->dataFile);
        return json_decode($json, true);
    }

    private function saveData($data)
    {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $data = $this->loadData();
        
        // Простой "парсер" SQL для SELECT
        if (strpos($sql, 'SELECT * FROM articles') !== false) {
            $results = $data['articles'];
            
            // Фильтр по id
            if (isset($params[':id'])) {
                $results = array_filter($results, function($item) use ($params) {
                    return $item['id'] == $params[':id'];
                });
                $results = array_values($results);
            }
            
            // Фильтр по author_id
            if (isset($params[':author_id'])) {
                $results = array_filter($results, function($item) use ($params) {
                    return $item['author_id'] == $params[':author_id'];
                });
                $results = array_values($results);
            }
            
            // Создаём объекты нужного класса
            if ($className !== 'stdClass') {
                $objects = [];
                foreach ($results as $row) {
                    $obj = new $className();
                    foreach ($row as $key => $value) {
                        $obj->__set($key, $value);
                    }
                    $objects[] = $obj;
                }
                return $objects;
            }
            
            return $results;
        }
        
        // SELECT * FROM users
        if (strpos($sql, 'SELECT * FROM users') !== false) {
            $results = $data['users'];
            
            if (isset($params[':id'])) {
                $results = array_filter($results, function($item) use ($params) {
                    return $item['id'] == $params[':id'];
                });
                $results = array_values($results);
            }
            
            if ($className !== 'stdClass') {
                $objects = [];
                foreach ($results as $row) {
                    $obj = new $className();
                    foreach ($row as $key => $value) {
                        $obj->__set($key, $value);
                    }
                    $objects[] = $obj;
                }
                return $objects;
            }
            
            return $results;
        }
        
        return [];
    }
}