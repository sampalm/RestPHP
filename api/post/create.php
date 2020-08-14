<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data->title)){
        echo json_encode(
            array('message' => 'Invalid or Empty field title', 'code' => 400)
        );
        return;
    }
    if(empty($data->author)){
        echo json_encode(
            array('message' => 'Invalid or Empty field author', 'code' => 400)
        );
        return;
    }
    if(empty($data->category_id)){
        echo json_encode(
            array('message' => 'Invalid or Empty field category_id', 'code' => 400)
        );
        return;
    }

    $database = new Database;
    $db = $database->connection();

    $post = new Post($db);
    $post->title = $data->title;
    $post->author = $data->author;
    $post->body = $data->body;
    $post->category_id = $data->category_id;
    $post->create();

    if(!empty($post->message)) {
        echo json_encode(
            array('message' => $post->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Post was successfully created.", 'code' => 201)
    );