<?php
// routes.php
return [
    '/' => 'MainController@index',
    '/about-me' => 'MainController@aboutMe',
    '/bye/{name}' => 'MainController@sayBye',  
];