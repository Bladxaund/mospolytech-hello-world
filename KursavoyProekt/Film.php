<?php

class Film extends ActiveRecordEntity
{
    protected $title;
    protected $year;
    protected $type;
    protected $description;
    protected $rating;
    protected $image;
    protected $createdAt;

    public function getTitle(): string { return $this->title; }
    public function getYear(): int { return $this->year; }
    public function getType(): string { return $this->type; }
    public function getDescription(): string { return $this->description; }
    public function getRating(): float { return $this->rating; }
    public function getImage(): string { return $this->image; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setTitle(string $title): void { $this->title = $title; }
    public function setYear(int $year): void { $this->year = $year; }
    public function setType(string $type): void { $this->type = $type; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setRating(float $rating): void { $this->rating = $rating; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getTypeName(): string
    {
        $types = [
            'film' => 'Фильм',
            'series' => 'Сериал',
            'cartoon' => 'Мультсериал'
        ];
        return $types[$this->type] ?? $this->type;
    }

    public function getStarRating(): string
    {
        $fullStars = floor($this->rating / 2);
        $halfStar = ($this->rating / 2 - $fullStars) >= 0.5;
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $fullStars) {
                $stars .= '★';
            } elseif ($halfStar && $i == $fullStars + 1) {
                $stars .= '½';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }

    public function getComments(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM comments WHERE film_id = :film_id ORDER BY id DESC;', [':film_id' => $this->id], Comment::class);
    }

    protected static function getTableName(): string
    {
        return 'films';
    }
}