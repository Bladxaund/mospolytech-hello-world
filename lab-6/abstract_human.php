<?php
// Абстрактный класс Human
abstract class HumanAbstract
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getGreetings(): string;
    abstract public function getMyNameIs(): string;

    public function introduceYourself(): string
    {
        return $this->getGreetings() . '! ' .
               $this->getMyNameIs() . ' ' . $this->getName() . '.';
    }
}

// Класс для русского человека
class RussianHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Привет';
    }

    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}

// Класс для английского человека
class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';
    }

    public function getMyNameIs(): string
    {
        return 'My name is';
    }
}

// Создаём объекты и заставляем их поздороваться
$russian = new RussianHuman('Иван');
$english = new EnglishHuman('John');

echo $russian->introduceYourself() . "\n";
echo $english->introduceYourself() . "\n";

// Результат:
// Привет! Меня зовут Иван.
// Hello! My name is John.
?>