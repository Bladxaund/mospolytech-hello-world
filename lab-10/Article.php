<?php

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;

    public function getName(): string { return $this->name; }
    public function getText(): string { return $this->text; }
    public function getAuthorId(): int { return $this->authorId; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setName(string $name): void { $this->name = $name; }
    public function setText(string $text): void { $this->text = $text; }
    public function setAuthor(User $author): void { $this->authorId = $author->getId(); }

    public function getAuthor(): ?User
    {
        return User::getById($this->authorId);
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}