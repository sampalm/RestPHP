<?php

namespace Source\App\Api;

use Core\Controller;

class Category extends Controller
{
    public function index()
    {
        header("Content-type: application/json; charset=utf-8");

        $cats = (new \Source\Models\Category())->find()->fetch(true);

        if ($cats) {
            $response = array();

            $i = 0;
            foreach ($cats as $cat) {
                $i++;
                $response[$i] = $cat->data();
            }

            echo json_encode($response);
            return;
        }

        echo $this->message->response("Nenhum artigo encontrado", 404)->json();
    }

    public function create(?array $data)
    {
        header("Content-type: application/json; charset=utf-8");

        if (!$data) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $cat = new \Source\Models\Category();
        $cat->name = $data["name"] ?? "";

        if ($cat->save()) {
            echo $this->message->response("Categoria salva com sucesso", 201)->json();
            return;
        }

        echo $cat->message()->json();
    }

    public function update(?array $data)
    {
        header("Content-type: application/json; charset=utf-8");

        if (!$data) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $cat = (new \Source\Models\Category())->findById($data["id"]);
        if (empty($cat)) {
            echo $this->message->response("Categoria não encontrado", 404)->json();
            return;
        }

        $cat->name = $data["name"];

        if ($cat->save()) {
            echo $this->message->response("Categoria atualizada com sucesso", 200)->json();
            return;
        }

        echo $cat->message()->json();
    }

    public function delete(?array $data)
    {
        header("Content-type: application/json; charset=utf-8");

        if (!$data) {
            echo $this->message->response("Dados invalidos", 400)->json();
            return;
        }

        $cat = (new \Source\Models\Category())->findById($data["id"]);
        if (empty($cat)) {
            echo $this->message->response("Categoria não encontrado", 404)->json();
            return;
        }

        if ($cat->destroy()) {
            echo $this->message->response("Categoria removida com sucesso", 200)->json();
            return;
        }

        echo $cat->message()->json();
    }
}
