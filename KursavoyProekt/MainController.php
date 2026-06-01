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
        $posts = Post::findAll();
        $recentPosts = array_slice($posts, 0, 3);
        
        $this->view->renderHtml('main.php', ['recentPosts' => $recentPosts]);
    }
}