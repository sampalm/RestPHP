<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');

    require '../../config/Database.php';
    require '../../models/Post.php';

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if (empty($id))
    { 
        echo json_encode(
            array('message' => 'Invalid ID', 'code' => 400)
        );
        return;
    }

    $database = new Database();
    $db = $database->connection();

    $post = new Post($db);
    $post->id = $id;
    $post->delete();

    if(!empty($post->message)) {
        echo json_encode(
            array('message' => $post->message, 'code' => 500)
        );
        return;
    }

    echo json_encode(
        array('message' => "Post with ID {$post->id} was successfully deleted.", 'code' => 200)
    );
