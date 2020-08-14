<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if(empty($id)){
        echo json_encode(
            array('message' => 'ID invalid or not found', 'code' => '400')
        );
        return;
    }

    $database = new Database();
    $db = $database->connection();

    $category = new Category($db);
    $category->id = $id;
    $category->delete();

    if(!empty($category->message)) {
        echo json_encode(
            array('message' => $category->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Category with ID {$category->id} was successfully deleted.", 'code' => 200)
    );