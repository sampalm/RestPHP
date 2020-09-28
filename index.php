<?php

use CoffeeCode\Router\Router;
use Source\App\Post;

require __DIR__ . "/vendor/autoload.php";

$router = new Router(URL_BASE);
$router->namespace("Source\App\Api");

$router->group(null);
$router->get("/", "Post:index");

$router->group("/blog");
$router->get("/", "Post:index");

/**
 * This method executes the routes
 */
$router->dispatch();

/*
 * Redirect all errors
 */
if ($router->error()) {
   // $router->redirect("/error/{$router->error()}");
}