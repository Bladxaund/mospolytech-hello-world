<?php

class Post extends ActiveRecordEntity
{
    protected $title;
    protected $content;
    protected $category;
    protected $image;
    protected $userId;
    protected $createdAt;

    // ========== ГЕТТЕРЫ ==========
    public function getTitle(): string 
    { 
        return $this->title; 
    }
    
    public function getContent(): string 
    { 
        return $this->content; 
    }
    
    public function getCategory(): string 
    { 
        return $this->category; 
    }
    
    public function getImage(): string 
    { 
        return $this->image ?? 'default.jpg'; 
    }
    
    public function getUserId(): int 
    { 
        return $this->userId; 
    }
    
    public function getCreatedAt(): string 
    { 
        return $this->createdAt; 
    }

    // ========== СЕТТЕРЫ ==========
    public function setTitle(string $title): void 
    { 
        $this->title = $title; 
    }
    
    public function setContent(string $content): void 
    { 
        $this->content = $content; 
    }
    
    public function setCategory(string $category): void 
    { 
        $this->category = $category; 
    }
    
    public function setImage(string $image): void 
    { 
        $this->image = $image; 
    }
    
    public function setUserId(int $userId): void 
    { 
        $this->userId = $userId; 
    }

    // ========== ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ==========
    
    // Название категории на русском
    public function getCategoryName(): string
    {
        $categories = [
            'europe' => '🇪🇺 Европа',
            'asia' => '🌏 Азия',
            'america' => '🗽 Америка'
        ];
        return $categories[$this->category] ?? '🌍 Другое';
    }
    
    // Иконка категории
    public function getCategoryIcon(): string
    {
        $icons = [
            'europe' => '🇪🇺',
            'asia' => '🌏',
            'america' => '🗽'
        ];
        return $icons[$this->category] ?? '🌍';
    }
    
    // Получить автора статьи
    public function getAuthor(): ?User
    {
        return User::getById($this->userId);
    }
    
    // Получить все комментарии к статье
    public function getComments(): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM comments WHERE post_id = :post_id ORDER BY id DESC;', 
            [':post_id' => $this->id], 
            Comment::class
        );
    }
    
    // Проверка, является ли пользователь автором
    public function isAuthor(int $userId): bool
    {
        return $this->userId === $userId;
    }
    
    // Поиск статей по категории
    public static function findByCategory(string $category): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM posts WHERE category = :category ORDER BY id DESC;',
            [':category' => $category],
            self::class
        );
    }

    // ========== ИМЯ ТАБЛИЦЫ ==========
    protected static function getTableName(): string
    {
        return 'posts';
    }
}