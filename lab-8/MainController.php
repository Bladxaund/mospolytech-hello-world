<?php
// MainController.php

class MainController
{
    public function index()
    {
        $title = null;
        $content = file_get_contents('home.php');
        include 'template.php';
    }
    
    public function aboutMe()
    {
        $title = "Обо мне";
        $content = "<h1>Обо мне</h1><p>Это страница с информацией обо мне.</p>";
        include 'template.php';
    }
    
    public function sayHello($name)
    {
        $name = urldecode($name);
        $title = "Страница приветствия";
        $content = "<h1>Привет, $name!</h1><p>Добро пожаловать на наш сайт!</p>";
        include 'template.php';
    }
    
    public function sayBye($name)
    {
        $name = urldecode($name);
        echo "Пока, $name";
    }
}
?>