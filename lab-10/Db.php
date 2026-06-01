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
                    ['id' => 1, 'nickname' => 'admin', 'email' => 'admin@gmail.com', 'role' => 'admin', 'created_at' => date('Y-m-d H:i:s')],
                    ['id' => 2, 'nickname' => 'user', 'email' => 'user@gmail.com', 'role' => 'user', 'created_at' => date('Y-m-d H:i:s')]
                ],
                'articles' => [
                    ['id' => 1, 'author_id' => 1, 'name' => 'Статья №1', 'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'created_at' => date('Y-m-d H:i:s')],
                    ['id' => 2, 'author_id' => 1, 'name' => 'Статья №2', 'text' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'created_at' => date('Y-m-d H:i:s')]
                ],
                'next_id' => ['users' => 3, 'articles' => 3]
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
        
        // SELECT * FROM articles
        if (strpos($sql, 'SELECT * FROM articles') !== false) {
            $results = $data['articles'];
            
            if (isset($params[':id'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['id'] == $params[':id'];
                }));
            }
            
            if (isset($params[':author_id'])) {
                $results = array_values(array_filter($results, function($item) use ($params) {
                    return $item['author_id'] == $params[':author_id'];
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
            $newItem['created_at'] = date('Y-m-d H:i:s');
            
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