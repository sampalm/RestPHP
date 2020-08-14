<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data->id)) {
        echo json_encode(
            array('message' => 'Invalid or empty field id', 'code' => 400)
        );
        return;
    }
    if(empty($data->name)) {
        echo json_encode(
            array('message' => 'Invalid or empty field name', 'code' => 400)
        );
        return;
    }

    $database = new Database();
    $db = $database->connection();

    $category = new Category($db);
    $category->id = $data->id;
    $category->name = $data->name;
    $category->update();

    if(!empty($category->message)) {
        echo json_encode(
            array('message' => $category->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Category with ID {$category->id} was successfully updated.", 'code' => 200)
    );