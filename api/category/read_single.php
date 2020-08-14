<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require "../../config/Database.php";
    require "../../models/Category.php";

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if(empty($id)){
        echo json_encode(
            array('message' => 'Invalid ID', 'code' => 400)
        );
        return;
    }

    $database = new Database();
    $db = $database->connection();

    $category = new Category($db);
    $category->id = $id;
    $category->read_single();

    if (!empty($category->message)) {
        echo json_encode(
            array('message' => $category->message, 'code' => 500)
        );
        return;
    }

    echo json_encode($category);