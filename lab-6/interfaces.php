<?php

declare(strict_types=1);

interface CalculateSquare
{
    public function calculateSquare(): float;
}

class Circle implements CalculateSquare
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSquare(): float
    {
        return pi() * $this->radius * $this->radius;
    }
}

class Rectangle implements CalculateSquare
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

class User
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

function printSquareInfo(object $object): void
{
    $className = get_class($object);

    if ($object instanceof CalculateSquare) {
        echo 'Объект класса ' . $className . ' реализует интерфейс CalculateSquare.' . PHP_EOL;
        echo 'Площадь: ' . round($object->calculateSquare(), 2) . PHP_EOL;
        return;
    }

    echo 'Объект класса ' . $className . ' не реализует интерфейс CalculateSquare.' . PHP_EOL;
}

$objects = [
    new Circle(5),
    new Rectangle(4, 6),
    new User('Иван'),
];

foreach ($objects as $object) {
    printSquareInfo($object);
    echo PHP_EOL;
}