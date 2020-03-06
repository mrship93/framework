<?php

error_reporting(-1);
use vendor\core\Router;

$query = $_SERVER['QUERY_STRING'];

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');



require '../vendor/libs/functions.php';
//Router::add('posts/add', ['controller' => 'Posts', 'action' => 'add']);
//Router::add('posts/', ['controller' => 'Posts', 'action' => 'index']);
//Router::add('', ['controller' => 'Mqin', 'action' => 'index']);

spl_autoload_register(function($class) {
    $file = ROOT . '/' . $class . '.php';
    if (is_file($file)) {
        require_once ($file);
    }
});

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
//Router::add('([a-z]+)/([a-z]+)');
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');


Router::dispatch($query);


