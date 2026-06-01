<?php
// routes.php
return [
    '/' => 'MainController@index',
    '/about-me' => 'MainController@aboutMe',
    '/hello/{name}' => 'MainController@sayHello',
    '/bye/{name}' => 'MainController@sayBye',
];