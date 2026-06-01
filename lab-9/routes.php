<?php

return [
    '~^/articles/(\d+)$~' => ['ArticlesController', 'view'],
    '~^/?$~' => ['MainController', 'main'],
];