<?php

class PostsController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    public function list(): void
    {
        $posts = Post::findAll();
        $this->view->renderHtml('posts/list.php', ['posts' => $posts]);
    }

    public function filter(string $category): void
    {
        $posts = Post::findByCategory($category);
        $currentCategory = $category;
        $this->view->renderHtml('posts/list.php', [
            'posts' => $posts,
            'currentCategory' => $currentCategory
        ]);
    }

    public function view(int $id): void
    {
        $post = Post::getById($id);
        
        if ($post === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        $comments = $post->getComments();
        $isLoggedIn = isset($_SESSION['user_id']);
        
        $this->view->renderHtml('posts/view.php', [
            'post' => $post,
            'comments' => $comments,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function add(): void
    {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setContent($_POST['content']);
            $post->setCategory($_POST['category']);
            $post->setImage($_POST['image'] ?? 'default.jpg');
            $post->save();
            
            header('Location: /posts/' . $post->getId());
            exit;
        }
        
        $this->view->renderHtml('posts/add.php');
    }

    public function edit(int $id): void
    {
        $this->checkAdmin();
        
        $post = Post::getById($id);
        
        if ($post === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post->setTitle($_POST['title']);
            $post->setContent($_POST['content']);
            $post->setCategory($_POST['category']);
            $post->setImage($_POST['image'] ?? 'default.jpg');
            $post->save();
            
            header('Location: /posts/' . $post->getId());
            exit;
        }
        
        $this->view->renderHtml('posts/edit.php', ['post' => $post]);
    }

    public function delete(int $id): void
    {
        $this->checkAdmin();
        
        $post = Post::getById($id);
        
        if ($post !== null) {
            $post->delete();
        }
        
        header('Location: /posts');
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
            $comment->setPostId((int)$_POST['post_id']);
            $comment->setUserId($_SESSION['user_id']);
            $comment->setText($_POST['text']);
            $comment->save();
        }
        
        header('Location: /posts/' . $_POST['post_id']);
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