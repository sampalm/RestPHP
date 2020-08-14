<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');

    require '../../config/Database.php';
    require '../../models/Post.php';

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data->id)){
        echo json_encode(
            array('message' => 'Invalid ID', 'code' => 400)
        );
        return;
    }
    if(empty($data->category_id)){
        echo json_encode(
            array('message' => 'Invalid category_id', 'code' => 400)
        );
        return;
    }
 
    $database = new Database();
    $db = $database->connection();

    $post = new Post($db);
    $post->id = $data->id;
    $post->author = $data->author;
    $post->body = $data->body;
    $post->title = $data->title;
    $post->category_id = $data->category_id;
    $post->update();

    if(!empty($post->message)) {
        echo json_encode(
            array('message' => $post->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Post with ID {$post->id} was successfully updated.", 'code' => 200)
    );
