<?php
// Базовый класс Lesson
class Lesson
{
    protected string $title;
    protected string $text;
    protected string $homework;

    public function __construct(string $title, string $text, string $homework)
    {
        $this->title = $title;
        $this->text = $text;
        $this->homework = $homework;
    }

    // Геттеры
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getHomework(): string
    {
        return $this->homework;
    }

    // Сеттеры
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setHomework(string $homework): void
    {
        $this->homework = $homework;
    }
}

// Класс PaidLesson (платный урок) - наследник Lesson
class PaidLesson extends Lesson
{
    private float $price;

    public function __construct(string $title, string $text, string $homework, float $price)
    {
        parent::__construct($title, $text, $homework);
        $this->price = $price;
    }

    // Геттер для price
    public function getPrice(): float
    {
        return $this->price;
    }

    // Сеттер для price
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

// Создаём объект PaidLesson с заданными свойствами
$paidLesson = new PaidLesson(
    'Урок о наследовании в PHP',
    'Лол, кек, чебурек',
    'Ложитесь спать, утро вечера мудренее',
    99.90
);

// Выводим объект с помощью var_dump()
var_dump($paidLesson);
?>