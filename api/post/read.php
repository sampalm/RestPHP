<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $database = new Database();
    $db = $database->connection();

    $post = new Post($db);
    $result = $post->read();
    $num = $result->rowCount();

    if(!empty($post->message)){
        echo json_encode(
            array('message' => $post->message, 'code' => 500)
        );
        return;
    }

    $posts = array();
    $posts['data'] = array();
    
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        array_push($posts['data'], $post_item);
    }

    $posts['status'] = array('message' => 'Request completed', 'code' => 200);
    echo json_encode($posts);

