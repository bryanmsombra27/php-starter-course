<?php 
require '../helpers.php';
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;


// spl_autoload_register(function($class){
// $path = basePath('Framework/'. $class. '.php');

// if(file_exists($path)){
//     require $path;
// }

// });


// $router = new Framework\Router();
$router = new Router();

$routes = require basePath("routes.php");
$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

$router -> route($uri,$method);






?>