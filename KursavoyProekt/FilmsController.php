<?php

class FilmsController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    public function list(): void
    {
        $films = Film::findAll();
        $this->view->renderHtml('films/list.php', ['films' => $films]);
    }

    public function listByCategory(string $category): void
    {
        $type = '';
        switch ($category) {
            case 'films': $type = 'film'; break;
            case 'series': $type = 'series'; break;
            case 'cartoons': $type = 'cartoon'; break;
            default: $type = 'film';
        }
        
        $films = Film::findByType($type);
        $this->view->renderHtml('films/list.php', ['films' => $films, 'category' => $category]);
    }

    public function view(int $id): void
    {
        $film = Film::getById($id);
        
        if ($film === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        $comments = $film->getComments();
        $isLoggedIn = isset($_SESSION['user_id']);
        
        $this->view->renderHtml('films/view.php', [
            'film' => $film,
            'comments' => $comments,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function add(): void
    {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $film = new Film();
            $film->setTitle($_POST['title']);
            $film->setYear((int)$_POST['year']);
            $film->setType($_POST['type']);
            $film->setDescription($_POST['description']);
            $film->setRating((float)$_POST['rating']);
            $film->setImage($_POST['image'] ?? 'default.jpg');
            $film->save();
            
            header('Location: /films/' . $film->getId());
            exit;
        }
        
        $this->view->renderHtml('films/add.php');
    }

    public function edit(int $id): void
    {
        $this->checkAdmin();
        
        $film = Film::getById($id);
        
        if ($film === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $film->setTitle($_POST['title']);
            $film->setYear((int)$_POST['year']);
            $film->setType($_POST['type']);
            $film->setDescription($_POST['description']);
            $film->setRating((float)$_POST['rating']);
            $film->setImage($_POST['image'] ?? 'default.jpg');
            $film->save();
            
            header('Location: /films/' . $film->getId());
            exit;
        }
        
        $this->view->renderHtml('films/edit.php', ['film' => $film]);
    }

    public function delete(int $id): void
    {
        $this->checkAdmin();
        
        $film = Film::getById($id);
        
        if ($film !== null) {
            $film->delete();
        }
        
        header('Location: /films');
        exit;
    }

    public function addComment(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
            $comment = new Comment();
            $comment->setFilmId((int)$_POST['film_id']);
            $comment->setUserId($_SESSION['user_id']);
            $comment->setText($_POST['text']);
            $comment->save();
        }
        
        header('Location: /films/' . $_POST['film_id']);
        exit;
    }

    private function checkAdmin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        
        $user = User::getById($_SESSION['user_id']);
        if (!$user || $user->getRole() !== 'admin') {
            header('Location: /');
            exit;
        }
    }
}