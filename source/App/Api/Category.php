<?php

namespace Source\App\Api;

use Core\Controller;

class Category extends Controller {
    public function index() 
    {
        // "title = :title AND name = :name", "title={$title}&name={$name}"
        $cat = (new \Source\Models\Category())->find()->fetch(true);
        var_dump($cat);
    }
}