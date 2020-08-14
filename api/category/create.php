<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data->name)){
        echo json_encode(
            array('message' => 'Invalid or Empty field name', 'code' => 400)
        );
        return;
    }

    $database = new Database();
    $db = $database->connection();

    $category = new Category($db);
    $category->name = $data->name;
    $category->create();

    if(!empty($category->message)) {
        echo json_encode(
            array('message' => $category->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Category was successfully created.", 'code' => 201)
    );