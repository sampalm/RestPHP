<?php

use CoffeeCode\Router\Router;
use Source\App\Post;

require __DIR__ . "/vendor/autoload.php";

$router = new Router(URL_BASE);
$router->namespace("Source\App\Api");

$router->group("post");
$router->get("/", "Post:index");
$router->post("/create", "Post:create");
$router->post("/update", "Post:update");
$router->post("/delete", "Post:delete");

$router->group("category");
$router->get("/", "Category:index");
$router->post("/create", "Category:create");
$router->post("/update", "Category:update");
$router->post("/delete", "Category:delete");

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