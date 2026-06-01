<?php

class ArticlesController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }

        $this->view->renderHtml('view.php', ['article' => $article]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->save();

            header('Location: /articles/' . $article->getId());
            exit;
        }

        $this->view->renderHtml('edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = User::getById(1);
            $article = new Article();
            $article->setAuthor($author);
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->save();

            header('Location: /articles/' . $article->getId());
            exit;
        }

        $this->view->renderHtml('add.php');
    }
}