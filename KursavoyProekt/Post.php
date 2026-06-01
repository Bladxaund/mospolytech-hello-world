<?php

class Post extends ActiveRecordEntity
{
    protected $title;
    protected $content;
    protected $category;
    protected $image;
    protected $createdAt;

    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getCategory(): string { return $this->category; }
    public function getImage(): string { return $this->image; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setTitle(string $title): void { $this->title = $title; }
    public function setContent(string $content): void { $this->content = $content; }
    public function setCategory(string $category): void { $this->category = $category; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getCategoryName(): string
    {
        $categories = [
            'europe' => '🇪🇺 Европа',
            'asia' => '🌏 Азия',
            'america' => '🗽 Америка'
        ];
        return $categories[$this->category] ?? '🌍 Другое';
    }

    public function getComments(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM comments WHERE post_id = :post_id ORDER BY id DESC;', [':post_id' => $this->id], Comment::class);
    }

    public static function findByCategory(string $category): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM posts WHERE category = :category;',
            [':category' => $category],
            self::class
        );
    }

    protected static function getTableName(): string
    {
        return 'posts';
    }
}