<?php

return [
    '~^/articles/(\d+)$~' => ['ArticlesController', 'view'],
    '~^/articles/(\d+)/edit$~' => ['ArticlesController', 'edit'],
    '~^/articles/add$~' => ['ArticlesController', 'add'],
    '~^/?$~' => ['MainController', 'main'],
];