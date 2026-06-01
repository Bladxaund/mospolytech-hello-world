<?php

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $role;
    protected $createdAt;

    public function getNickname(): string { return $this->nickname; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }
    public function getCreatedAt(): string { return $this->createdAt; }

    protected static function getTableName(): string
    {
        return 'users';
    }
}