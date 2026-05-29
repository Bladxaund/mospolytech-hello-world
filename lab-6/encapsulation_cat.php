<?php
class Cat
{
    private string $name;
    private string $color; // Сделали свойство color приватным

    // Конструктор с добавленным аргументом color
    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    // Геттер для получения цвета
    public function getColor(): string
    {
        return $this->color;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // Дополненный метод sayHello()
    public function sayHello(): string
    {
        return "Мяу! Меня зовут {$this->name}. Я {$this->color} цвета.";
    }
}

// Пример использования
$cat = new Cat('Барсик', 'рыжего');
echo $cat->sayHello();

// Результат: Мяу! Меня зовут Барсик. Я рыжего цвета.
?>