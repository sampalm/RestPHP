<?php

namespace Source\App\Api;

use Core\Controller;

class Post extends Controller
{
    public function index()
    {
        header("Content-type: application/json; charset=utf-8");

        $posts = (new \Source\Models\Post())->find()->fetch(true);

        if ($posts) {
            $response = array();
            $i = 0;
            foreach ($posts as $post) {
                $i++;
                $response[$i] = $post->data();
            }

            echo json_encode($response);
            return;
        }

        echo $this->message->response("Nenhum artigo encontrado", 404)->json();
    }

    public function create(?array $data) 
    {
        header("Content-type: application/json; charset=utf-8");   

        if (empty($data)) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $post = new \Source\Models\Post();
        $post->title = $data["title"] ?? "";
        $post->category_id = $data["category_id"] ?? "";
        $post->body = $data["body"] ?? "";
        $post->author = $data["author"] ?? "";

        if ($post->save()) {
            echo $this->message->response("Dados salvos com sucesso", 201)->json();
            return;
        }

        echo $post->message()->json();
    }

    public function update(?array $data)
    {
        header("Content-type: application/json; charset=utf-8");

        if (empty($data)) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $post = (new \Source\Models\Post())->findById($data["id"]);
        if (empty($post)) {
            echo $this->message->response("Post não encontrado", 400)->json();
            return;
        }

        $post->title = $data["title"] ?? "";
        $post->category_id = $data["category_id"] ?? "";
        $post->body = $data["body"] ?? "";
        $post->author = $data["author"] ?? "";

        if ($post->save()) {
            echo $this->message->response("Dados salvos com sucesso", 200)->json();
            return;
        }

        echo $post->message()->json();
    }

    public function delete(?array $data)
    {
        header("Content-type: application/json; charset=utf-8");

        if (empty($data)) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $post = (new \Source\Models\Post())->findById($data["id"]);
        if (empty($post)) {
            echo $this->message->response("Post não encontrado", 400)->json();
            return;
        }

        if($post->destroy()) {
            echo $this->message->response("Dados removidos com sucesso", 200)->json();
            return;
        }

        echo $post->message()->json();
    }
}
