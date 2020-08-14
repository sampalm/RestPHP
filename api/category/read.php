<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require "../../config/Database.php";
    require "../../models/Category.php";

    $database = new Database();
    $db = $database->connection();

    $category = new Category($db);
    $data = $category->read();

    if(!empty($category->message)){
        echo json_encode(
            array('message' => $category->message, 'code' => 500)
        );
        return;
    }

    $categories = array();
    $categories['data'] = array();
    
    while($row = $data->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at
        );

        array_push($categories['data'], $item);
    }

    $categories['status'] = array('message' => 'Request completed', 'code' => 200);
    echo json_encode($categories);