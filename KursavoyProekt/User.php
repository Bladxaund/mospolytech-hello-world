<?php

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $password;
    protected $role;
    protected $createdAt;

    public function getNickname(): string { return $this->nickname; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setNickname(string $nickname): void { $this->nickname = $nickname; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = password_hash($password, PASSWORD_DEFAULT); }
    public function setRole(string $role): void { $this->role = $role; }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public static function findByEmail(string $email): ?self
    {
        $db = Db::getInstance();
        $users = $db->query('SELECT * FROM users WHERE email = :email;', [':email' => $email], self::class);
        return $users ? $users[0] : null;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}