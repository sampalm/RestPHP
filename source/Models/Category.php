<?php 

namespace Source\Models;

use Core\Model;

class Category extends Model {

    public function __construct()
    {
        parent::__construct("categories", []);
    }

}