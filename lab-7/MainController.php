<?php
// app/Controllers/MainController.php

class MainController
{
    public function index()
    {
        return view('home');
    }
    
    public function aboutMe()
    {
        return view('about');
    }
    
    // ЭТОТ МЕТОД ДОБАВИТЬ
    public function sayBye($name)
    {
        echo "Пока, $name";
    }
}