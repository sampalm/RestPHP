<?php

namespace Source\Models;

use Core\Model;

class Post extends Model
{
    public function __construct()
    {
        parent::__construct("posts", []);
    }

    public function save(): bool
    {
        if (strlen($this->title) < 5) {
            $this->message->response("Erro título do post muito pequeno.", 400);
            return false;
        }

        /** Update */
        if (!empty($this->id)) {
            $Id = $this->id;

            $this->update($this->safe(), "id = :id", "id={$Id}");
            if ($this->fail()) {
                $this->message->response("Erro ao atualizar, verifique os dados", 400);
                return false;
            }
        }

        /** Create */
        if (empty($this->id)) {
            $Id = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->response("Erro ao cadastrar, verifique os dados", 400);
                return false;
            }
        }

        $this->data = ($this->findById($Id))->data();
        return true;
    }
}
