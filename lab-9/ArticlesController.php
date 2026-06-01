<?php

class ArticlesController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        $result = $this->db->query('SELECT * FROM articles WHERE id = :id;', [':id' => $articleId], 'Article');

        if (empty($result)) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }

        $article = $result[0];
        
        $authorResult = $this->db->query('SELECT * FROM users WHERE id = :author_id;', [':author_id' => $article->getAuthorId()], 'User');
        $author = !empty($authorResult) ? $authorResult[0] : null;
        
        $this->view->renderHtml('view.php', ['article' => $article, 'author' => $author]);
    }
}