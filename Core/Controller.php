<?php

namespace Core;

class Controller {
    public Message $message;

    public function __construct()
    {
        $this->message = new Message();
    }
}