<?php

class Db
{
    private static $instance;
    private $dataFile;
    private $lastInsertId;

    private function __construct()
    {
        $this->dataFile = __DIR__ . '/data.json';
        $this->initData();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initData()
    {
        if (!file_exists($this->dataFile)) {
            $initialData = [
                'users' => [
                    [
                        'id' => 1,
                        'nickname' => 'admin',
                        'email' => 'admin@travel.com',
                        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                        'role' => 'admin',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' => 2,
                        'nickname' => 'user',
                        'email' => 'user@travel.com',
                        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                        'role' => 'user',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ],
                'posts' => [
                    [
                        'id' => 1,
                        'title' => 'Париж - город мечты',
                        'content' => 'Париж - это невероятный город с красивой архитектурой, вкусной едой и романтичной атмосферой. Эйфелева башня, Лувр, Нотр-Дам - обязательно посетите!',
                        'category' => 'europe',
                        'image' => 'paris.jpg',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' => 2,
                        'title' => 'Путешествие в Токио',
                        'content' => 'Токио - это город будущего. Неоновые огни, вкуснейшая еда, добрые люди. Обязательно попробуйте суши и покатайтесь на скоростных поездах.',
                        'category' => 'asia',
                        'image' => 'tokyo.jpg',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' => 3,
                        'title' => 'Нью-Йорк - город, который никогда не спит',
                        'content' => 'Таймс-сквер, Центральный парк, Статуя Свободы - это места, которые нужно увидеть каждому. Нью-Йорк впечатляет своей энергией.',
                        'category' => 'america',
                        'image' => 'ny.jpg',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ],
                'comments' => [],
                'next_id' => ['users' => 3, 'posts' => 4, 'comments' => 1]
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
        
        // SELECT * FROM posts
        if (strpos($sql, 'SELECT * FROM posts') !== false) {
            $results = $data['posts'];
            
            if (isset($params[':id'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['id'] == $params[':id'];
                }));
            }
            
            if (isset($params[':category'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['category'] == $params[':category'];
                }));
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
        
        // SELECT * FROM users
        if (strpos($sql, 'SELECT * FROM users') !== false) {
            $results = $data['users'];
            
            if (isset($params[':email'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['email'] == $params[':email'];
                }));
            }
            
            if (isset($params[':id'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['id'] == $params[':id'];
                }));
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
        
        // SELECT * FROM comments
        if (strpos($sql, 'SELECT * FROM comments') !== false) {
            $results = $data['comments'];
            
            if (isset($params[':post_id'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['post_id'] == $params[':post_id'];
                }));
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
        
        // UPDATE
        if (strpos($sql, 'UPDATE') !== false) {
            preg_match('/UPDATE (\w+) SET (.+) WHERE id = (\d+)/', $sql, $matches);
            $table = $matches[1];
            $id = (int)$matches[3];
            
            $setPairs = explode(', ', $matches[2]);
            foreach ($setPairs as $pair) {
                list($column, $param) = explode(' = ', $pair);
                $value = $params[$param];
                foreach ($data[$table] as &$item) {
                    if ($item['id'] == $id) {
                        $item[$column] = $value;
                    }
                }
            }
            $this->saveData($data);
            return [];
        }
        
        // INSERT
        if (strpos($sql, 'INSERT INTO') !== false) {
            preg_match('/INSERT INTO (\w+) \((.+)\) VALUES \((.+)\)/', $sql, $matches);
            $table = $matches[1];
            $columns = explode(', ', $matches[2]);
            $placeholders = explode(', ', $matches[3]);
            
            $newItem = ['id' => $data['next_id'][$table]];
            foreach ($columns as $i => $column) {
                $column = trim($column, '`');
                $placeholder = $placeholders[$i];
                $newItem[$column] = $params[$placeholder];
            }
            
            if ($table === 'comments' || $table === 'posts') {
                $newItem['created_at'] = date('Y-m-d H:i:s');
            }
            
            $data[$table][] = $newItem;
            $data['next_id'][$table]++;
            $this->lastInsertId = $newItem['id'];
            $this->saveData($data);
            return [];
        }
        
        // DELETE
        if (strpos($sql, 'DELETE FROM') !== false) {
            preg_match('/DELETE FROM `?(\w+)`? WHERE id = :id/', $sql, $matches);
            $table = $matches[1];
            $id = $params[':id'];
            
            $data[$table] = array_values(array_filter($data[$table], function($item) use ($id) {
                return $item['id'] != $id;
            }));
            $this->saveData($data);
            return [];
        }
        
        return [];
    }

    public function getLastInsertId(): int
    {
        return $this->lastInsertId;
    }
}