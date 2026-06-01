<?php

class MainController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
        $this->db = new Db();
    }

    public function main()
    {
        $articles = $this->db->query('SELECT * FROM articles ORDER BY id DESC;', [], 'Article');
        $this->view->renderHtml('main.php', ['articles' => $articles ?? []]);
    }
}