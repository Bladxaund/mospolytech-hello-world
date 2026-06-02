<?php

class PostsController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    // Проверка, может ли пользователь редактировать/удалять статью
    private function canModify(Post $post): bool
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        $user = User::getById($_SESSION['user_id']);
        
        if (!$user) {
            return false;
        }
        
        // Админ может всё
        if ($user->isAdmin()) {
            return true;
        }
        
        // Обычный пользователь может редактировать только СВОИ статьи
        return $post->getUserId() == $user->getId();
    }

    // Список всех статей
    public function list(): void
    {
        $posts = Post::findAll();
        // Сортируем по убыванию ID (новые сверху)
        usort($posts, function($a, $b) {
            return $b->getId() - $a->getId();
        });
        $this->view->renderHtml('posts/list.php', ['posts' => $posts]);
    }

    // Фильтр по категориям
    public function filter(string $category): void
    {
        $posts = Post::findByCategory($category);
        usort($posts, function($a, $b) {
            return $b->getId() - $a->getId();
        });
        $currentCategory = $category;
        $this->view->renderHtml('posts/list.php', [
            'posts' => $posts,
            'currentCategory' => $currentCategory
        ]);
    }

    // Просмотр одной статьи
    public function view(int $id): void
    {
        $post = Post::getById($id);
        
        if ($post === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        $comments = $post->getComments();
        $isLoggedIn = isset($_SESSION['user_id']);
        $canModify = $this->canModify($post);
        
        $this->view->renderHtml('posts/view.php', [
            'post' => $post,
            'comments' => $comments,
            'isLoggedIn' => $isLoggedIn,
            'canModify' => $canModify
        ]);
    }

    // Добавление статьи
    public function add(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $category = $_POST['category'];
            $imageUrl = trim($_POST['image_url'] ?? '');
            
            if (empty($title)) {
                $error = 'Заголовок не может быть пустым';
            } elseif (empty($content)) {
                $error = 'Содержание не может быть пустым';
            } else {
                $post = new Post();
                $post->setUserId($_SESSION['user_id']);
                $post->setTitle($title);
                $post->setContent($content);
                $post->setCategory($category);
                
                // Сохраняем URL изображения (если есть)
                if (!empty($imageUrl)) {
                    $post->setImage($imageUrl);
                } else {
                    $post->setImage('default.jpg');
                }
                
                $post->save();
                
                header('Location: /posts/' . $post->getId());
                exit;
            }
        }
        
        $this->view->renderHtml('posts/add.php', ['error' => $error]);
    }

    // Редактирование статьи
    public function edit(int $id): void
    {
        $post = Post::getById($id);
        
        if ($post === null) {
            $this->view->renderHtml('404.php', [], 404);
            return;
        }
        
        if (!$this->canModify($post)) {
            header('Location: /posts/' . $id);
            exit;
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $category = $_POST['category'];
            $imageUrl = trim($_POST['image_url'] ?? '');
            
            if (empty($title)) {
                $error = 'Заголовок не может быть пустым';
            } elseif (empty($content)) {
                $error = 'Содержание не может быть пустым';
            } else {
                $post->setTitle($title);
                $post->setContent($content);
                $post->setCategory($category);
                
                // Обновляем изображение, если ввели новую ссылку
                if (!empty($imageUrl)) {
                    $post->setImage($imageUrl);
                }
                
                $post->save();
                
                header('Location: /posts/' . $post->getId());
                exit;
            }
        }
        
        $this->view->renderHtml('posts/edit.php', [
            'post' => $post,
            'error' => $error
        ]);
    }

    // Удаление статьи
    public function delete(int $id): void
    {
        $post = Post::getById($id);
        
        if ($post !== null && $this->canModify($post)) {
            $post->delete();
        }
        
        header('Location: /posts');
        exit;
    }

    // Добавление комментария
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
            $comment->setText(trim($_POST['text']));
            $comment->save();
        }
        
        header('Location: /posts/' . $_POST['post_id']);
        exit;
    }
}