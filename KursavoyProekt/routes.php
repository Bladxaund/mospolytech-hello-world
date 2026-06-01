<?php

return [
    '~^/$~' => ['MainController', 'main'],
    '~^/posts$~' => ['PostsController', 'list'],
    '~^/posts/filter/(\w+)$~' => ['PostsController', 'filter'],
    '~^/posts/(\d+)$~' => ['PostsController', 'view'],
    '~^/posts/(\d+)/edit$~' => ['PostsController', 'edit'],
    '~^/posts/add$~' => ['PostsController', 'add'],
    '~^/posts/delete/(\d+)$~' => ['PostsController', 'delete'],
    '~^/comments/add$~' => ['PostsController', 'addComment'],
    '~^/auth/login$~' => ['AuthController', 'login'],
    '~^/auth/register$~' => ['AuthController', 'register'],
    '~^/auth/logout$~' => ['AuthController', 'logout'],
];