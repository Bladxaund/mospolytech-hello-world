<?php

class User
{
    private $id;
    private $nickname;
    private $email;
    private $role;
    private $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function getId(): int { return $this->id; }
    public function getNickname(): string { return $this->nickname; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}