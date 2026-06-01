<?php

class Comment extends ActiveRecordEntity
{
    protected $postId;
    protected $userId;
    protected $text;
    protected $createdAt;

    public function getPostId(): int { return $this->postId; }
    public function getUserId(): int { return $this->userId; }
    public function getText(): string { return $this->text; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setPostId(int $postId): void { $this->postId = $postId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }
    public function setText(string $text): void { $this->text = $text; }

    public function getUser(): ?User
    {
        return User::getById($this->userId);
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}