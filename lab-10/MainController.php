<?php

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main.php', ['articles' => $articles ?? []]);
    }
}