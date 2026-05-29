<?php
// Интерфейс для фигур, у которых можно вычислить площадь
interface CalculateSquare
{
    public function calculateSquare(): float;
}

// Класс Круг
class Circle implements CalculateSquare
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSquare(): float
    {
        return pi() * pow($this->radius, 2);
    }
}

// Класс Прямоугольник
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

// Класс Квадрат
class Square implements CalculateSquare
{
    private float $side;

    public function __construct(float $side)
    {
        $this->side = $side;
    }

    public function calculateSquare(): float
    {
        return pow($this->side, 2);
    }
}

// Класс, который НЕ реализует интерфейс CalculateSquare
class Triangle
{
    private float $base;
    private float $height;

    public function __construct(float $base, float $height)
    {
        $this->base = $base;
        $this->height = $height;
    }

    // У треугольника нет метода calculateSquare()
}

// Функция для вывода информации о площади
function printSquare($object)
{
    if ($object instanceof CalculateSquare) {
        $className = get_class($object);
        $square = $object->calculateSquare();
        echo "Объект класса {$className} имеет площадь: {$square}\n";
    } else {
        $className = get_class($object);
        echo "Объект класса {$className} не реализует интерфейс CalculateSquare.\n";
    }
}

// Создаём объекты
$circle = new Circle(5);
$rectangle = new Rectangle(4, 6);
$square = new Square(3);
$triangle = new Triangle(5, 8);

// Проверяем
printSquare($circle);     // Объект класса Circle имеет площадь: 78.539816339745
printSquare($rectangle);  // Объект класса Rectangle имеет площадь: 24
printSquare($square);     // Объект класса Square имеет площадь: 9
printSquare($triangle);   // Объект класса Triangle не реализует интерфейс CalculateSquare.
?>