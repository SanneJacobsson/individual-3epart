<?php
// globala initieringar !
require_once(dirname(__FILE__) . "/Utils/Router.php");

// $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/Pages/index.php';
});

$router->addRoute('/allproducts', function () {
    require __DIR__ . '/Pages/allproducts.php';
});

$router->addRoute('/category', function () {
    require __DIR__ . '/Pages/category.php';
});

$router->addRoute('/viewproduct', function () {
    require __DIR__ . '/Pages/viewproduct.php';
});

$router->dispatch();
?>