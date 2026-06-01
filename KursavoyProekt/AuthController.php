<?php

class AuthController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/templates');
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = User::findByEmail($email);
            
            if ($user && $user->verifyPassword($password)) {
                $_SESSION['user_id'] = $user->getId();
                header('Location: /');
                exit;
            }
            
            $error = 'Неверный email или пароль';
            $this->view->renderHtml('auth/login.php', ['error' => $error]);
            return;
        }
        
        $this->view->renderHtml('auth/login.php');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $existingUser = User::findByEmail($email);
            
            if ($existingUser) {
                $error = 'Пользователь с таким email уже существует';
                $this->view->renderHtml('auth/register.php', ['error' => $error]);
                return;
            }
            
            $user = new User();
            $user->setNickname($nickname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRole('user');
            $user->save();
            
            $_SESSION['user_id'] = $user->getId();
            header('Location: /');
            exit;
        }
        
        $this->view->renderHtml('auth/register.php');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}