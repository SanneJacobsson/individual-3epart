<?php

require_once(dirname(__FILE__) . "/Utils/Router.php");

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/Pages/main.php';
});

$router->addRoute('/addproduct', function () {
    require __DIR__ . '/Pages/addProduct.php';
});

$router->addRoute('/viewproduct', function () {
    require __DIR__ . '/Pages/viewProduct.php';
});

$router->dispatch();
?>