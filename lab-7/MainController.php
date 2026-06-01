<?php
// MainController.php

class MainController
{
    public function index()
    {
        include 'home.php';
    }
    
    public function aboutMe()
    {
        echo "Страница обо мне";
    }
    
    public function sayBye($name)
    {
        echo "Пока, $name";
    }
}